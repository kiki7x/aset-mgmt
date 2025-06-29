@extends('layouts.backsite', [
    'title' => 'Detail Aset ' . ($classification_id == 2 ? 'TIK' : 'RT') . ' | SAPA PPL',
    'welcome' => 'Detail Aset ' . ($classification_id == 2 ? 'TIK' : 'RT'),
    'breadcrumb' => '<li class="breadcrumb-item"> <a href="' . route($classification_id == 2 ? 'admin.asettik' : 'admin.asetrt') . '">Aset ' . ($classification_id == 2 ? 'TIK' : 'RT') . '</a></li>'
    . '<li class="breadcrumb-item active">Detail Aset ' . ($classification_id == 2 ? 'TIK' : 'RT') . '</li>'
])

@section('script-head')
@stack('script-head')
@endsection
@section('content')
    <div class="container-fluid">
        <section class="content-header">
        </section>

        {{-- Content Section --}}
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12">
                        {{-- Navigation Tabs --}}
                        <ul class="nav nav-tabs card-header-tabs" id="assetTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.asetrt.overview') || request()->routeIs('admin.asettik.overview') ? 'active' : '' }}" id="overview-tab" role="tab" aria-controls="overview" aria-selected="false"
                                href="{{ $classification_id == 2 ? route('admin.asettik.overview', $id) : route('admin.asetrt.overview', $id) }}">
                                    Overview
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.asetrt.pemeliharaan') || request()->routeIs('admin.asettik.pemeliharaan') ? 'active' : '' }}" id="pemeliharaan-tab" role="tab" aria-controls="pemeliharaan" aria-selected="false"
                                href="{{ $classification_id == 2 ? route('admin.asettik.pemeliharaan', $id) : route('admin.asetrt.pemeliharaan', $id) }}">
                                    Pemeliharaan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.asetrt.penugasan') || request()->routeIs('admin.asettik.penugasan') ? 'active' : '' }}" id="issues-tab" role="tab" aria-controls="issues" aria-selected="false"
                                    href="{{ $classification_id == 2 ? route('admin.asettik.penugasan', $id) : route('admin.asetrt.penugasan', $id) }}">
                                    Penugasan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.asetrt.tickets') || request()->routeIs('admin.asettik.tickets') ? 'active' : '' }}" id="tickets-tab" role="tab" aria-controls="tickets" aria-selected="false"
                                    href="{{ $classification_id == 2 ? route('admin.asettik.tickets', $id) : route('admin.asetrt.tickets', $id) }}">
                                    Tickets
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.asetrt.files') || request()->routeIs('admin.asettik.files') ? 'active' : '' }}" id="files-tab" role="tab" aria-controls="files" aria-selected="false"
                                    href="{{ $classification_id == 2 ? route('admin.asettik.files', $id) : route('admin.asetrt.files', $id) }}">
                                    Files
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.asetrt.timelog') || request()->routeIs('admin.asettik.timelog') ? 'active' : '' }}" id="timelog-tab" role="tab" aria-controls="timelog" aria-selected="false"
                                    href="{{ $classification_id == 2 ? route('admin.asettik.timelog', $id) : route('admin.asetrt.timelog', $id) }}">
                                    Time Log
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.asetrt.edit') || request()->routeIs('admin.asettik.edit') ? 'active' : '' }}" id="edit-tab" role="tab" aria-controls="edit" aria-selected="false"
                                    href="{{ $classification_id == 2 ? route('admin.asettik.edit', $id) : route('admin.asetrt.edit', $id) }}">
                                    Edit Aset
                                </a>
                            </li>
                            <li class="col d-flex justify-content-end">
                                <div>
                                    {{-- <a href="{{route('admin.asetrt')}}" type="button" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a> --}}
                                    <a href="{{ route($classification_id == 2 ? 'admin.asettik' : 'admin.asetrt') }}" type="button" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- tampilan tab dinamis --}}
                <div class="card-body">
                    @yield('content-tab')
                </div>

            </div>
        </section>
    </div>
@endsection

@push('script-foot')
@yield('script-foot')
@endpush
