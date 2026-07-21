<?php

namespace App\Http\Controllers;

use App\DTOs\VehicleEntryData;
use App\Http\Requests\StoreVehicleEntryRequest;
use App\Repositories\Contracts\VehicleEntryRepositoryInterface;
use App\Services\VehicleEntryFormService;
use App\Support\PdfDocumentSupport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class VehicleEntryController extends Controller
{
    public function __construct(
        private readonly VehicleEntryFormService $formService,
        private readonly VehicleEntryRepositoryInterface $repository,
        private readonly PdfDocumentSupport $pdfDocumentSupport,
    ) {
    }

    public function index()
    {
        return view('vehicle.index', [
            'nextJobOrderNo' => $this->repository->nextJobOrderNumber(),
        ]);
    }

    /**
     * AJAX endpoint the form submits to. Returns JSON so the front-end can
     * stay on the page, show a success state, and then hit the PDF route.
     */
    public function store(StoreVehicleEntryRequest $request): JsonResponse
    {
        $dto = VehicleEntryData::fromRequest($request->validated());

        $entry = $this->formService->store($dto);

        return response()->json([
            'success'  => true,
            'message'  => 'Job order saved successfully.',
            'entry_id' => $entry->id,
            'pdf_url'  => route('vehicle-entries.pdf', $entry->id),
        ]);
    }

    /**
     * Renders the stored record as a PDF using the same visual layout as
     * the on-screen form (see resources/views/vehicle/pdf.blade.php).
     */
    public function pdf(int $id): Response
    {
        $entry = $this->repository->findWithRelations($id);
        $this->pdfDocumentSupport->prepareDompdfStorage();

        $pdf = Pdf::loadView('vehicle.pdf', [
            'entry' => $entry,
            'pdfSupport' => $this->pdfDocumentSupport,
        ])
            ->setPaper('a4', 'portrait');

        $filename = 'job-order-' . $entry->job_order_no . '.pdf';

        // download() (not stream()) sends Content-Disposition: attachment,
        // which makes the form's hidden <a download> click actually save the
        // file instead of just opening the PDF inline in a new tab.
        return $pdf->download($filename);
    }
}
