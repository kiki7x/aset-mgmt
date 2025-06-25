@extends('layouts.backsite-navtab-aset', [
    'id' => $asset->id,
    'classification_id' => $asset->classification_id
])

@section('content-tab')
    <div class="tab-content" id="assetTabContent">
        {{-- Overview Section --}}
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td><span class="badge bg-primary">{{ $asset->status->name ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tag:</strong></td>
                                        <td>{{ $asset->tag ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>{{ $asset->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Category:</strong></td>
                                        <td><span class="badge bg-info text-dark">{{ $asset->category->name ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Location:</strong></td>
                                        <td>{{ $asset->location->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Manufacturer:</strong></td>
                                        <td>{{ $asset->manufacturer->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Model:</strong></td>
                                        <td>{{ $asset->model->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Supplier:</strong></td>
                                        <td>{{ $asset->supplier->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Serial Number:</strong></td>
                                        <td>{{ $asset->serial ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Asset Admin:</strong></td>
                                        <td>{{ $asset->admin->username ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Asset User:</strong></td>
                                        <td>{{ $asset->user->username ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Purchase Date:</strong></td>
                                        <td>{{ $asset->purchase_date ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Warranty (months):</strong></td>
                                        <td>{{ ($asset->warranty_months ?? 'N/A') . ' bulan' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                            @if (isset($asset->notes) && !empty($asset->notes))
                                <p>{{ $asset->notes }}</p>
                            @else
                                <p class="text-muted">No notes available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
