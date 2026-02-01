<?php

namespace App\Http\Controllers\Inventory\QualityControl;

use App\Http\Controllers\Controller;
use App\Models\Inventory\QualityControl;
use App\Http\Requests\Inventory\QualityControl\StoreQualityControlRequest;
use App\Http\Requests\Inventory\QualityControl\ApproveQualityControlRequest;
use App\Http\Requests\Inventory\QualityControl\RejectQualityControlRequest;
use App\Http\Resources\Inventory\QualityControl\QualityControlResource;
use App\Http\Resources\Inventory\QualityControl\QualityControlCollection;
use App\Services\Inventory\QualityControl\QualityControlService;
use App\Support\ApiMeta;
use App\Support\HttpStatus;
use Illuminate\Http\Request;
use App\Models\Inventory\Receiving;
use Illuminate\Support\Facades\DB;

class QualityControlController extends Controller
{
    public function __construct(
        protected QualityControlService $service
    ) {}

    /* =====================
     | LIST QC
     |=====================*/
    public function index(Request $request)
    {
        $this->authorize('viewAny', QualityControl::class);

        $query = QualityControl::query()
            ->with(['barang', 'warehouse', 'location'])
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Quality Control',
            'data'    => new QualityControlCollection(
                $query->paginate($request->integer('per_page', 20))
            ),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    /* =====================
     | STORE QC
     |=====================*/
    public function store(StoreQualityControlRequest $request)
{
    $this->authorize('create', QualityControl::class);

    return DB::transaction(function () use ($request) {

        $receiving = Receiving::lockForUpdate()
            ->findOrFail($request->receiving_id);

        if ($receiving->status !== 'RECEIVED') {
            return response()->json([
                'success' => false,
                'message' => 'Receiving belum disetujui, QC belum dapat diajukan',
                'meta'    => ApiMeta::withTimestamp(),
            ], HttpStatus::UNPROCESSABLE_ENTITY);
        }

        $existingQc = QualityControl::where('receiving_id', $receiving->id)
            ->whereIn('status', ['PENDING', 'APPROVED'])
            ->first();

        if ($existingQc) {
            return response()->json([
                'success' => false,
                'message' => 'QC untuk receiving ini sudah ada',
                'meta'    => ApiMeta::withTimestamp(),
            ], HttpStatus::UNPROCESSABLE_ENTITY);
        }

        $qc = QualityControl::create([
            'receiving_id' => $receiving->id,
            'warehouse_id' => $receiving->warehouse_id,
            'location_id'  => $receiving->location_id,
            'barang_id'    => $receiving->barang_id,
            'qty_received' => $receiving->jumlah,
            'status'       => 'PENDING',
            'requested_by' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'QC diajukan',
            'data'    => new QualityControlResource($qc),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::CREATED);
    });
}

    /* =====================
     | APPROVE QC
     |=====================*/
    public function approve(
        QualityControl $qc,
        ApproveQualityControlRequest $request
    ) {
        $this->authorize('approve', $qc);

        $this->service->approve(
            qc: $qc,
            qtyAccepted: $request->qty_accepted,
            qtyRejected: $request->qty_rejected,
            userId: $request->user()->id
        );

        return response()->json([
            'success' => true,
            'message' => 'QC disetujui',
            'data'    => new QualityControlResource($qc->fresh()),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    /* =====================
     | REJECT QC
     |=====================*/
    public function reject(
        QualityControl $qc,
        RejectQualityControlRequest $request
    ) {
        $this->authorize('reject', $qc);

        $this->service->reject(
            qc: $qc,
            alasan: $request->alasan,
            userId: $request->user()->id
        );

        return response()->json([
            'success' => true,
            'message' => 'QC ditolak',
            'data'    => new QualityControlResource($qc->fresh()),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }

    /* =====================
     | DETAIL
     |=====================*/
    public function show(QualityControl $qc)
    {
        $this->authorize('view', $qc);

        return response()->json([
            'success' => true,
            'data'    => new QualityControlResource($qc),
            'meta'    => ApiMeta::withTimestamp(),
        ], HttpStatus::OK);
    }
}
