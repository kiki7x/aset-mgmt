@extends('layouts.front', ['title' => 'Service Desk - SAPA PPL'])

@push('script-head')
    @stack('script-head')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap4.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush

@section('content')
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero-custom section dark-background">
            {{-- <div class="container"> --}}
            {{-- </div> --}}
        </section><!-- End Hero Section -->

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container">
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="">Layanan</li>
                        <li class="current">Service Desk</li>
                    </ol>
                </nav>
                {{-- <h1>Layanan</h1> --}}
            </div>
        </div><!-- End Page Title -->

        <!-- Services Section -->
        <section id="" class="">
            <div class="container">
                <h2>Service Desk berbasis Tiket</h2>
                <p>Fitur Service Desk Sarana & Prasarana berbasis Tiket digunakan untuk mengelola permintaan layanan sarana dan prasarana yang diajukan oleh pengguna. Dengan fitur ini, pengguna dapat mengajukan tiket permintaan layanan, melacak status tiket, dan
                    berkomunikasi dengan tim layanan untuk memastikan permintaan mereka ditangani dengan efisien dan tepat waktu.</p>
            </div><!-- End Section Title -->



            <div class="container">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">List Tiket Service Desk</h5>
                        <button class="btn btn-outline-primary" onclick="openModalCreate()" style="margin-left: auto;" data-toggle="tooltip" data-placement="top" title="Buat Tiket"><i class="fa-regular fa-plus"></i> Buat Tiket</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablePemeliharaan" class="table table-bordered table-striped table-hover table-sm table-responsive-md">
                                <thead>
                                    <tr>
                                        <th>Tiket</th>
                                        <th>Pemohon</th>
                                        <th>Jenis & Bidang</th>
                                        <th>Judul</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">Prioritas</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @include('frontsite.partials.createtiket')
        </section><!-- /Services Section -->
    </main><!-- End #main -->


    @push('script-foot')

        <script>

        $(document).ready(function(){
            tablePemeliharaan();
        });

        function tablePemeliharaan(){

        $('#tablePemeliharaan').DataTable({

        processing:true,
        serverSide:true,
        responsive:true,

        ajax:"{{ route('servicedesk.data') }}",

        columns:[
        {data:'ticket',name:'ticket'},
        {data:'nama',name:'nama'},
        {
        data:null,
        render:function(data,type,row){
        return row.issuetype + " - " + row.department;
        }
        },
        {data:'subject',name:'subject'},
        {data:'description',name:'description'},
        {
        data:'priority',
        name:'priority',
        render:function(data){

        if(data == 'Low'){
        return '<span style="color:#6c757d;"><i class="fa-solid fa-flag"></i> Rendah</span>';
        }

        if(data == 'Medium'){
        return '<span style="color:#f4b400;"><i class="fa-solid fa-flag"></i> Sedang</span>';
        }

        if(data == 'High'){
        return '<span style="color:#dc3545;"><i class="fa-solid fa-flag"></i> Tinggi</span>';
        }

        return data;

        }
        },
        {
        data:'status',
        name:'status'
        },
        {data:'duedate',name:'duedate'},
        ]

        });

        }

        $(document).on('submit','#formCreateTicket',function(e){

        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({

        url:"{{ route('servicedesk.store') }}",
        type:"POST",
        data:formData,
        processData:false,
        contentType:false,

        success:function(response){

        if(response.success){

        Swal.fire({
        icon:'success',
        title:'Berhasil',
        text:response.message,
        confirmButtonColor:'#3085d6'
        }).then(()=>{

        $('#modalCreateTicket').modal('hide');

        $('#formCreateTicket')[0].reset();

        $('#tablePemeliharaan').DataTable().ajax.reload();

        });

        }

        }

        });

        });

        </script>

        @endpush

@endsection
