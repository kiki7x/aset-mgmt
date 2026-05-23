@extends('layouts.backsite', [
    'title' => 'Edit Artikel Knowledge Base | SAPA PPL',
    'welcome' => 'Edit Artikel',
    'breadcrumb' => '
        <li class="breadcrumb-item"><a href="' . route('admin.knowledge-base') . '">Knowledge Base</a></li>
        <li class="breadcrumb-item active">Edit Artikel</li>
    '
])

@push('script-head')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Artikel</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ route('admin.knowledge-base.update', $article->id) }}" method="POST">
                        @csrf
                        @method('PATCH') {{-- Menggunakan metode PATCH untuk update --}}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Judul Artikel</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $article->title) }}" required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_id">Kategori</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="content">Konten Artikel</label>
                                <textarea id="summernote" name="content" class="form-control @error('content') is-invalid @enderror">{{ old('content', $article->content) }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Perbarui Artikel</button>
                            <a href="{{ route('admin.knowledge-base') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
@endsection

@push('script-foot')
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
                placeholder: 'Tulis konten artikel di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        for (let i = 0; i < files.length; i++) {
                            uploadImage(files[i]);
                        }
                    }
                }
            });

            function uploadImage(file) {
                let data = new FormData();
                data.append("image", file);
                data.append("_token", "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('admin.knowledge-base.upload-image') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: "POST",
                    success: function(response) {
                        if (response.url) {
                            $('#summernote').summernote('insertImage', response.url);
                        } else {
                            console.error('URL gambar tidak ditemukan dalam respons:', response);
                            alert('Gagal mengunggah gambar.');
                        }
                    },
                    error: function(data) {
                        console.error(data);
                        alert('Terjadi kesalahan saat mengunggah gambar.');
                    }
                });
            }
        });
    </script>
@endpush