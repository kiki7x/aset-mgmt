<div class="container-md">
    <section class="content-header">
        <div class="d-flex justify-content-between mb-1">
            <h3>Nama Supplier {{ $name }}</h3>
            <a href="{{ route('admin.setting_attr.supplier') }}" type="button" class="btn btn-primary">
                <i class="fa-solid fa-angles-left"></i> Kembali
            </a>
        </div>
    </section>

    {{-- Content Section --}}
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="col-md-12">
                    {{-- Navigation Tabs --}}
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a wire:click="switchSection('')" href="{{ route('admin.setting_attr.supplier.show', ['id' => $id, 'section' => '']) }}" class="nav-link {{ $currentSection === '' ? 'active' : '' }}">
                                Summary
                                <div wire:loading wire:target="switchSection('')" class="spinner-border spinner-border-sm">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    @if ($currentSection === '')
                        <div id="section-1" class="tab-pane active">
                            <div class="row mt-3">
                                <!-- Left Column -->
                                <div class="card col-md-8">
                                    <div class="card-header">
                                        Supplier Information
                                    </div>
                                    <table class="table table-hover table-responsive">
                                        <tbody>
                                            <tr>
                                                <td><strong>Nama</strong></td>
                                                <td>:</td>
                                                <td>{{ $asset->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alamat</strong></td>
                                                <td>:</td>
                                                <td>{{ $asset->address }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nama Contact</strong></td>
                                                <td>:</td>
                                                <td>{{ $asset->contactname }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phone</strong></td>
                                                <td>:</td>
                                                <td>{{ $asset->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email</strong></td>
                                                <td>:</td>
                                                <td>{{ $asset->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Notes</strong></td>
                                                <td>:</td>
                                                <td><span class="badge bg-danger text-dark">{{ $asset->notes ?? 'Unknown' }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Aktivitas Terakhir</strong></td>
                                                <td>:</td>
                                                <td><span class="badge bg-info text-dark">{{ $asset->updated_at ?? 'N/A' }}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

@push('script')
    <script></script>
@endpush
