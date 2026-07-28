@extends('layouts.backsite', [
    'title' => 'Profile | SAPA PPL',
    'welcome' => 'Profile',
    'breadcrumb' => '<li class="breadcrumb-item active">Profile</li>',
])

@push('script-head')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .avatar-preview {
            width: 128px;
            height: 128px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #adb5bd;
            transition: opacity .3s;
        }
        .avatar-preview:hover {
            opacity: .8;
        }
    </style>
@endpush

@section('content')
    @php
        $avatarUrl = $user->avatar
            ? asset('storage/' . $user->avatar)
            : asset('assets/dist/img/user1-128x128.jpg');
        $roleName = $user->roles->pluck('name')->map(fn($r) => ucwords(str_replace('_', ' ', $r)))->implode(', ');
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <label for="avatarInput" style="cursor: pointer;" data-toggle="tooltip" title="Klik untuk ganti foto">
                                <img class="profile-user-img img-fluid img-circle avatar-preview" src="{{ $avatarUrl }}" id="avatarPreview" alt="User profile picture">
                            </label>
                            <form id="formAvatar" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none;">
                            </form>
                        </div>
                        <h3 class="profile-username text-center">{{ $user->fullname }}</h3>
                        <p class="text-muted text-center">{{ $roleName ?: ($user->title ?? 'Anggota') }}</p>
                        <p class="text-center text-sm text-muted">
                            <i class="fas fa-user"></i> {{ $user->username }}
                        </p>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Kontak</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                        <p class="text-muted">{{ $user->email }}</p>
                        <hr>

                        <strong><i class="fas fa-phone mr-1"></i> Mobile</strong>
                        <p class="text-muted">{{ $user->mobile ?? '-' }}</p>
                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                        <p class="text-muted">{{ $user->address ?? '-' }}</p>
                        <hr>

                        <strong><i class="fas fa-briefcase mr-1"></i> Jabatan</strong>
                        <p class="text-muted">{{ $user->title ?? '-' }}</p>
                        <hr>

                        <strong><i class="fas fa-shield-alt mr-1"></i> Role</strong>
                        <p class="text-muted">{{ $roleName ?: '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab"><i class="fas fa-user-cog"></i> Profile</a></li>
                            <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab"><i class="fas fa-key"></i> Ubah Password</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="settings">
                                <form id="formProfile" autocomplete="off">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="fullname" class="form-control" value="{{ $user->fullname }}" required>
                                            <span class="text-danger small" id="error-fullname"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Username</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" value="{{ $user->username }}" readonly disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                            <span class="text-danger small" id="error-email"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Mobile</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}">
                                            <span class="text-danger small" id="error-mobile"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <textarea name="address" class="form-control" rows="2">{{ $user->address }}</textarea>
                                            <span class="text-danger small" id="error-address"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Jabatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="title" class="form-control" value="{{ $user->title }}">
                                            <span class="text-danger small" id="error-title"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-3 col-sm-9">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane" id="password">
                                <form id="formPassword" autocomplete="off">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Password Saat Ini</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="current_password" class="form-control" required>
                                            <span class="text-danger small" id="error-current_password"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Password Baru</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="new_password" class="form-control" required minlength="8">
                                            <span class="text-danger small" id="error-new_password"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Konfirmasi Password Baru</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="new_password_confirmation" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-3 col-sm-9">
                                            <button type="submit" class="btn btn-warning"><i class="fas fa-key mr-1"></i>Ubah Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-foot')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Avatar preview on file select
            $('#avatarInput').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#avatarPreview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);

                    var formData = new FormData();
                    formData.append('avatar', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: "{{ route('admin.profile.avatar') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            toastr.success(res.message);
                        },
                        error: function(xhr) {
                            if (xhr.responseJSON?.errors) {
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    toastr.error(value[0]);
                                });
                            }
                        }
                    });
                }
            });

            // Form Profile
            $('#formProfile').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);

                $.ajax({
                    url: "{{ route('admin.profile.update') }}",
                    method: "POST",
                    data: form.serialize(),
                    success: function(res) {
                        toastr.success(res.message);
                    },
                    error: function(xhr) {
                        $('.text-danger.small').text('');
                        if (xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#error-' + key).text(value[0]);
                            });
                        }
                    }
                });
            });

            // Form Password
            $('#formPassword').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);

                $.ajax({
                    url: "{{ route('admin.profile.password') }}",
                    method: "POST",
                    data: form.serialize(),
                    success: function(res) {
                        toastr.success(res.message);
                        form[0].reset();
                    },
                    error: function(xhr) {
                        $('.text-danger.small').text('');
                        if (xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#error-' + key).text(value[0]);
                            });
                        }
                    }
                });
            });

            // Clear errors on input change
            $(document).on('change', 'input, textarea', function() {
                var name = $(this).attr('name');
                if (name) {
                    $('#error-' + name).text('');
                }
            });
        });
    </script>
@endpush
