@extends('layouts.backsite-navtab-license', [
    'id' => $license->id,
])

@push('script-head')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@section('content-tab')
    <div class="tab-content" id="licenseTabContent">
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <td><strong>Tag:</strong></td>
                                            <td>{{ $license->tag ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nama Lisensi:</strong></td>
                                            <td>{{ $license->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Serial:</strong></td>
                                            <td>{{ $license->serial ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td><span class="badge bg-primary">{{ $license->status->name ?? 'N/A' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Kategori:</strong></td>
                                            <td><span class="badge bg-info text-dark">{{ $license->category->name ?? 'N/A' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Supplier:</strong></td>
                                            <td>{{ $license->supplier->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Seats:</strong></td>
                                            <td>{{ $license->seats ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Dibuat:</strong></td>
                                            <td>{{ $license->created_at ? \Carbon\Carbon::parse($license->created_at)->format('d M Y H:i') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Diupdate:</strong></td>
                                            <td>{{ $license->updated_at ? \Carbon\Carbon::parse($license->updated_at)->format('d M Y H:i') : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-link"></i> Aset Terkait
                            <div class="card-tools">
                                <button type="button" id="btnOpenAssignModal" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="Sematkan Aset">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                    <table id="tableAssignedAssets" class="table table-bordered table-striped table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tag</th>
                                            <th>Kategori</th>
                                            <th>Model</th>
                                            <th>Nama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Catatan</div>
                        <div class="card-body">
                            @if (isset($license->notes) && !empty($license->notes))
                                <p>{{ $license->notes }}</p>
                            @else
                                <p class="text-muted">Tidak ada catatan.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Assign Asset --}}
    <div id="assignModal" title="Tambah Aset ke Lisensi" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Aset ke Lisensi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cari dan pilih aset:</label>
                        <select id="selectAssets" class="form-control select2" multiple="multiple" style="width: 100%;"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" id="btnAttachAssets" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-foot')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        function initAssignedAssetsTable() {
            $('#tableAssignedAssets').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                paging: false,
                info: false,
                searching: false,
                ajax: `{{ url('admin/license') }}/{{ $id }}/get-assets`,
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
                    { data: 'tag', name: 'tag' },
                    { data: 'category', name: 'category', searchable: false, orderable: false },
                    { data: 'model', name: 'model', searchable: false, orderable: false },
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'asc']],
            });
        }

        function initSelect2Assets() {
            $('#selectAssets').select2({
                dropdownParent: $('#assignModal'),
                ajax: {
                    url: `{{ url('admin/license') }}/{{ $id }}/select2-assets`,
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return { results: data.results };
                    },
                    cache: true
                },
                placeholder: 'Cari aset...',
                minimumInputLength: 1,
                multiple: true,
            });
        }

        $(document).ready(function() {
            initAssignedAssetsTable();

            $('#btnOpenAssignModal').on('click', function() {
                $('#assignModal').modal('show');
            });

            $('#assignModal').on('shown.bs.modal', function() {
                if (!$('#selectAssets').hasClass('select2-hidden-accessible')) {
                    initSelect2Assets();
                }
            });

            $('#assignModal').on('hidden.bs.modal', function() {
                $('#selectAssets').val(null).trigger('change');
                $('#selectAssets').select2('destroy');
            });

            $('#btnAttachAssets').on('click', function() {
                let selectedIds = $('#selectAssets').val();

                if (!selectedIds || selectedIds.length === 0) {
                    Swal.fire({ icon: 'warning', title: 'Pilih aset', text: 'Silakan pilih aset yang akan ditambahkan.' });
                    return;
                }

                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: `{{ url('admin/license') }}/{{ $id }}/attach-asset`,
                    type: 'POST',
                    data: { asset_ids: selectedIds },
                    success: function(response) {
                        $('#assignModal').modal('hide');
                        $('#tableAssignedAssets').DataTable().ajax.reload();
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Aset berhasil ditambahkan.' });
                    },
                    error: function(xhr) {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat menambahkan aset.' });
                    }
                });
            });

            $('#tableAssignedAssets').on('click', '.btn-detach-asset', function() {
                const assetId = $(this).data('asset-id');
                const assetName = $(this).data('asset-name');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Hapus aset "${assetName}" dari lisensi ini?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            url: `{{ url('admin/license') }}/{{ $id }}/detach-asset/${assetId}`,
                            type: 'DELETE',
                            success: function(response) {
                                $('#tableAssignedAssets').DataTable().ajax.reload();
                                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Aset berhasil dihapus.' });
                            },
                            error: function(xhr) {
                                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan.' });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
