@extends('layouts.backsite', [
    'title' => 'Pusat Pengetahuan | SAPA PPL',
    'welcome' => 'Pusat Pengetahuan',
    'breadcrumb' => '
        <li class="breadcrumb-item active">Pusat Pengetahuan</li>
    ',
])

@push('script-head')
    <!-- DataTables CSS (jika belum ada di layout) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Artikel</h3>
            <div class="card-tools">
                <a href="{{ route('admin.knowledge-base.create') }}" class="btn btn-primary btn-sm" data-crud="true">
                    <i class="fas fa-plus"></i> Tambah Artikel
                </a>
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#categoryManagementModal">
                    <i class="fas fa-tags"></i> Manajemen Kategori
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="articlesTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Judul Artikel</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($article->featured_image_url)
                                    <img src="{{ $article->featured_image_url }}" alt="Featured Image {{ $article->title }}" class="img-thumbnail" style="max-width: 80px; max-height: 80px; object-fit: cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('knowledge-base.show', $article->slug) }}" target="_blank" rel="noopener">{{ $article->title }}</a>
                            </td>
                            <td>{{ $article->category->name ?? 'Tidak Ada' }}</td>
                            <td>{{ $article->author->fullname ?? 'Pengguna Tidak Dikenal' }}</td>
                            <td>
                                @if ($article->is_published)
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">Dibuat: {{ $article->created_at->format('d M Y H:i') }}</small>
                                <br>
                                <small class="text-muted">Diperbarui: {{ $article->updated_at->format('d M Y H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a class="mx-3" href="{{ route('admin.knowledge-base.edit', $article->id) }}" data-crud="true">Edit</a></li>
                                            <li>
                                                <form action="{{ route('admin.knowledge-base.destroy', $article->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <span class="mx-3 btn-delete-article" style="cursor:pointer;color:#007bff;" data-id="{{ $article->id }}">Delete</span>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <!-- Category Management Modal -->
    <div class="modal fade" id="categoryManagementModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="categoryManagementModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryManagementModalLabel">Manajemen Kategori Pusat Pengetahuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        @csrf
                        <div class="form-group">
                            <label for="categoryName">Nama Kategori</label>
                            <input type="text" class="form-control" id="categoryName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="categoryDescription">Deskripsi (Opsional)</label>
                            <textarea class="form-control" id="categoryDescription" name="description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" data-crud="true">Tambah Kategori</button>
                    </form>
                    <hr>
                    <h5>Daftar Kategori</h5>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Nama</th>
                        <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="categoryList">
                            @foreach ($categories as $category)
                                <tr id="category-{{ $category->id }}">
                                    <td>
                                        <span class="category-name-display">{{ $category->name }}</span>
                                        <input type="text" class="form-control category-name-edit d-none" value="{{ $category->name }}">
                                        <input type="hidden" class="category-description-edit" value="{{ $category->description }}">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info edit-category" data-id="{{ $category->id }}" data-crud="true">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success save-category d-none" data-id="{{ $category->id }}" data-crud="true">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary cancel-edit-category d-none" data-id="{{ $category->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger delete-category" data-id="{{ $category->id }}" data-crud="true">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script-foot')
    <!-- DataTables JS (jika belum ada di layout) -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <!-- SweetAlert2 (jika belum ada di layout) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            // Initialize DataTables
            $("#articlesTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#articlesTable_wrapper .col-md-6:eq(0)');

            // Handle Article Delete
            $(document).on('click', '.btn-delete-article', function() {
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Artikel ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    <script>
        // --- Category Management (AJAX) ---
        $('#addCategoryForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.knowledge-base.categories.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire('Berhasil!', response.message, 'success');
                    $('#categoryName').val('');
                    $('#categoryDescription').val('');
                    // Add new category to the list
                    let newRow = `<tr id="category-${response.category.id}">
                                        <td>
                                            <span class="category-name-display">${response.category.name}</span>
                                            <input type="text" class="form-control category-name-edit d-none" value="${response.category.name}">
                                            <input type="hidden" class="category-description-edit" value="${response.category.description}">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info edit-category" data-id="${response.category.id}" data-crud="true">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success save-category d-none" data-id="${response.category.id}" data-crud="true">
                                                <i class="fas fa-save"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary cancel-edit-category d-none" data-id="${response.category.id}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-category" data-id="${response.category.id}" data-crud="true">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                    $('#categoryList').append(newRow);
                },
                error: function(response) {
                    Swal.fire('Error!', response.responseJSON.message || 'Terjadi kesalahan!', 'error');
                }
            });
        });

        // Edit Category
        $(document).on('click', '.edit-category', function() {
            let id = $(this).data('id');
            let row = $('#category-' + id);
            row.find('.category-name-display').addClass('d-none');
            row.find('.category-name-edit').removeClass('d-none').focus();
            row.find('.edit-category').addClass('d-none');
            row.find('.delete-category').addClass('d-none');
            row.find('.save-category').removeClass('d-none');
            row.find('.cancel-edit-category').removeClass('d-none');
        });

        // Cancel Edit Category
        $(document).on('click', '.cancel-edit-category', function() {
            let id = $(this).data('id');
            let row = $('#category-' + id);
            row.find('.category-name-display').removeClass('d-none');
            row.find('.category-name-edit').addClass('d-none');
            row.find('.edit-category').removeClass('d-none');
            row.find('.delete-category').removeClass('d-none');
            row.find('.save-category').addClass('d-none');
            row.find('.cancel-edit-category').addClass('d-none');
            // Revert value
            row.find('.category-name-edit').val(row.find('.category-name-display').text());
        });

        // Save Category
        $(document).on('click', '.save-category', function() {
            let id = $(this).data('id');
            let row = $('#category-' + id);
            let newName = row.find('.category-name-edit').val();
            let description = row.find('.category-description-edit').val();

            $.ajax({
                url: `/admin/knowledge-base/categories/${id}`,
                method: "PATCH",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: newName,
                    description: description
                },
                success: function(response) {
                    Swal.fire('Berhasil!', response.message, 'success');
                    row.find('.category-name-display').text(response.category.name).removeClass('d-none');
                    row.find('.category-name-edit').addClass('d-none');
                    row.find('.edit-category').removeClass('d-none');
                    row.find('.delete-category').removeClass('d-none');
                    row.find('.save-category').addClass('d-none');
                    row.find('.cancel-edit-category').addClass('d-none');
                },
                error: function(response) {
                    Swal.fire('Error!', response.responseJSON.message || 'Terjadi kesalahan!', 'error');
                }
            });
        });

        // Delete Category
        $(document).on('click', '.delete-category', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kategori ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/knowledge-base/categories/${id}`,
                        method: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            $('#category-' + id).remove();
                        },
                        error: function(response) {
                            Swal.fire('Error!', response.responseJSON.message || 'Terjadi kesalahan!', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush
