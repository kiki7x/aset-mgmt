@extends('layouts.backsite-navtab-aset', [
    'id' => $asset->id,
    'classification_id' => $asset->classification_id
])

@section('content-tab')
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUploadFile">
            <i class="fas fa-upload"></i> Upload File
        </button>
    </div>

    <ul class="todo-list" id="fileslist" style="display:flex;flex-wrap:wrap;padding:0;list-style:none;">
        @forelse ($asset->files as $file)
            @php
                $ext = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
                switch ($ext) {
                    case 'pdf':
                        $icon = 'far fa-file-pdf text-danger';
                        break;
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                        $icon = 'far fa-file-image text-primary';
                        break;
                    default:
                        $icon = 'far fa-file text-muted';
                        break;
                }
                $filePath = storage_path('app/public/' . $file->file);
                $size = file_exists($filePath) ? filesize($filePath) : 0;
                if ($size >= 1048576) {
                    $formatted = number_format($size / 1048576, 2) . ' MB';
                } elseif ($size >= 1024) {
                    $formatted = number_format($size / 1024, 2) . ' KB';
                } else {
                    $formatted = $size . ' B';
                }
            @endphp
            <li class="border bg-white shadow-sm rounded m-2 p-2" style="width:260px;height:70px;">
                <div class="row align-items-center flex-nowrap h-100">
                    <div class="col-2 text-center px-0">
                        <i class="{{ $icon }} fa-2x"></i>
                    </div>
                    <div class="col-10 pl-2 overflow-hidden">
                        <div class="text-truncate" style="font-weight:500;font-size:14px;">
                            {{ $file->name }}
                        </div>
                        <small class="text-muted">
                            {{ $formatted }} ● {{ $file->created_at ? \Carbon\Carbon::parse($file->created_at)->format('d M Y') : '-' }}
                        </small>
                        <div class="float-right mt-1">
                            <a href="{{ asset('storage/' . $file->file) }}" target="_blank" class="text-dark mr-1"><i class="fa fa-eye"></i></a>
                            <a href="{{ asset('storage/' . $file->file) }}" download class="text-dark mr-1"><i class="fa fa-download"></i></a>
                            <a href="#" class="text-red btn-delete-file" data-file-id="{{ $file->id }}" data-file-name="{{ $file->name }}"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="w-100 text-center py-4 text-muted" style="list-style:none;">Belum ada file.</li>
        @endforelse
    </ul>

    <div class="modal fade" id="modalUploadFile" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload File</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formUploadFile" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fileName">Nama File <small class="text-muted">(opsional)</small></label>
                            <input type="text" class="form-control" id="fileName" name="name" placeholder="Kosongkan untuk gunakan nama asli file">
                        </div>
                        <div class="form-group">
                            <label for="fileInput">Pilih File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="fileInput" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
                                <label class="custom-file-label" for="fileInput">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">Tipe file: PDF, JPG, JPEG, PNG. Maks 10 MB.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-foot')
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();

            $('#formUploadFile').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.' . ($asset->classification_id == 2 ? 'asettik' : 'asetrt') . '.files.upload', $asset->id) }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Mengupload...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        $('#modalUploadFile').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        const msg = xhr.responseJSON?.message || 'Gagal mengupload file.';
                        Swal.fire('Gagal!', msg, 'error');
                    }
                });
            });

            $(document).on('click', '.btn-delete-file', function() {
                const fileId = $(this).data('file-id');
                const fileName = $(this).data('file-name');

                Swal.fire({
                    title: 'Hapus File',
                    text: `Apakah Anda yakin ingin menghapus file "${fileName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.' . ($asset->classification_id == 2 ? 'asettik' : 'asetrt') . '.files.delete', ['id' => $asset->id, 'fileId' => ':fileId']) }}".replace(':fileId', fileId),
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
                                Swal.fire('Gagal!', xhr.responseJSON?.message || 'Gagal menghapus file.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush