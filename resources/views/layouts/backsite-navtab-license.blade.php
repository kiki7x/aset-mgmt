@extends('layouts.backsite', [
    'title' => 'Detail Lisensi | SAPA PPL',
    'welcome' => 'Detail Lisensi' . ($license->name ? ' | ' . $license->tag . ' - ' . $license->name : ''),
    'breadcrumb' => '<li class="breadcrumb-item"><a href="' . route('admin.license') . '">Lisensi</a></li>' . '<li class="breadcrumb-item active">Detail Lisensi</li>',
])

@section('script-head')
    @stack('script-head')
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="col-md-12">
                <ul class="nav nav-tabs card-header-tabs" id="licenseTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.license.overview') ? 'active' : '' }}" id="overview-tab" role="tab" aria-controls="overview" aria-selected="false"
                           href="{{ route('admin.license.overview', $id) }}">
                            Ringkasan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.license.edit') ? 'active' : '' }}" id="edit-tab" role="tab" aria-controls="edit" aria-selected="false"
                           href="{{ route('admin.license.edit', $id) }}">
                            Edit
                        </a>
                    </li>
                    <li class="col d-flex justify-content-end">
                        <div>
                            <a href="{{ route('admin.license') }}" type="button" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card-body">
            @yield('content-tab')
        </div>

    </div>
@endsection

@push('script-foot')
    @yield('script-foot')
@endpush
