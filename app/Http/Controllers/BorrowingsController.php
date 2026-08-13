<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\BorrowingsModel;
use App\Models\BorrowingItem;
use App\Models\AssetsModel;
use App\Models\LocationsModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BorrowingsController extends Controller
{
    public function index(): View
    {
        $locations = LocationsModel::with('building')->where('status', 'Tersedia')->get();
        $assets = AssetsModel::with('status', 'location', 'classification')
            ->where('classification_id', '!=', 1)
            ->get();
        $users = User::get();

        return view('admin.peminjaman.index', compact('locations', 'assets', 'users'));
    }

    public function getData(Request $request): JsonResponse
    {
        $type = $request->type;

        $borrowings = BorrowingsModel::with('location.building', 'asset', 'items.asset', 'user', 'creator')
            ->when($type, fn($q) => $q->where('type', $type))
            ->latest();

        return DataTables::of($borrowings)
            ->addIndexColumn()
            ->addColumn('borrower', function ($borrowing) {
                $info = e($borrowing->borrower_name);
                if ($borrowerUser = $borrowing->user) {
                    $info .= '<br><small class="text-muted">' . e($borrowerUser->email ?? '') . '</small>';
                }
                if ($borrowing->borrower_nip) {
                    $info .= '<br><small class="text-muted">NIP: ' . e($borrowing->borrower_nip) . '</small>';
                }
                if ($borrowing->borrower_unit) {
                    $info .= '<br><small class="text-muted">Unit: ' . e($borrowing->borrower_unit) . '</small>';
                }
                return $info;
            })
            ->addColumn('item_name', function ($borrowing) {
                if ($borrowing->type === 'ruangan') {
                    $loc = $borrowing->location;
                    return e($loc->name ?? '-') . '<br><small class="text-muted">' . e($loc->building?->name ?? '') . ' Lt ' . e($loc->floor ?? '') . '</small>';
                }
                if ($borrowing->items->isNotEmpty()) {
                    $lines = [];
                    foreach ($borrowing->items as $item) {
                        if ($item->asset) {
                            $lines[] = e($item->asset->name) . ' <small class="text-muted">(' . e($item->asset->tag) . ')</small>';
                        } elseif ($item->item_name) {
                            $lines[] = e($item->item_name) . ' <small class="badge badge-secondary">Non Aset</small>';
                        }
                    }
                    return implode('<br>', $lines);
                }
                $asset = $borrowing->asset;
                return e($asset->name ?? '-') . '<br><small class="text-muted">' . e($asset->tag ?? '') . '</small>';
            })
            ->addColumn('dates', function ($borrowing) {
                $start = Carbon::parse($borrowing->borrow_start)->format('d/m/Y H:i');
                $end = Carbon::parse($borrowing->borrow_end)->format('d/m/Y H:i');
                $html = '<small>Mulai: ' . $start . '</small><br><small>Akhir: ' . $end . '</small>';
                if ($borrowing->return_date) {
                    $html .= '<br><small class="text-success">Dikembalikan: ' . Carbon::parse($borrowing->return_date)->format('d/m/Y H:i') . '</small>';
                }
                return $html;
            })
            ->addColumn('status_badge', function ($borrowing) {
                if ($borrowing->status === 'dipinjam') {
                    $isOverdue = Carbon::now()->gt(Carbon::parse($borrowing->borrow_end));
                    if ($isOverdue) {
                        return '<span class="badge badge-danger">Terlambat</span>';
                    }
                    return '<span class="badge badge-warning">Dipinjam</span>';
                }
                return '<span class="badge badge-success">Dikembalikan</span>';
            })
            ->addColumn('action', function ($borrowing) {
                $buttons = '<div class="btn-group">';
                $buttons .= '<button type="button" class="btn btn-sm btn-info btn-show-borrowing" data-id="' . $borrowing->id . '" title="Lihat Detail"><i class="fas fa-eye"></i></button>';
                $buttons .= '<button type="button" class="btn btn-sm btn-secondary btn-print-borrowing" data-id="' . $borrowing->id . '" title="Cetak" onclick="window.open(\'' . route('admin.peminjaman.print', $borrowing->id) . '\', \'_blank\')"><i class="fas fa-print"></i></button>';
                if ($borrowing->status === 'dipinjam') {
                    $buttons .= '<button type="button" class="btn btn-sm btn-success btn-return-borrowing" data-id="' . $borrowing->id . '" data-name="' . e($borrowing->borrower_name) . '" title="Kembalikan"><i class="fas fa-undo"></i></button>';
                }
                $buttons .= '</div>';
                return $buttons;
            })
            ->rawColumns(['borrower', 'item_name', 'dates', 'status_badge', 'action'])
            ->make(true);
    }

    public function store(Request $request): JsonResponse
    {
        $type = $request->input('type');

        $rules = [
            'type' => 'required|in:ruangan,barang',
            'borrower_name' => 'required|string|max:255',
            'borrower_nip' => 'nullable|string|max:64',
            'borrower_unit' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'borrow_start' => 'required|date',
            'borrow_end' => 'required|date|after_or_equal:borrow_start',
            'purpose' => 'required|string',
            'notes' => 'nullable|string',
        ];

        if ($type === 'ruangan') {
            $rules['location_id'] = 'required|exists:locations,id';
        } elseif ($type === 'barang') {
            $rules['asset_ids'] = 'required|array|min:1';
            $rules['asset_ids.*'] = [
                'max:255',
                function ($attribute, $value, $fail) {
                    $value = trim((string) $value);
                    if ($value !== '' && ctype_digit($value) && ! AssetsModel::whereKey((int) $value)->exists()) {
                        $fail('Barang yang dipilih tidak valid.');
                    }
                },
            ];
        }

        $messages = [
            'borrower_name.required' => 'Nama peminjam wajib diisi.',
            'borrow_start.required' => 'Tanggal mulai wajib diisi.',
            'borrow_start.date' => 'Tanggal mulai tidak valid.',
            'borrow_end.required' => 'Tanggal akhir wajib diisi.',
            'borrow_end.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
            'purpose.required' => 'Tujuan peminjaman wajib diisi.',
            'location_id.required' => 'Ruangan wajib dipilih.',
            'location_id.exists' => 'Ruangan yang dipilih tidak valid.',
            'asset_ids.required' => 'Barang wajib dipilih.',
            'asset_ids.min' => 'Minimal pilih 1 barang.',
            'asset_ids.*.exists' => 'Barang yang dipilih tidak valid.',
        ];

        $request->validate($rules, $messages);

        $data = [
            'type' => $type,
            'borrower_name' => $request->borrower_name,
            'borrower_nip' => $request->borrower_nip,
            'borrower_unit' => $request->borrower_unit,
            'user_id' => $request->user_id,
            'borrow_start' => $request->borrow_start,
            'borrow_end' => $request->borrow_end,
            'purpose' => $request->purpose,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ];

        if ($type === 'ruangan') {
            $location = LocationsModel::findOrFail($request->location_id);
            $data['location_id'] = $location->id;
            $borrowing = BorrowingsModel::create($data);
            $location->update(['status' => 'Dipinjam']);
        } elseif ($type === 'barang') {
            $assetIds = [];
            $itemNames = [];
            foreach ((array) $request->input('asset_ids') as $value) {
                $value = trim((string) $value);
                if ($value === '') {
                    continue;
                }
                if (ctype_digit($value)) {
                    $assetIds[] = (int) $value;
                } else {
                    $itemNames[] = $value;
                }
            }

            $borrowing = BorrowingsModel::create($data);
            $newStatusLabel = \App\Models\LabelsModel::where('name', 'Dipinjam')->first();

            foreach ($assetIds as $assetId) {
                $asset = AssetsModel::find($assetId);
                if (! $asset) {
                    continue;
                }
                BorrowingItem::create([
                    'borrowing_id' => $borrowing->id,
                    'asset_id' => $asset->id,
                    'original_asset_status' => $asset->status_id,
                ]);
                if ($newStatusLabel) {
                    $asset->update(['status_id' => $newStatusLabel->id]);
                }
            }

            foreach ($itemNames as $itemName) {
                BorrowingItem::create([
                    'borrowing_id' => $borrowing->id,
                    'asset_id' => null,
                    'item_name' => $itemName,
                    'original_asset_status' => null,
                ]);
            }
        }

        return response()->json([
            'message' => 'Peminjaman berhasil dibuat.',
        ]);
    }

    public function show($id): JsonResponse
    {
        $borrowing = BorrowingsModel::with('location.building', 'asset', 'items.asset', 'user', 'creator')
            ->findOrFail($id);

        return response()->json($borrowing);
    }

    public function getAvailableLocations(Request $request): JsonResponse
    {
        $locations = LocationsModel::with('building')
            ->where('status', 'Tersedia')
            ->get();

        return response()->json($locations);
    }

    public function getAvailableAssets(Request $request): JsonResponse
    {
        $borrowedAssetIds = BorrowingItem::whereHas('borrowing', function ($q) {
            $q->where('type', 'barang')->where('status', 'dipinjam');
        })->whereNotNull('asset_id')->pluck('asset_id')->toArray();

        $assets = AssetsModel::with('status', 'classification', 'location')
            ->whereNotIn('id', $borrowedAssetIds)
            ->where('classification_id', '!=', 1)
            ->get();

        return response()->json($assets);
    }

    public function returnForm($id): JsonResponse
    {
        $borrowing = BorrowingsModel::with('location.building', 'asset', 'user')
            ->findOrFail($id);

        return response()->json($borrowing);
    }

    public function processReturn(Request $request, $id): JsonResponse
    {
        $request->validate([
            'return_photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'return_photo.required' => 'Foto pengembalian wajib diupload.',
            'return_photo.image' => 'File harus berupa gambar.',
            'return_photo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'return_photo.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $borrowing = BorrowingsModel::findOrFail($id);

        $photoPath = null;
        if ($request->hasFile('return_photo')) {
            $photo = $request->file('return_photo');
            $photoPath = $photo->store('borrowing_returns', 'public');
        }

        $borrowing->update([
            'return_date' => Carbon::now(),
            'status' => 'dikembalikan',
            'return_photo' => $photoPath,
        ]);

        if ($borrowing->type === 'ruangan' && $borrowing->location) {
            $borrowing->location->update(['status' => 'Tersedia']);
        } elseif ($borrowing->type === 'barang') {
            foreach ($borrowing->items as $item) {
                if ($item->asset) {
                    $item->asset->update(['status_id' => $item->original_asset_status]);
                }
            }
            if ($borrowing->items->isEmpty() && $borrowing->asset) {
                $borrowing->asset->update(['status_id' => $borrowing->original_asset_status]);
            }
        }

        return response()->json([
            'message' => 'Pengembalian berhasil diproses.',
        ]);
    }

    public function print($id): View
    {
        $borrowing = BorrowingsModel::with('location.building', 'asset.classification', 'asset.category', 'items.asset.classification', 'items.asset.category', 'user', 'creator')
            ->findOrFail($id);

        return view('admin.peminjaman.print', compact('borrowing'));
    }
}
