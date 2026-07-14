@extends('layouts.backsite', [
    'title' => 'Pusat Notifikasi | SAPA PPL',
    'welcome' => 'Pusat Notifikasi',
    'breadcrumb' => '
    <li class="breadcrumb-item active">Pusat Notifikasi</li>
    ',
])


@section('content')
    <style>
        .btn-outline-white {
            color: white;
            background-color: transparent;
            border: 1px solid white;
            transition: all 0.2s ease-in-out;
        }

        .btn-outline-white:hover {
            background-color: white;
            color: #333;
        }
    </style>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md sticky top-8">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold">Pusat Notifikasi (Simulasi)</h2>
                <p class="text-sm text-gray-500">Hasil dari kode di sebelah kiri akan muncul di sini.</p>
            </div>

            <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold text-gray-800">Belum Dibaca (<span
                            id="unread-count">{{ auth()->user()->unreadNotifications->count() }}</span>)</h3>
                    <form method="POST" action="{{ route('admin.tandai-notifikasi-telah-dibaca') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-check2-square me-1"></i> Tandai Semua Sudah Dibaca
                        </button>
                    </form>
                </div>
                <div id="unread-notifications" class="space-y-3 mb-6">
                    @forelse (auth()->user()->unreadNotifications as $notification)
                        <div class="alert alert-info d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <span>{{ $notification->data['message'] ?? 'Tidak ada pesan' }}</span>
                                <small>{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <form method="POST" action="{{ route('notif.read', $notification->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-white">
                                    ✔ Tandai Telah Dibaca
                                </button>
                            </form>
                        </div>
                    @empty
                        <p id="no-unread" class="text-gray-500 text-sm">Tidak ada notifikasi baru.</p>
                    @endforelse
                </div>

                <h3 class="font-semibold text-gray-800 border-t border-gray-200 pt-4 mb-3">Riwayat</h3>
                <div id="read-notifications" class="space-y-3">
                    @forelse (auth()->user()->notifications as $notification)
                        @if ($notification->read_at)
                            <div style="background-color: #f2f2f2; color: #333;"
                                class="alert d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <span>{{ $notification->data['message'] ?? 'Tidak ada pesan' }}</span>
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="d-flex">
                                    <form class="mr-2" method="POST"
                                        action="{{ route('notif.unread', $notification->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-info btn-sm">
                                            Tandai Belum Dibaca
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('notif.delete', $notification->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p id="no-read" class="text-gray-500 text-sm">Tidak ada riwayat notifikasi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
