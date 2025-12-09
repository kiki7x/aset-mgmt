@extends('layouts.front', ['title' => 'Statistik - SAPA PPL'])

@push('scripts-head')
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
                        <li class="current">Statistik</li>
                    </ol>
                </nav>
                {{-- <h1>Layanan</h1> --}}
            </div>
        </div><!-- End Page Title -->

        <!-- Skills Section -->
        <section id="skills" class="skills section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Statistik</h2>
            </div><!-- End Section Title -->
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row">
                    <div class="col-lg-4 pt-4 pt-lg-0 content">
                        <h3>Progress</h3>
                        <p class="fst-italic">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                        <div class="skills-content skills-animation">
                            <div class="progress">
                                <span class="skill"><span>Jumlah Aset</span> <i class="val">{{ $assets->count() }}</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div><!-- End Skills Item -->
                            <div class="progress">
                                <span class="skill"><span>Progres Pendataan Aset</span> <i class="val">75%</i></span>
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PIE CHART -->
                    <div class="col-lg-8 pt-4 pt-lg-0 content">
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

        </section><!-- /Skills Section -->
    </main><!-- End #main -->
@endsection

@push('scripts')
<script>
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    const barChartCanvas = $('#barChart').get(0).getContext('2d')
    const barData = {
        labels: ['Aset TIK', 'Aset Rumah Tangga'],
        datasets: [{
                label: 'Kondisi baik',
                data: [150, 350],
                borderColor: '#00a65a',
                backgroundColor: '#00a65a33',
                borderWidth: 1,
            },
            {
                label: 'Kondisi rusak',
                data: [35, 25],
                borderColor: '#f56954',
                backgroundColor: '#f5695433',
                borderWidth: 1,
            },
            {
                label: 'Kondisi dalam pemeliharaan',
                data: [25, 18],
                borderColor: '#f39c12',
                backgroundColor: '#f39c1233',
                borderWidth: 1,
            }
        ],
    };

    const config = {
        type: 'bar',
        data: barData,
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                position: 'top'
            },
            title: {
                display: true,
                text: 'Statistik Aset'
            }
        }
    }
    //Create bar chart
    // You can switch between pie and douhnut using the method below.
    new Chart(barChartCanvas, config)
</script>
@endpush
