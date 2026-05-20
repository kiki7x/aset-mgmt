@extends('layouts.backsite-navtab-aset', [
    'id' => $asset->id,
    'classification_id' => $asset->classification_id,
])

@section('content-tab')
    <div class="tab-content" id="assetTabContent">
        {{-- Overview Section --}}
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <td><strong>Klasifikasi:</strong></td>
                                        <td><span class="badge bg-info text-dark">{{ $asset->category->classification->name ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kategori:</strong></td>
                                        <td><span class="badge bg-info text-dark">{{ $asset->category->name ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td><span class="badge bg-primary">{{ $asset->status->name ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tag:</strong></td>
                                        <td>{{ $asset->tag ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>{{ $asset->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Lokasi:</strong></td>
                                        <td>{{ $asset->location->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Merk/Pabrikan:</strong></td>
                                        <td>{{ $asset->manufacturer->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Model:</strong></td>
                                        <td>{{ $asset->model->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Supplier:</strong></td>
                                        <td>{{ $asset->supplier->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Serial Number:</strong></td>
                                        <td>{{ $asset->serial ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pengelola Aset:</strong></td>
                                        <td>{{ $asset->admin->username ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pengguna Aset:</strong></td>
                                        <td>{{ $asset->user->username ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Waktu Perolehan:</strong></td>
                                        <td>{{ $asset->purchase_date ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Garansi (bulan):</strong></td>
                                        <td>{{ ($asset->warranty_months ?? 'N/A') . ' bulan' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Foto Aset</div>
                        <div class="card-body">
                            {{-- @if (isset($asset->image) && !empty($asset->image))
                                <img src="{{ asset('storage/' . $asset->image) }}" alt="Asset Image" class="img-fluid">
                            @else
                                <p class="text-muted">Belum ada foto.</p>
                            @endif --}}
                            <img src="" alt="Asset Image" id="image" class="img-fluid">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Catatan</div>
                        <div class="card-body">
                            @if (isset($asset->notes) && !empty($asset->notes))
                                <p>{{ $asset->notes }}</p>
                            @else
                                <p class="text-muted">No notes available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Image Preview Modal -->
    <div class="modal fade" id="modalImage" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="imgPreview" src="" style="width:100%">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-foot')
    <script>
        // tampilkan image dar asset->image
        document.getElementById('image').src = "{{ asset('storage/' . $asset->image) }}";
    </script>
@endpush
