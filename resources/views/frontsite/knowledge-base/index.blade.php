@extends('layouts.front', ['title' => 'Knowledge Base - SAPA PPL'])

@push('script-head')
    @stack('script-head')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero-custom section dark-background"></section>

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container">
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="">Layanan</li>
                        <li class="current">Pusat Pengetahuan</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <section id="recent-blog-postst" class="recent-blog-postst section">
            <div class="container">
                <h2 class="text-center">Pusat Pengetahuan</h2>
                <p class="text-center">Artikel panduan dan dokumentasi untuk membantu pengguna memanfaatkan aset di lingkungan Poltekpar Lombok.</p>
            </div>

            <div class="container">
                <div class="row">
                    @foreach ($articles as $article)
                        <div class="col-xl-4 col-md-6">
                            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">
                                <div class="post-img position-relative overflow-hidden">
                                    <img src="{{ $article->featured_image_url ?? asset('arsha/assets/img/news-placeholder.jpg') }}" class="card-img-top" alt="" style="object-fit:cover; height:250px;">
                                    <span class="post-date">{{ $article->created_at->format('F d') }}</span>
                                </div>
                                <div class="post-content d-flex flex-column">
                                    <h3 class="post-title">{{ $article->title }}</h3>
                                    <div class="meta d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person"></i> <span class="ps-2">{{ $article->author->name ?? 'Poltekpar' }}</span>
                                        </div>
                                        <span class="px-3 text-black-50">/</span>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-folder2"></i> <span class="ps-2">{{ $article->category->name ?? 'Uncategorized' }}</span>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <p class="card-text" style="flex:1">{{ Str::limit(strip_tags($article->content), 140) }}</p>
                                    <a href="{{ route('knowledge-base.show', $article->slug) }}" class="readmore stretched-link"><span>Selengkapnya</span><i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div><!-- End post item -->
                    @endforeach
                </div>
            </div>

            <div class="modal fade" id="modalDetailArticle">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="d_article_title"></h5>
                            &nbsp;
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Judul</th>
                                    <td id="d_article_title_text"></td>
                                </tr>
                                <tr>
                                    <th>Penulis</th>
                                    <td id="d_article_author"></td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td id="d_article_date"></td>
                                </tr>
                                <tr>
                                    <th>Konten</th>
                                    <td id="d_article_content"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Services Section -->
    </main><!-- End #main -->
@endsection

@push('script-foot')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tableKnowledge').DataTable({
                processing: false,
                serverSide: false,
                responsive: true,
                pageLength: 10,
                lengthChange: false
            });

            $(document).on('click', '.lihat-article', function(e) {
                e.preventDefault();
                var btn = $(this);
                $('#d_article_title').text(btn.data('title'));
                $('#d_article_title_text').text(btn.data('title'));
                $('#d_article_author').text(btn.data('author'));
                $('#d_article_date').text(btn.data('date'));
                $('#d_article_content').html(btn.data('content'));

                $('#modalDetailArticle').modal('show');
            });
        });
    </script>
@endpush
