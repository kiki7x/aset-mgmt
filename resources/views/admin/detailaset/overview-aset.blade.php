@extends('layouts.backsite-navtab-aset', [
    'id' => $asset->id,
    'classification_id' => $asset->classification_id,
])

@section('content-tab')
    <div class="tab-content" id="assetTabContent">
        {{-- Overview Section --}}
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
            <div class="row mt-3">
                <div class="col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
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
                                            <td><strong>Lokasi:</strong></td>
                                            <td>{{ $asset->location->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pengguna Aset:</strong></td>
                                            <td>{{ $asset->user->username ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $asset->name ?? 'N/A' }}</td>
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
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Foto Aset</div>
                        <div class="card-body text-center">
                            @php
                                $imageUrl = null;
                                try {
                                    if (!empty($asset->image) && \Illuminate\Support\Facades\Storage::disk('public')->exists($asset->image)) {
                                        $imageUrl = asset('storage/' . $asset->image);
                                    } elseif (!empty($asset->image) && file_exists(public_path($asset->image))) {
                                        $imageUrl = asset($asset->image);
                                    }
                                } catch (Exception $e) {
                                    $imageUrl = null;
                                }
                            @endphp

                            @if ($imageUrl)
                                <img src="{{ $imageUrl }}" alt="Asset Image" id="image" class="img-fluid" style="max-height:300px; cursor:pointer" data-toggle="modal" data-target="#modalImage"
                                     onclick="document.getElementById('imgPreview').src='{{ $imageUrl }}'">
                            @else
                                <p class="text-muted">Belum ada foto.</p>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Lisensi</div>
                        <div class="card-body">
                            @if ($asset->licenses->count())
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Tag</th>
                                                <th>Kategori</th>
                                                <th>Nama</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($asset->licenses as $license)
                                                <tr>
                                                    <td>{{ $license->tag }}</td>
                                                    <td>{{ $license->category->name ?? 'N/A' }}</td>
                                                    <td>{{ $license->name }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-danger btn-detach-license"
                                                            data-license-id="{{ $license->id }}"
                                                            data-license-name="{{ $license->name }}">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted mb-0">Tidak ada lisensi terkait.</p>
                            @endif
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
        $(document).ready(function() {
            $(document).on('click', '.btn-detach-license', function() {
                const licenseId = $(this).data('license-id');
                const licenseName = $(this).data('license-name');

                Swal.fire({
                    title: 'Hapus Lisensi',
                    text: `Apakah Anda yakin ingin menghapus lisensi "${licenseName}" dari aset ini?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.license.detach_asset', ['id' => ':licenseId', 'assetId' => $asset->id]) }}".replace(':licenseId', licenseId),
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message || 'Gagal menghapus lisensi.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
