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

    <section class="">
        <div class="container">
            <h2 class="text-center">Pusat Pengetahuan</h2>
            <p class="text-center">Artikel panduan dan dokumentasi untuk membantu pengguna memanfaatkan aset di lingkungan Poltekpar Lombok.</p>
        </div>

        <div class="container">
            <div class="row">
                @foreach($articles as $article)
                    @php
                        // Use featured image first, then fall back to first image in content, then placeholder.
                        $thumbnail = $article->featured_image_url;

                        if (!$thumbnail && preg_match("/<img[^>]+src=[\"']([^\"']+)[\"']/i", $article->content, $m)) {
                            $thumbnail = $m[1];
                        }
                        if (!$thumbnail) {
                            $thumbnail = asset('arsha/assets/img/news-placeholder.jpg');
                        }
                    @endphp
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $thumbnail }}" class="card-img-top" alt="{{ $article->title }}" style="object-fit:cover; height:200px;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" style="min-height:3em;">{{ $article->title }}</h5>
                                <p class="text-muted mb-1 small">Editor {{ $article->author->name ?? 'Poltekpar' }} • {{ $article->created_at->format('j M, Y') }}</p>
                                <p class="card-text" style="flex:1">{{ Str::limit(strip_tags($article->content), 140) }}</p>
                                <a href="{{ route('knowledge-base.show', $article->slug) }}" class="stretched-link">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
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
