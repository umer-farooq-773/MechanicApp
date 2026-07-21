<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class PdfDocumentSupport
{
    /**
     * @var array<string, array{0: string, 1: string, 2: ?string, 3: ?string}>
     */
    private const ARABIC_FORMS = [
        'ء' => ['ﺀ', 'ﺀ', null, null],
        'آ' => ['ﺁ', 'ﺂ', null, null],
        'أ' => ['ﺃ', 'ﺄ', null, null],
        'ؤ' => ['ﺅ', 'ﺆ', null, null],
        'إ' => ['ﺇ', 'ﺈ', null, null],
        'ئ' => ['ﺉ', 'ﺊ', 'ﺋ', 'ﺌ'],
        'ا' => ['ﺍ', 'ﺎ', null, null],
        'ب' => ['ﺏ', 'ﺐ', 'ﺑ', 'ﺒ'],
        'ة' => ['ﺓ', 'ﺔ', null, null],
        'ت' => ['ﺕ', 'ﺖ', 'ﺗ', 'ﺘ'],
        'ث' => ['ﺙ', 'ﺚ', 'ﺛ', 'ﺜ'],
        'ج' => ['ﺝ', 'ﺞ', 'ﺟ', 'ﺠ'],
        'ح' => ['ﺡ', 'ﺢ', 'ﺣ', 'ﺤ'],
        'خ' => ['ﺥ', 'ﺦ', 'ﺧ', 'ﺨ'],
        'د' => ['ﺩ', 'ﺪ', null, null],
        'ذ' => ['ﺫ', 'ﺬ', null, null],
        'ر' => ['ﺭ', 'ﺮ', null, null],
        'ز' => ['ﺯ', 'ﺰ', null, null],
        'س' => ['ﺱ', 'ﺲ', 'ﺳ', 'ﺴ'],
        'ش' => ['ﺵ', 'ﺶ', 'ﺷ', 'ﺸ'],
        'ص' => ['ﺹ', 'ﺺ', 'ﺻ', 'ﺼ'],
        'ض' => ['ﺽ', 'ﺾ', 'ﺿ', 'ﻀ'],
        'ط' => ['ﻁ', 'ﻂ', 'ﻃ', 'ﻄ'],
        'ظ' => ['ﻅ', 'ﻆ', 'ﻇ', 'ﻈ'],
        'ع' => ['ﻉ', 'ﻊ', 'ﻋ', 'ﻌ'],
        'غ' => ['ﻍ', 'ﻎ', 'ﻏ', 'ﻐ'],
        'ف' => ['ﻑ', 'ﻒ', 'ﻓ', 'ﻔ'],
        'ق' => ['ﻕ', 'ﻖ', 'ﻗ', 'ﻘ'],
        'ك' => ['ﻙ', 'ﻚ', 'ﻛ', 'ﻜ'],
        'ل' => ['ﻝ', 'ﻞ', 'ﻟ', 'ﻠ'],
        'م' => ['ﻡ', 'ﻢ', 'ﻣ', 'ﻤ'],
        'ن' => ['ﻥ', 'ﻦ', 'ﻧ', 'ﻨ'],
        'ه' => ['ﻩ', 'ﻪ', 'ﻫ', 'ﻬ'],
        'و' => ['ﻭ', 'ﻮ', null, null],
        'ى' => ['ﻯ', 'ﻰ', null, null],
        'ي' => ['ﻱ', 'ﻲ', 'ﻳ', 'ﻴ'],
    ];

    public function prepareDompdfStorage(): void
    {
        File::ensureDirectoryExists(storage_path('fonts'));

        $this->forgetBrokenFontCache();
    }

    public function publicDataUri(string $relativePath): ?string
    {
        return $this->fileDataUri(public_path($relativePath));
    }

    public function publicDiskDataUri(?string $relativePath): ?string
    {
        if (! $relativePath) {
            return null;
        }

        return $this->fileDataUri(Storage::disk('public')->path($relativePath));
    }

    public function fileDataUri(string $path): ?string
    {
        if (! File::isFile($path)) {
            return null;
        }

        $mimeType = File::mimeType($path) ?: 'application/octet-stream';

        return "data:{$mimeType};base64," . base64_encode(File::get($path));
    }

    public function arabic(string $text): string
    {
        if (! preg_match('/\p{Arabic}/u', $text)) {
            return $text;
        }

        $tokens = preg_split('/(\s+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        if ($tokens === false) {
            throw new RuntimeException('Unable to split Arabic text for PDF rendering.');
        }

        $shapedTokens = array_map(fn (string $token): string => preg_match('/^\s+$/u', $token)
            ? $token
            : $this->shapeArabicToken($token), $tokens);

        return implode('', array_reverse($shapedTokens));
    }

    private function forgetBrokenFontCache(): void
    {
        $cacheFile = storage_path('fonts/dompdf_font_family_cache.php');

        if (! File::isFile($cacheFile)) {
            return;
        }

        $cache = File::get($cacheFile);
        preg_match_all('/[A-Z]:\\\\[^\'"]+?\.(?:ufm|afm|ttf|otf)|\/[^\'"]+?\.(?:ufm|afm|ttf|otf)/i', $cache, $matches);

        foreach ($matches[0] ?? [] as $path) {
            if (! File::exists(str_replace('\\\\', '\\', $path))) {
                File::delete($cacheFile);

                return;
            }
        }
    }

    private function shapeArabicToken(string $token): string
    {
        $characters = preg_split('//u', $token, -1, PREG_SPLIT_NO_EMPTY);

        if ($characters === false) {
            throw new RuntimeException('Unable to split Arabic token for PDF rendering.');
        }

        $shaped = [];
        $count = count($characters);

        for ($index = 0; $index < $count; $index++) {
            $character = $characters[$index];

            if (! $this->isArabicLetter($character)) {
                $shaped[] = $character;

                continue;
            }

            $previous = $this->previousArabicLetter($characters, $index);
            $next = $this->nextArabicLetter($characters, $index);
            $joinsBefore = $previous !== null
                && $this->connectsAfter($previous)
                && $this->connectsBefore($character);
            $joinsAfter = $next !== null
                && $this->connectsAfter($character)
                && $this->connectsBefore($next);

            $forms = self::ARABIC_FORMS[$character];

            $shaped[] = match (true) {
                $joinsBefore && $joinsAfter && $forms[3] !== null => $forms[3],
                $joinsAfter && $forms[2] !== null => $forms[2],
                $joinsBefore => $forms[1],
                default => $forms[0],
            };
        }

        return implode('', array_reverse($shaped));
    }

    /**
     * @param  array<int, string>  $characters
     */
    private function previousArabicLetter(array $characters, int $index): ?string
    {
        for ($cursor = $index - 1; $cursor >= 0; $cursor--) {
            if ($this->isArabicLetter($characters[$cursor])) {
                return $characters[$cursor];
            }

            if (! preg_match('/[\x{064B}-\x{065F}\x{0670}]/u', $characters[$cursor])) {
                return null;
            }
        }

        return null;
    }

    /**
     * @param  array<int, string>  $characters
     */
    private function nextArabicLetter(array $characters, int $index): ?string
    {
        $count = count($characters);

        for ($cursor = $index + 1; $cursor < $count; $cursor++) {
            if ($this->isArabicLetter($characters[$cursor])) {
                return $characters[$cursor];
            }

            if (! preg_match('/[\x{064B}-\x{065F}\x{0670}]/u', $characters[$cursor])) {
                return null;
            }
        }

        return null;
    }

    private function isArabicLetter(string $character): bool
    {
        return array_key_exists($character, self::ARABIC_FORMS);
    }

    private function connectsBefore(string $character): bool
    {
        return $this->isArabicLetter($character) && self::ARABIC_FORMS[$character][1] !== null;
    }

    private function connectsAfter(string $character): bool
    {
        return $this->isArabicLetter($character) && self::ARABIC_FORMS[$character][2] !== null;
    }
}
