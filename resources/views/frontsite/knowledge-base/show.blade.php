@extends('layouts.front', ['title' => $article->title . ' - Knowledge Base'])

@section('content')
    <style>
        .article-content iframe {
            max-width: 100%;
            border: 0;
        }

        .article-content .embed-responsive {
            margin: 1rem 0;
        }

        .article-content .kb-video-settings,
        .article-content .note-video-popover {
            display: none !important;
        }

        .kb-video-shell {
            position: relative;
            width: 100%;
            max-width: 100%;
            aspect-ratio: 16 / 9;
            margin: 1.25rem 0;
            clear: both;
            overflow: hidden;
            background: #000;
            border-radius: .75rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .12);
            min-width: 280px;
        }

        .kb-video-shell.is-align-left {
            margin-left: 0;
            margin-right: auto;
        }

        .kb-video-shell.is-align-center {
            margin-left: auto;
            margin-right: auto;
        }

        .kb-video-shell.is-align-right {
            margin-left: auto;
            margin-right: 0;
        }

        .kb-video-shell .kb-video-frame,
        .kb-video-shell iframe {
            width: 100% !important;
            height: 100% !important;
            max-width: 100% !important;
            display: block;
        }

        .kb-video-toolbar {
            position: absolute;
            top: .65rem;
            right: .65rem;
            z-index: 2;
            display: flex;
            gap: .35rem;
            padding: .45rem;
            border-radius: .75rem;
            background: rgba(20, 24, 31, .82);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .18);
            opacity: 0;
            transform: translateY(-4px);
            transition: opacity 160ms ease, transform 160ms ease;
        }

        .kb-video-shell:hover .kb-video-toolbar,
        .kb-video-shell:focus-within .kb-video-toolbar {
            opacity: 1;
            transform: translateY(0);
        }

        .kb-video-toolbar .btn {
            border-radius: .45rem;
            padding: .2rem .45rem;
            font-size: .72rem;
            line-height: 1.2;
        }

        .kb-video-resize-handle {
            position: absolute;
            right: .25rem;
            bottom: .25rem;
            width: 1rem;
            height: 1rem;
            z-index: 3;
            cursor: nwse-resize;
            opacity: 0;
            transition: opacity 160ms ease;
        }

        .kb-video-resize-handle::before {
            content: '';
            position: absolute;
            right: .1rem;
            bottom: .1rem;
            width: .65rem;
            height: .65rem;
            border-right: 2px solid rgba(255, 255, 255, .85);
            border-bottom: 2px solid rgba(255, 255, 255, .85);
            border-radius: 0 0 .2rem 0;
        }

        .kb-video-shell:hover .kb-video-resize-handle,
        .kb-video-shell:focus-within .kb-video-resize-handle {
            opacity: 1;
        }

        @media (max-width: 575.98px) {
            .kb-video-toolbar {
                position: static;
                margin-bottom: .5rem;
                opacity: 1;
                transform: none;
                flex-wrap: wrap;
            }

            .kb-video-shell {
                max-width: 100%;
            }

            .kb-video-resize-handle {
                opacity: 1;
            }
        }
    </style>

    <section id="hero" class="hero-custom section dark-background"></section>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                @if($article->featured_image_url)
                    <div class="mb-4">
                        <div class="text-uppercase text-muted small mb-2"></div>
                        <img src="{{ $article->featured_image_url }}" alt="Featured Image {{ $article->title }}" class="img-fluid rounded shadow-sm" style="width:100%;max-height:420px;object-fit:cover;">
                    </div>
                @endif

                <h1 class="mb-2">{{ $article->title }}</h1>
                <p class="text-muted mb-4">
                    {{ $article->category->name ?? 'Umum' }} · {{ $article->created_at->format('d M Y H:i') }} · oleh {{ $article->author->name ?? 'Tim' }}
                </p>

                <div class="article-content">
                    {!! $article->rendered_content !!}
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">Artikel Terkait</div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            @foreach($related as $r)
                                <li class="mb-2"><a href="{{ route('knowledge-base.show', $r->slug) }}">{{ $r->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const article = document.querySelector('.article-content');

            if (!article) {
                return;
            }

            const videoSourcePattern = /(?:youtube\.com|youtu\.be|youtube-nocookie\.com|vimeo\.com|dailymotion\.com|dai\.ly|youku\.com)/i;

            function applyState(shell) {
                const align = shell.dataset.videoAlign || 'center';

                shell.classList.remove('is-align-left', 'is-align-center', 'is-align-right');
                shell.classList.add(`is-align-${align}`);
            }

            function setAlign(shell, align) {
                shell.dataset.videoAlign = align;
                applyState(shell);
            }

            function setWidth(shell, width) {
                shell.dataset.videoWidth = width;
                shell.style.width = width;
            }

            function resetWidth(shell) {
                setWidth(shell, '100%');
            }

            function clampWidth(shell, width) {
                const containerWidth = article.clientWidth || shell.parentElement.clientWidth || 0;
                const minWidth = Math.min(280, containerWidth || 280);
                const maxWidth = Math.max(minWidth, containerWidth || minWidth);

                return Math.max(minWidth, Math.min(maxWidth, width));
            }

            function createToolbar(shell) {
                const toolbar = document.createElement('div');
                toolbar.className = 'kb-video-toolbar';
                toolbar.innerHTML = [
                    '<button type="button" class="btn btn-light" data-act="left" title="Rata kiri">L</button>',
                    '<button type="button" class="btn btn-light" data-act="center" title="Tengah">C</button>',
                    '<button type="button" class="btn btn-light" data-act="right" title="Rata kanan">R</button>',
                    '<button type="button" class="btn btn-warning" data-act="reset" title="Reset">Reset</button>'
                ].join('');

                toolbar.addEventListener('click', function(event) {
                    const button = event.target.closest('button[data-act]');

                    if (!button) {
                        return;
                    }

                    event.preventDefault();
                    event.stopPropagation();

                    const action = button.dataset.act;

                    if (action === 'left') {
                        setAlign(shell, 'left');
                    } else if (action === 'center') {
                        setAlign(shell, 'center');
                    } else if (action === 'right') {
                        setAlign(shell, 'right');
                    } else if (action === 'reset') {
                        resetWidth(shell);
                        setAlign(shell, 'center');
                    }
                });

                return toolbar;
            }

            function createResizeHandle(shell) {
                const handle = document.createElement('div');
                handle.className = 'kb-video-resize-handle';
                handle.title = 'Tarik untuk mengubah ukuran';

                handle.addEventListener('pointerdown', function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    const startX = event.clientX;
                    const startWidth = shell.getBoundingClientRect().width;

                    if (typeof shell.setPointerCapture === 'function') {
                        shell.setPointerCapture(event.pointerId);
                    }

                    const onMove = function(moveEvent) {
                        const delta = moveEvent.clientX - startX;
                        const nextWidth = clampWidth(shell, startWidth + delta);

                        shell.style.width = `${nextWidth}px`;
                        shell.dataset.videoWidth = `${nextWidth}px`;
                    };

                    const onUp = function() {
                        window.removeEventListener('pointermove', onMove);
                        window.removeEventListener('pointerup', onUp);
                    };

                    window.addEventListener('pointermove', onMove);
                    window.addEventListener('pointerup', onUp, { once: true });
                });

                return handle;
            }

            article.querySelectorAll('iframe').forEach(function(iframe) {
                const src = iframe.getAttribute('src') || '';

                if (!videoSourcePattern.test(src)) {
                    return;
                }

                if (iframe.closest('.kb-video-shell')) {
                    return;
                }

                const host = iframe.closest('.embed-responsive, .kb-video-wrapper');
                const shell = document.createElement('div');
                shell.className = 'kb-video-shell is-align-center';
                shell.dataset.videoWidth = '100%';
                shell.dataset.videoAlign = 'center';
                shell.style.width = '100%';

                const toolbar = createToolbar(shell);
                const resizeHandle = createResizeHandle(shell);

                if (host) {
                    const hostIframe = host.querySelector('iframe');

                    if (!hostIframe) {
                        return;
                    }

                    host.parentNode.insertBefore(shell, host);
                    host.remove();
                    hostIframe.classList.add('kb-video-frame');
                    shell.appendChild(toolbar);
                    shell.appendChild(hostIframe);
                    shell.appendChild(resizeHandle);
                } else {
                    iframe.classList.add('kb-video-frame');
                    iframe.parentNode.insertBefore(shell, iframe);
                    shell.appendChild(toolbar);
                    shell.appendChild(iframe);
                    shell.appendChild(resizeHandle);
                }

                applyState(shell);
            });
        });
    </script>
@endsection
