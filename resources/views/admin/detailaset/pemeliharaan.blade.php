@extends('layouts.backsite-navtab-aset', [
    'id' => $asset->id ?? '',
    'classification_id' => $asset->classification_id ?? '',
])

@push('script-head')
    @stack('script-head')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
@endpush

@section('content-tab')
    <div class="container-fluid">
        <div class="row align-items-center">
            {{-- <p class="col-12 h4 d-flex justify-content-center"><u>{{ $asset->tag }} - {{ $asset->name }}</u></p> --}}
            <p class="col-12 h4">Jadwal Pemeliharaan</p>
        </div>
        <div class="row">
            @if (!$isKendaraan)
                <div class="col-md-4">
                    <div class="card border border-success {{ $scheduleCekKondisi ? 'bg-white' : 'bg-light' }}" style="{{ $scheduleCekKondisi ? '' : 'opacity:0.65' }}">
                        <div class="card-body">
                            <h5 class="card-title mb-2"><i class="fa-solid fa-wrench text-success"></i> Cek Kondisi & Service Berkala</h5>
                            <p class="mb-2">
                                @if ($scheduleCekKondisi)
                                    <span class="badge badge-success mb-2"><i class="fa-regular fa-check-circle"></i> Terjadwal</span>
                                @else
                                    <span class="badge badge-secondary mb-2"><i class="fa-regular fa-clock"></i> Belum Terjadwal</span>
                                @endif
                            </p>

                            @if ($scheduleCekKondisi)
                                <div class="small mb-2 mr-1">
                                    <div><strong>Frekuensi:</strong> Setiap {{ $scheduleCekKondisi->frequency }} bulan sekali</div>
                                    <div><strong>Periode:</strong> {{ \Carbon\Carbon::parse($scheduleCekKondisi->end)->format('d M Y') }} <span class="badge badge-info"><i class="fa-solid fa-stopwatch"></i> <span class="countdown"
                                                  data-date="{{ $scheduleCekKondisi->end }}"></span></span></div>
                                    <div><strong>Reminder:</strong> {{ $scheduleCekKondisi->reminder }} hari sebelum jatuh tempo</div>
                                    <div><strong>Status:</strong> <span class="badge badge-{{ $scheduleCekKondisi->status == 'Aktif' ? 'success' : 'secondary' }}">{{ $scheduleCekKondisi->status }}</span></div>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-danger" onclick="deleteJadwalPemeliharaan({{ $scheduleCekKondisi->id }})"><i class="fa-regular fa-trash-can"></i> Hapus</button>
                                    <button class="btn btn-outline-primary" onclick="showModalEditJadwalV2({{ $scheduleCekKondisi->id }})"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                                    <button class="btn btn-outline-success" onclick="showModalAddPreventifV2({{ $scheduleCekKondisi->id }})"><i class="fa-regular fa-circle-check"></i> TL</button>
                                </div>
                            @else
                                <button class="btn btn-outline-primary btn-sm" onclick="showModalAddJadwalV2('Cek Kondisi & Service Berkala')"><i class="fa-regular fa-plus"></i> Atur Jadwal</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if ($isKendaraan)
                <div class="col-md-6">
                    <div class="card border border-warning {{ $schedulePajakSTNK ? 'bg-white' : 'bg-light' }}" style="{{ $schedulePajakSTNK ? '' : 'opacity:0.65' }}">
                        <div class="card-body">
                            <h5 class="card-title mb-2 mr-1"><i class="fa-solid fa-file-invoice text-warning"></i> Pajak STNK</h5>
                            <p class="mb-2">
                                @if ($schedulePajakSTNK)
                                    <span class="badge badge-success"><i class="fa-regular fa-check-circle"></i> Terjadwal</span>
                                @else
                                    <span class="badge badge-secondary"><i class="fa-regular fa-clock"></i> Belum Terjadwal</span>
                                @endif
                            </p>

                            @if ($schedulePajakSTNK)
                                <div class="small mb-2">
                                    <div><strong>Frekuensi:</strong> Setiap {{ $schedulePajakSTNK->frequency }} bulan sekali</div>
                                    <div><strong>Periode:</strong> {{ \Carbon\Carbon::parse($schedulePajakSTNK->end)->format('d M Y') }} <span class="badge badge-info"><i class="fa-solid fa-stopwatch"></i> <span class="countdown"
                                                  data-date="{{ $schedulePajakSTNK->end }}"></span></span></div>
                                    <div><strong>Reminder:</strong> {{ $schedulePajakSTNK->reminder }} hari sebelum jatuh tempo</div>
                                    <div><strong>Status:</strong> <span class="badge badge-{{ $schedulePajakSTNK->status == 'Aktif' ? 'success' : 'secondary' }}">{{ $schedulePajakSTNK->status }}</span></div>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-danger" onclick="deleteJadwalPemeliharaan({{ $schedulePajakSTNK->id }})"><i class="fa-regular fa-trash-can"></i> Hapus</button>
                                    <button class="btn btn-outline-primary" onclick="showModalEditJadwalV2({{ $schedulePajakSTNK->id }})"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                                    <button class="btn btn-outline-success" onclick="showModalAddPreventifV2({{ $schedulePajakSTNK->id }})"><i class="fa-regular fa-circle-check"></i> TL</button>
                                </div>
                            @else
                                <button class="btn btn-outline-primary btn-sm" onclick="showModalAddJadwalV2('Pajak STNK')"><i class="fa-regular fa-plus"></i> Atur Jadwal</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border border-primary {{ $scheduleServiceBerkala ? 'bg-white' : 'bg-light' }}" style="{{ $scheduleServiceBerkala ? '' : 'opacity:0.65' }}">
                        <div class="card-body">
                            <h5 class="card-title mb-2 mr-1"><i class="fa-solid fa-tools text-primary"></i> Service Berkala</h5>
                            <p class="mb-2">
                                @if ($scheduleServiceBerkala)
                                    <span class="badge badge-success"><i class="fa-regular fa-check-circle"></i> Terjadwal</span>
                                @else
                                    <span class="badge badge-secondary"><i class="fa-regular fa-clock"></i> Belum Terjadwal</span>
                                @endif
                            </p>

                            @if ($scheduleServiceBerkala)
                                <div class="small mb-2">
                                    <div><strong>Frekuensi:</strong> Setiap {{ $scheduleServiceBerkala->frequency }} bulan sekali</div>
                                    <div><strong>Periode:</strong> {{ \Carbon\Carbon::parse($scheduleServiceBerkala->end)->format('d M Y') }} <span class="badge badge-info"><i class="fa-solid fa-stopwatch"></i> <span class="countdown"
                                                  data-date="{{ $scheduleServiceBerkala->end }}"></span></span></div>
                                    <div><strong>Reminder:</strong> {{ $scheduleServiceBerkala->reminder }} hari sebelum jatuh tempo</div>
                                    <div><strong>Status:</strong> <span class="badge badge-{{ $scheduleServiceBerkala->status == 'Aktif' ? 'success' : 'secondary' }}">{{ $scheduleServiceBerkala->status }}</span></div>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-danger" onclick="deleteJadwalPemeliharaan({{ $scheduleServiceBerkala->id }})"><i class="fa-regular fa-trash-can"></i> Hapus</button>
                                    <button class="btn btn-outline-primary" onclick="showModalEditJadwalV2({{ $scheduleServiceBerkala->id }})"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                                    <button class="btn btn-outline-success" onclick="showModalAddPreventifV2({{ $scheduleServiceBerkala->id }})"><i class="fa-regular fa-circle-check"></i> TL</button>
                                </div>
                            @else
                                <button class="btn btn-outline-primary btn-sm" onclick="showModalAddJadwalV2('Service Berkala')"><i class="fa-regular fa-plus"></i> Atur Jadwal</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <hr class="my-4" /> 

        <div class="row align-items-center mt-3">
            <p class="col-8 h4">Pemeliharaan Preventif</p>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="tablePemeliharaanPreventif">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pemeliharaan</th>
                        <!-- <th>Waktu Pemeliharaan</th> -->
                        <th>Periode</th>
                        <th>PIC</th>
                        <th>Biaya</th>
                        <th>Catatan</th>
                        <th>Bukti Dukung</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="row align-items-center mt-3">
            <p class="col-12 h4">Pemeliharaan Korektif <button class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Tambah Pemeliharaan Korektif" onclick="showModalAddKorektif()" data-crud="true"><i
                       class="fa-solid fa-plus"></i></button></p>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="tablePemeliharaanKorektif">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Waktu Pemeliharaan</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        @include('admin.modals.add_korektif')
        @include('admin.modals.add-jadwal-preventifv2')
        @include('admin.modals.edit-jadwal-preventifv2')
        @include('admin.modals.add-tugas-preventifv2')


    </div>
@endsection

@push('script-foot')
    <script>
        // Countdown
        $(document).ready(function() {
            $('.countdown').each(function() {
                let target = new Date($(this).data('date'));
                let now = new Date();
                let diff = Math.ceil((target - now) / (1000 * 60 * 60 * 24));
                if (diff > 0) {
                    $(this).text(diff + ' hari lagi');
                } else if (diff === 0) {
                    $(this).text('Hari ini');
                } else {
                    $(this).text('Terlambat ' + Math.abs(diff) + ' hari');
                }
            });
        });

        // Handle Tabel
        $(document).ready(function() {
            tablePemeliharaanPreventif();
        });
        $(document).ready(function() {
            tablePemeliharaanKorektif();
        });

        function deleteJadwalPemeliharaan(id) {
            Swal.fire({
                title: 'Hapus Jadwal Pemeliharaan',
                text: "Apakah Anda yakin ingin menghapus jadwal pemeliharaan dengan ID " + id + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.aset.pemeliharaan.scheduleDelete', ['id' => ':id']) }}".replace(':id', id),
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "DELETE",
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                'Jadwal pemeliharaan telah dihapus.',
                                'success'
                            );
                            location.reload();
                        },
                        error: function(xhr) {
                            const msg = xhr.responseJSON?.message || 'Jadwal pemeliharaan gagal dihapus.';
                            Swal.fire('Gagal!', msg, 'error');
                        }
                    });
                }
            });
        }

        function tablePemeliharaanPreventif() {
            $('#tablePemeliharaanPreventif').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.aset.pemeliharaan.preventifDataTable', $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    // {
                    //     data: 'started_at',
                    //     name: 'started_at',
                    //     render: function(data, type, row) {
                    //         return moment(data).format('ll');
                    //     }
                    // },
                    {
                        data: 'period',
                        name: 'period',
                        render: function(data, type, row) {
                            return moment(data).format('DD MMM YYYY');
                        }
                    },
                    {
                        data: 'pic',
                        name: 'pic'
                    },
                    {
                        data: 'cost',
                        name: 'cost',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumFractionDigits: 0
                            }).format(data);
                        }
                    },
                    {
                        data: 'notes',
                        name: 'notes',
                        render: function(data, type, row) {
                            if (data.length > 50) {
                                return data.substring(0, 50) + '... <a href="#" onclick="showFullNotes(\'' + data.replace(/'/g, "\\'") + '\')">[Lihat Selengkapnya]</a>';
                            } else {
                                return data;
                            }
                        }
                    },
                    // {
                    //     data: 'attachment',
                    //     name: 'attachment',
                    //     render: function(data, type, row) {
                    //         if (data) {
                    //             return `<a href="{{ asset('storage') }}/${data}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-file-arrow-down"></i> Unduh</a>`;
                    //         } else {
                    //             return 'Tidak ada bukti dukung';
                    //         }
                    //     }
                    // },
                    {
                        data: 'attachment_link',
                        name: 'attachment_link',
                        render: function(data, type, row) {
                            if (data) {
                                return `<a href="${data}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-file-arrow-down"></i> Unduh</a>`;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        }

        function deletePreventif(id) {
            Swal.fire({
                title: 'Hapus Pemeliharaan Preventif',
                text: "Apakah Anda yakin ingin menghapus pemeliharaan preventif dengan ID " + id + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.aset.pemeliharaan.preventifDelete', ['id' => ':id']) }}".replace(':id', id),
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "DELETE",
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                'Jadwal pemeliharaan telah dihapus.',
                                'success'
                            );
                            $('#tablePemeliharaanPreventif').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Gagal!',
                                'Jadwal pemeliharaan gagal dihapus.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        function tablePemeliharaanKorektif() {
            $('#tablePemeliharaanKorektif').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.aset.pemeliharaan.korektifDataTable', $id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'completed_at',
                        name: 'completed_at',
                        // render: function(data, type, row) {
                        //     return moment(data).format('DD MMM YYYY');
                        // }
                        // buat fallback kalau completed_at null
                        render: function(data, type, row) {
                            if (data) {
                                return moment(data).format('DD MMM YYYY');
                            } else {
                                return '<span class="text-muted">Belum selesai</span>';
                            }
                        }
                    },
                    {
                        data: 'pic',
                        name: 'pic'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'notes',
                        name: 'notes'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        }
    </script>
@endpush
