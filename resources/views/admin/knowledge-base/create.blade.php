@extends('layouts.backsite', [
    'title' => 'Tambah Artikel Pusat Pengetahuan | SAPA PPL',
    'welcome' => 'Tambah Artikel',
    'breadcrumb' =>
        '
        <li class="breadcrumb-item"><a href="' .
        route('admin.knowledge-base') .
        '">Pusat Pengetahuan</a></li>
        <li class="breadcrumb-item active">Tambah Artikel</li>
    ',
])

@push('script-head')
    <!-- Summernote CSS -->
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Artikel Baru</h3>
        </div>
        <form action="{{ route('admin.knowledge-base.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Judul Artikel</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
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
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                    <label for="is_published">Status</label>
                    <select class="form-control @error('is_published') is-invalid @enderror" id="is_published" name="is_published">
                        <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>Draft</option>
                        <option value="1" {{ old('is_published') == '1' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('is_published')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="featured_image">Gambar Depan</label>
                    <input type="file" class="form-control-file @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" accept="image/*">
                    <div class="mt-2 d-none" id="featured_image_preview_wrap">
                        <img id="featured_image_preview" src="" alt="Featured Image Preview" class="img-thumbnail" style="max-width: 240px;">
                    </div>
                    <small class="form-text text-muted">Opsional. Format: JPG, PNG, GIF, atau WebP.</small>
                    @error('featured_image')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Konten Artikel</label>
                    <textarea id="summernote" name="content" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                    @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                <a href="{{ route('admin.knowledge-base') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
    <!-- Video Insert Modal -->
<div class="modal fade" id="kbVideoModal" tabindex="-1" role="dialog" aria-labelledby="kbVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kbVideoModalLabel">Insert Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="video_url">Link Video (YouTube, Vimeo, Dailymotion, Youku)</label>
                    <input type="text" id="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                </div>
                <div id="video_preview" class="mt-3" style="min-height:120px;">
                    <!-- preview inserted here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" id="kbInsertVideoBtn" class="btn btn-primary">Insert Video</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-foot')
    <!-- Summernote JS -->
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#featured_image').on('change', function() {
                const file = this.files && this.files[0];

                if (!file) {
                    $('#featured_image_preview_wrap').addClass('d-none');
                    $('#featured_image_preview').attr('src', '');
                    return;
                }

                const reader = new FileReader();

                reader.onload = function(event) {
                    $('#featured_image_preview').attr('src', event.target.result);
                    $('#featured_image_preview_wrap').removeClass('d-none');
                };

                reader.readAsDataURL(file);
            });

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
                    onInit: function() {
                        bindVideoToolbarButton();
                        // keep track of the current selection range so inserts happen at caret
                        $('#summernote').on('mouseup keyup focus', function() {
                            try {
                                $('#summernote').summernote('saveRange');
                            } catch (e) {}
                        });
                    },
                    onImageUpload: function(files) {
                        for (let i = 0; i < files.length; i++) {
                            uploadMedia(files[i]);
                        }
                    }
                }
            });

            function bindVideoToolbarButton() {
                const toolbar = $('#summernote').next('.note-editor').find('.note-toolbar')[0];

                if (!toolbar || toolbar.dataset.kbVideoBound === '1') {
                    return;
                }

                toolbar.dataset.kbVideoBound = '1';

                toolbar.addEventListener('click', function(event) {
                    const button = event.target.closest('button');

                    if (!button) {
                        return;
                    }

                    const label = `${button.getAttribute('title') || ''} ${button.getAttribute('aria-label') || ''} ${button.textContent || ''}`.toLowerCase();
                    const hasVideoIcon = button.querySelector('.note-icon-video');

                    if (!hasVideoIcon && !label.includes('video')) {
                        return;
                    }

                    event.preventDefault();
                    event.stopPropagation();

                    // save current range so we can restore it when inserting
                    try {
                        $('#summernote').summernote('saveRange');
                    } catch (e) {}

                    // Open modal to input video URL instead of prompt
                    $('#video_url').val('');
                    $('#video_preview').html('');
                    $('#kbVideoModal').modal('show');
                }, true);
            }

            function insertVideoFromUrl(url) {
                const embedHtml = buildVideoEmbedHtml(url);

                if (!embedHtml) {
                    alert('Link video tidak dikenali. Gunakan link YouTube, Vimeo, Dailymotion, atau Youku.');
                    return;
                }

                try {
                    $('#summernote').summernote('restoreRange');
                } catch (e) {}
                $('#summernote').summernote('pasteHTML', embedHtml);
                $('#video_url').val('');
            }

            function buildVideoEmbedHtml(url) {
                if (!url) {
                    return null;
                }

                const normalizedUrl = url.trim();
                const youtubeVideoId = extractYouTubeVideoId(normalizedUrl);

                if (youtubeVideoId) {
                    return `<div class="embed-responsive embed-responsive-16by9 kb-video-wrapper" style="position:relative;">` +
                        `<button type="button" class="kb-video-settings btn btn-sm btn-light" style="position:absolute;top:6px;right:6px;z-index:10;">&#9881;</button>` +
                        `<iframe class="embed-responsive-item kb-video-iframe" src="https://www.youtube.com/embed/${youtubeVideoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>`;
                }

                const vimeoMatch = normalizedUrl.match(/vimeo\.com\/(?:video\/)?(\d+)/i);
                if (vimeoMatch) {
                    return `<div class="embed-responsive embed-responsive-16by9 kb-video-wrapper" style="position:relative;">` +
                        `<button type="button" class="kb-video-settings btn btn-sm btn-light" style="position:absolute;top:6px;right:6px;z-index:10;">&#9881;</button>` +
                        `<iframe class="embed-responsive-item kb-video-iframe" src="https://player.vimeo.com/video/${vimeoMatch[1]}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>`;
                }

                const dailymotionMatch = normalizedUrl.match(/(?:dailymotion\.com\/video\/|dai\.ly\/)([\w-]+)/i);
                if (dailymotionMatch) {
                    return `<div class="embed-responsive embed-responsive-16by9 kb-video-wrapper" style="position:relative;">` +
                        `<button type="button" class="kb-video-settings btn btn-sm btn-light" style="position:absolute;top:6px;right:6px;z-index:10;">&#9881;</button>` +
                        `<iframe class="embed-responsive-item kb-video-iframe" src="https://www.dailymotion.com/embed/video/${dailymotionMatch[1]}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>`;
                }

                const youkuMatch = normalizedUrl.match(/youku\.com\/(?:embed\/|v_show\/id_)?([\w=]+)/i);
                if (youkuMatch) {
                    return `<div class="embed-responsive embed-responsive-16by9 kb-video-wrapper" style="position:relative;">` +
                        `<button type="button" class="kb-video-settings btn btn-sm btn-light" style="position:absolute;top:6px;right:6px;z-index:10;">&#9881;</button>` +
                        `<iframe class="embed-responsive-item kb-video-iframe" src="https://player.youku.com/embed/${youkuMatch[1]}" frameborder="0" allowfullscreen></iframe></div>`;
                }

                return null;
            }

            function extractYouTubeVideoId(url) {
                try {
                    const parsedUrl = new URL(url, window.location.origin);
                    const hostname = parsedUrl.hostname.replace(/^www\./i, '').toLowerCase();

                    if (hostname === 'youtu.be') {
                        return parsedUrl.pathname.split('/').filter(Boolean)[0] || null;
                    }

                    if (hostname === 'youtube.com' || hostname === 'm.youtube.com' || hostname === 'music.youtube.com' || hostname === 'youtube-nocookie.com') {
                        const path = parsedUrl.pathname;

                        if (path === '/watch') {
                            return parsedUrl.searchParams.get('v');
                        }

                        const embedMatch = path.match(/\/embed\/([\w-]{11})/i);
                        if (embedMatch) {
                            return embedMatch[1];
                        }

                        const shortMatch = path.match(/\/shorts\/([\w-]{11})/i);
                        if (shortMatch) {
                            return shortMatch[1];
                        }
                    }
                } catch (error) {
                    const fallbackMatch = url.match(/(?:youtube\.com\/watch\?v=|youtube\.com\/embed\/|youtu\.be\/|youtube-nocookie\.com\/embed\/)([\w-]{11})/i);
                    if (fallbackMatch) {
                        return fallbackMatch[1];
                    }
                }

                return null;
            }

            function uploadMedia(file) {
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
                        if (response.type === 'video' && response.iframe) {
                            try {
                                $('#summernote').summernote('restoreRange');
                            } catch (e) {}
                            $('#summernote').summernote('pasteHTML', response.iframe);
                        } else if (response.url) {
                            $('#summernote').summernote('insertImage', response.url);
                        } else {
                            console.error('URL media tidak ditemukan dalam respons:', response);
                            alert('Gagal mengunggah media.');
                        }
                    },
                    error: function(data) {
                        console.error(data);
                        alert('Terjadi kesalahan saat mengunggah media.');
                    }
                });
            }

            // Modal handlers for video insertion
            $('#kbVideoModal').on('shown.bs.modal', function() {
                $('#video_url').trigger('focus');
            });

            $('#video_url').on('input', function() {
                const url = $(this).val().trim();
                const embed = buildVideoEmbedHtml(url);

                if (embed) {
                    $('#video_preview').html(embed);
                } else {
                    $('#video_preview').html('<div class="text-muted">Preview tidak tersedia untuk link ini.</div>');
                }
            });

            $('#kbInsertVideoBtn').on('click', function() {
                const url = $('#video_url').val().trim();

                if (!url) {
                    alert('Masukkan link video terlebih dahulu.');
                    return;
                }

                const embedHtml = buildVideoEmbedHtml(url);

                if (!embedHtml) {
                    alert('Link video tidak dikenali. Gunakan link YouTube, Vimeo, Dailymotion, atau Youku.');
                    return;
                }

                try {
                    $('#summernote').summernote('restoreRange');
                } catch (e) {}
                $('#summernote').summernote('pasteHTML', embedHtml);
                $('#kbVideoModal').modal('hide');
                $('#video_url').val('');
                $('#video_preview').html('');
            });

            $('#kbVideoModal').on('hidden.bs.modal', function() {
                $('#video_url').val('');
                $('#video_preview').html('');
            });

            // Video popover for post-insert controls (align, resize, edit, remove)
            (function() {
                let $videoPopover = null;
                let $selectedVideo = null;
                // flag to prevent immediate hide after opening the popover
                let popoverJustOpened = false;

                function createPopover() {
                    if ($videoPopover) return $videoPopover;

                    $videoPopover = $(
                        '<div class="note-video-popover popover fade" style="display:none; position: absolute; z-index: 1060;">' +
                        '  <div class="arrow"></div>' +
                        '  <div class="popover-content p-2 text-center">' +
                        '    <div class="btn-group btn-group-sm" role="group">' +
                        '      <button type="button" class="btn btn-light" data-act="align-left" title="Align Left">L</button>' +
                        '      <button type="button" class="btn btn-light" data-act="align-center" title="Center">C</button>' +
                        '      <button type="button" class="btn btn-light" data-act="align-right" title="Align Right">R</button>' +
                        '      <button type="button" class="btn btn-light" data-act="w-100" title="Width 100%">100%</button>' +
                        '      <button type="button" class="btn btn-light" data-act="w-50" title="Width 50%">50%</button>' +
                        '      <button type="button" class="btn btn-light" data-act="edit" title="Edit" data-crud="true">Edit</button>' +
                        '      <button type="button" class="btn btn-danger" data-act="remove" title="Remove" data-crud="true">Del</button>' +
                        '    </div>' +
                        '  </div>' +
                        '</div>'
                    ).appendTo('body');

                    $videoPopover.on('click', 'button', function(e) {
                        e.preventDefault();
                        const act = $(this).data('act');

                        if (!$selectedVideo || !$selectedVideo.length) return;

                        const $wrapper = $selectedVideo.closest('.embed-responsive');

                        if (act === 'align-left') {
                            $wrapper.css({
                                display: 'block',
                                margin: '0',
                                float: 'left',
                                'margin-right': '1rem'
                            });
                        } else if (act === 'align-right') {
                            $wrapper.css({
                                display: 'block',
                                margin: '0',
                                float: 'right',
                                'margin-left': '1rem'
                            });
                        } else if (act === 'align-center') {
                            $wrapper.css({
                                display: 'block',
                                margin: '0 auto',
                                float: 'none'
                            });
                        } else if (act === 'w-100') {
                            $selectedVideo.css({
                                width: '100%',
                                height: 'auto'
                            });
                            $wrapper.css({
                                'max-width': '100%'
                            });
                        } else if (act === 'w-50') {
                            $selectedVideo.css({
                                width: '100%',
                                height: 'auto'
                            });
                            $wrapper.css({
                                'max-width': '50%'
                            });
                        } else if (act === 'edit') {
                            // open modal with current src
                            const src = $selectedVideo.attr('src') || '';
                            $('#video_url').val(src);
                            $('#video_preview').html(buildVideoEmbedHtml(src));
                            $('#kbVideoModal').modal('show');
                        } else if (act === 'remove') {
                            $wrapper.remove();
                        }

                        hidePopover();
                    });

                    return $videoPopover;
                }

                function showPopover($iframe) {
                    $selectedVideo = $iframe;
                    const pop = createPopover();
                    const rect = $iframe[0].getBoundingClientRect();
                    const scrollTop = $(window).scrollTop();
                    const top = rect.top + scrollTop - pop.outerHeight() - 8;
                    const left = rect.left + (rect.width / 2) - (pop.outerWidth() / 2);

                    pop.css({
                        top: top + 'px',
                        left: Math.max(8, left) + 'px'
                    }).addClass('show').show();

                    // mark as just opened to ignore the immediate mouseup/click that follows
                    popoverJustOpened = true;
                    setTimeout(function() {
                        popoverJustOpened = false;
                    }, 300);
                }

                function hidePopover() {
                    if ($videoPopover) {
                        $videoPopover.removeClass('show').hide();
                    }
                    $selectedVideo = null;
                }

                // show popover when clicking the settings button overlay
                $(document).on('click', '.kb-video-settings', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const $btn = $(this);
                    const $wrapper = $btn.closest('.kb-video-wrapper');
                    const $iframe = $wrapper.find('iframe.kb-video-iframe');
                    if ($iframe.length) {
                        showPopover($iframe);
                    }
                });

                // click outside popover or settings -> hide popover
                $(document).on('click', function(e) {
                    // if popover was just opened, ignore this click (it may be the same user click)
                    if (popoverJustOpened) return;

                    if (!$(e.target).closest('.note-video-popover, .kb-video-settings').length) {
                        hidePopover();
                    }
                });

                // hide on editor events (e.g., keyup or selection change)
                $(document).on('keyup mouseup', function(e) {
                    // ignore events that originate from the settings button or the popover itself
                    if ($(e.target).closest('.note-video-popover, .kb-video-settings').length) {
                        return;
                    }

                    // if popover was just opened, ignore the immediate mouseup/keyup
                    if (popoverJustOpened) return;

                    if (!$(e.target).closest('iframe').length) {
                        // small delay to allow clicks on popover
                        setTimeout(() => {
                            if (!$(document.activeElement).is('iframe')) {
                                // keep popover if focus is on popover
                                if (!$(document.activeElement).closest('.note-video-popover').length) {
                                    hidePopover();
                                }
                            }
                        }, 150);
                    }
                });

                // hide popover when modal opens
                $('#kbVideoModal').on('show.bs.modal', hidePopover);
            })();
        });
    </script>
@endpush

