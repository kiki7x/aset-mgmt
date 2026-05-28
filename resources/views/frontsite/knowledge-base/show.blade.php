@extends('layouts.front', ['title' => $article->title . ' - Knowledge Base'])

@section('content')
    <section id="hero" class="hero-custom section dark-background"></section>
        <div class="container py-5">
            <div class="row">
                <div class="col-md-8">
                    <h1>{{ $article->title }}</h1>
                    <p class="text-muted">{{ $article->category->name ?? 'Umum' }} · {{ $article->created_at->format('d M Y H:i') }} · oleh {{ $article->author->name ?? 'Tim' }}</p>

                    <div class="article-content">
                        {!! $article->content !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">Artikel Terkait</div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                @foreach($related as $r)
                                    <li><a href="{{ route('knowledge-base.show', $r->slug) }}">{{ $r->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
