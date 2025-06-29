<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid border-bottom">
        <div class="row mb-2 mt-2">
            <div class="col-sm-6">
                <h5><span class="badge badge-info text-wrap">{{isset($welcome) ? $welcome : ''}}</span></h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                    {{-- <li class="breadcrumb-item">{{ isset($breadcrumb) ? $breadcrumb : ''}}</li> --}}
                    {{ isset($breadcrumb) ? $breadcrumb : '' }}

                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section><!-- /.content-header -->
