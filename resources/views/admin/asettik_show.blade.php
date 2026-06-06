@extends('layouts.backsite')

@section('title', 'Kelola Aset TIK')

@section('script-head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs (Pulled to the right) -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="?route=inventory/assets/manage&amp;id=1&amp;section=">Summary</a></li>
                        <li><a href="?route=inventory/assets/manage&amp;id=1&amp;section=issues">Issues</a></li>
                        <li><a href="?route=inventory/assets/manage&amp;id=1&amp;section=tickets">Tickets</a></li>
                        <li><a href="?route=inventory/assets/manage&amp;id=1&amp;section=files">Files</a></li>
                        <li><a href="?route=inventory/assets/manage&amp;id=1&amp;section=timelog">Time Log</a></li>
                        <li><a href="?route=inventory/assets/manage&amp;id=1&amp;section=edit">Edit Asset</a></li>
                        <div class="btn-group pull-right" style="padding:6px;">
                            <a data-toggle="tooltip" title="New Issue" class="btn btn-default btn-sm btn-flat" href="#" data-crud="true"
                               onclick="showM(&quot;?modal=issues/add&amp;reroute=inventory/assets/manage&amp;routeid=1&amp;clientid=1&amp;assetid=1&amp;section=issues&quot;);return false" data-crud="true"><i class="fa fa-tasks fa-fw"></i> New Issue</a> <a
                               class="btn btn-default btn-sm btn-flat" href="#" data-crud="true" onclick="showM(&quot;?modal=time/add&amp;reroute=inventory/assets/manage&amp;routeid=1&amp;clientid=1&amp;assetid=1&amp;section=timelog&quot;);return false"><i
                                   class="fa fa-clock-o fa-fw"></i> Log Time</a>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                    More <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right">

                                        <li><a href="#" data-crud="true" onclick="showM(&quot;?modal=tickets/add&amp;reroute=inventory/assets/manage&amp;routeid=1&amp;clientid=1&amp;assetid=1&amp;section=tickets&quot;);return false"><i class="fa fa-tag fa-fw"></i>New Ticket</a>
                                    </li>
                                        <li><a href="#" data-crud="true" onclick="showM(&quot;?modal=credentials/add&amp;section=&amp;reroute=inventory/assets/manage&amp;routeid=1&amp;assetid=1&amp;clientid=1&quot;);return false"><i class="fa fa-asterisk fa-fw"></i>New
                                            Credential</a></li>
                                        <li><a href="#" data-crud="true" onclick="showM(&quot;?modal=files/upload&amp;reroute=inventory/assets/manage&amp;routeid=1&amp;clientid=1&amp;assetid=1&amp;section=files&quot;);return false"><i class="fa fa-upload fa-fw"></i>Upload
                                            File</a></li>
                                        <li><a href="#" data-crud="true" onclick="showM(&quot;?modal=assets/assignLicense&amp;section=&amp;reroute=inventory/assets/manage&amp;routeid=1&quot;);return false"><i class="fa fa-thumb-tack fa-fw"></i>Assign License</a></li>
                                    <li><a href="?route=pdf&amp;type=assetlabel&amp;id=1" target="_blank"><i class="fa fa-barcode fa-fw"></i>Label</a></li>
                                </ul>
                            </div>
                        </div>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-summary">
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="box box-primary">
                                        <div class="box-body">
                                            <table id="clientTable" class="table table-striped table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td><b>Status</b></td>
                                                        <td><span class="badge" style="background-color:#3479da">Deployed</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Tag</b></td>
                                                        <td>IT-1</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Name</b></td>
                                                        <td>Desktop 1</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Category</b></td>
                                                        <td><span class="label" style="background-color:#FFF;color:#1e3fda;border:1px solid #1e3fda">Desktops</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Location</b></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Client</b></td>
                                                        <td><a href="?route=clients/manage&amp;id=1">Politeknik Pariwisata Lombok</a></td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Manufacturer</b></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Model</b></td>
                                                        <td>Optiplex 3020 MT</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Supplier</b></td>
                                                        <td><a href="#" onclick="showM(&quot;?modal=suppliers/view&amp;id=1&quot;);return false">PT Jedag Jedug</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Serial Number</b></td>
                                                        <td>QWERT12345</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Asset Admin</b></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Asset User</b></td>
                                                        <td>
                                                            <a href="?route=people/users/edit&amp;id=0"></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Purchase Date</b></td>
                                                        <td>01-02-2016</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Warranty (months)</b></td>
                                                        <td>24</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-8">
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <h3 class="box-title">Credentials</h3>
                                            <div class="pull-right box-tools">
                                                <button type="button" class="btn btn-default btn-sm btn-flat" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Type</th>
                                                            <th>Username</th>
                                                            <th>Password</th>
                                                            <th class="text-right"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            There are no credentials to display.
                                        </div>
                                    </div>
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <h3 class="box-title">Assigned Licenses</h3>
                                            <div class="pull-right box-tools">
                                                <button type="button" class="btn btn-default btn-sm btn-flat" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Tag</th>
                                                            <th>Category</th>
                                                            <th>Name</th>
                                                            <th class="text-right"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><a href="?route=inventory/licenses/manage&amp;id=3">ITL-3</a></td>
                                                            <td>Operating Systems</td>
                                                            <td><a href="?route=inventory/licenses/manage&amp;id=3">Windows Server 2012 R2 Essentials</a></td>
                                                            <td>
                                                                 <div class="pull-right"><a href="#" data-crud="true" onclick="showM(&quot;?modal=assets/unassignLicense&amp;section=&amp;reroute=inventory/assets/manage&amp;routeid=1&amp;id=1&quot;);return false"
                                                                     class="btn btn-flat btn-danger btn-sm"><i class="fa fa-trash-o"></i></a></div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><a href="?route=inventory/licenses/manage&amp;id=2">ITL-2</a></td>
                                                            <td>Operating Systems</td>
                                                            <td><a href="?route=inventory/licenses/manage&amp;id=2">Office Home &amp; Business 2016</a></td>
                                                            <td>
                                                                 <div class="pull-right"><a href="#" data-crud="true" onclick="showM(&quot;?modal=assets/unassignLicense&amp;section=&amp;reroute=inventory/assets/manage&amp;routeid=1&amp;id=2&quot;);return false"
                                                                       class="btn btn-flat btn-danger btn-sm"><i class="fa fa-trash-o"></i></a></div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <h3 class="box-title">Notes</h3>
                                            <div class="pull-right box-tools">
                                                <button type="button" class="btn btn-default btn-sm btn-flat" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane " id="tab-issues">
                            <div class="table-responsive">
                                <div id="dataTablesFullDesc_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="top">
                                        <div id="dataTablesFullDesc_filter" class="dataTables_filter"><label><i class="fa fa-search text-gray dTsearch"></i><input type="search" class="form-control input-sm" placeholder=""
                                                       aria-controls="dataTablesFullDesc"></label></div>
                                    </div>
                                    <table id="dataTablesFullDesc" class="table table-striped table-hover table-bordered dataTable no-footer" role="grid" aria-describedby="dataTablesFullDesc_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting_desc" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-sort="descending" aria-label="ID: activate to sort column ascending" style="width: 0px;">ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 0px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Assigned To: activate to sort column ascending" style="width: 0px;">Assigned To</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Related Entities: activate to sort column ascending" style="width: 0px;">Related Entities</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 0px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Due Date: activate to sort column ascending" style="width: 0px;">Due Date</th>
                                                <th class="text-right sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 0px;"></th>
                                            </tr>
                                        </thead>

                                        <tbody style="">
                                            <tr class="odd">
                                                <td valign="top" colspan="7" class="dataTables_empty">No entries to show</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="bottom"></div>
                                    <div class="row dt-margin">
                                        <div class="col-md-6">
                                            <div class="dataTables_info" id="dataTablesFullDesc_info" role="status" aria-live="polite"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="dataTables_paginate paging_simple_numbers" id="dataTablesFullDesc_paginate">
                                                <ul class="pagination">
                                                    <li class="paginate_button previous disabled" id="dataTablesFullDesc_previous"><a href="#" aria-controls="dataTablesFullDesc" data-dt-idx="0" tabindex="0">Previous</a></li>
                                                    <li class="paginate_button next disabled" id="dataTablesFullDesc_next"><a href="#" aria-controls="dataTablesFullDesc" data-dt-idx="1" tabindex="0">Next</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="dt-buttons btn-group"><a class="btn btn-default buttons-copy buttons-html5" tabindex="0" aria-controls="dataTablesFullDesc" href="#"><span>Copy</span></a><a
                                                   class="btn btn-default buttons-csv buttons-html5" tabindex="0" aria-controls="dataTablesFullDesc" href="#"><span>CSV</span></a><a class="btn btn-default buttons-excel buttons-html5" tabindex="0"
                                                   aria-controls="dataTablesFullDesc" href="#"><span>Excel</span></a><a class="btn btn-default buttons-pdf buttons-html5" tabindex="0" aria-controls="dataTablesFullDesc"
                                                   href="#"><span>PDF</span></a><a class="btn btn-default buttons-print" tabindex="0" aria-controls="dataTablesFullDesc" href="#"><span>Print</span></a></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>


                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane " id="tab-tickets">
                            <div class="table-responsive">
                                <div id="dataTablesFullNoOrder_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="top">
                                        <div id="dataTablesFullNoOrder_filter" class="dataTables_filter"><label><i class="fa fa-search text-gray dTsearch"></i><input type="search" class="form-control input-sm" placeholder=""
                                                       aria-controls="dataTablesFullNoOrder"></label></div>
                                    </div>
                                    <table id="dataTablesFullNoOrder" class="table table-striped table-hover table-bordered dataTable no-footer" role="grid" aria-describedby="dataTablesFullNoOrder_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullNoOrder" rowspan="1" colspan="1" aria-label="Ticket #: activate to sort column ascending" style="width: 0px;">Ticket #</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullNoOrder" rowspan="1" colspan="1" aria-label="Subject: activate to sort column ascending" style="width: 0px;">Subject</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullNoOrder" rowspan="1" colspan="1" aria-label="Submitter: activate to sort column ascending" style="width: 0px;">Submitter</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullNoOrder" rowspan="1" colspan="1" aria-label="Assigned To: activate to sort column ascending" style="width: 0px;">Assigned To</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullNoOrder" rowspan="1" colspan="1" aria-label="Related Entities: activate to sort column ascending" style="width: 0px;">Related Entities</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullNoOrder" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending" style="width: 0px;">Department</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullNoOrder" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 0px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullNoOrder" rowspan="1" colspan="1" aria-label="Last Reply: activate to sort column ascending" style="width: 0px;">Last Reply</th>
                                                <th class="text-right sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 0px;"></th>
                                            </tr>
                                        </thead>

                                        <tbody style="">
                                            <tr class="odd">
                                                <td valign="top" colspan="9" class="dataTables_empty">No entries to show</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="bottom"></div>
                                    <div class="row dt-margin">
                                        <div class="col-md-6">
                                            <div class="dataTables_info" id="dataTablesFullNoOrder_info" role="status" aria-live="polite"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="dataTables_paginate paging_simple_numbers" id="dataTablesFullNoOrder_paginate">
                                                <ul class="pagination">
                                                    <li class="paginate_button previous disabled" id="dataTablesFullNoOrder_previous"><a href="#" aria-controls="dataTablesFullNoOrder" data-dt-idx="0" tabindex="0">Previous</a></li>
                                                    <li class="paginate_button next disabled" id="dataTablesFullNoOrder_next"><a href="#" aria-controls="dataTablesFullNoOrder" data-dt-idx="1" tabindex="0">Next</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="dt-buttons btn-group"><a class="btn btn-default buttons-copy buttons-html5" tabindex="0" aria-controls="dataTablesFullNoOrder" href="#"><span>Copy</span></a><a
                                                   class="btn btn-default buttons-csv buttons-html5" tabindex="0" aria-controls="dataTablesFullNoOrder" href="#"><span>CSV</span></a><a class="btn btn-default buttons-excel buttons-html5" tabindex="0"
                                                   aria-controls="dataTablesFullNoOrder" href="#"><span>Excel</span></a><a class="btn btn-default buttons-pdf buttons-html5" tabindex="0" aria-controls="dataTablesFullNoOrder"
                                                   href="#"><span>PDF</span></a><a class="btn btn-default buttons-print" tabindex="0" aria-controls="dataTablesFullNoOrder" href="#"><span>Print</span></a></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>


                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane " id="tab-files">
                            <div class="alert alert-info">
                                <i class="icon fa fa-info"></i> No files have been uploaded yet!
                            </div>

                            <ul class="todo-list list-inline ui-sortable" id="fileslist">
                            </ul>

                        </div>
                        <!-- /.tab-pane -->


                        <div class="tab-pane " id="tab-timelog">
                            <div class="table-responsive">
                                <div id="dataTablesFullDesc_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="top">
                                        <div id="dataTablesFullDesc_filter" class="dataTables_filter"><label><i class="fa fa-search text-gray dTsearch"></i><input type="search" class="form-control input-sm" placeholder=""
                                                       aria-controls="dataTablesFullDesc"></label></div>
                                    </div>
                                    <table id="dataTablesFullDesc" class="table table-striped table-hover table-bordered dataTable no-footer" role="grid" aria-describedby="dataTablesFullDesc_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting_desc" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-sort="descending" aria-label="ID: activate to sort column ascending" style="width: 0px;">ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Date &amp;amp; Time: activate to sort column ascending" style="width: 0px;">Date &amp; Time</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Duration: activate to sort column ascending" style="width: 0px;">Duration</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Staff: activate to sort column ascending" style="width: 0px;">Staff</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Asset: activate to sort column ascending" style="width: 0px;">Asset</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Project: activate to sort column ascending" style="width: 0px;">Project</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Tagged Items: activate to sort column ascending" style="width: 0px;">Tagged Items</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTablesFullDesc" rowspan="1" colspan="1" aria-label="Description: activate to sort column ascending" style="width: 0px;">Description</th>
                                                <th class="text-right sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 0px;"></th>
                                            </tr>
                                        </thead>

                                        <tbody style="">

                                            <tr role="row" class="odd">
                                                <td class="sorting_1">3</td>
                                                <td>03-02-2016 00:00:00 <i class="fa fa-long-arrow-right"></i> 00:45:00</td>
                                                <td>
                                                    00:45 </td>
                                                <td>
                                                    <span class="text-muted">Nobody</span>
                                                </td>

                                                <td>
                                                    <a href="?route=inventory/assets/manage&amp;id=1">
                                                        <span class="label" style="background-color:#FFF;color:#001F3F;border:1px solid #001F3F;"><i class="fa fa-desktop fa-fw"></i> IT-1 </span>
                                                    </a>
                                                </td>

                                                <td>
                                                </td>

                                                <td>
                                                    <span class="badge bg-teal"><i class="fa fa-tasks fa-fw"></i> </span>
                                                </td>

                                                <td>Coverted from issue's time spent during 1.11 version upgrade.</td>
                                                <td>
                                                            <div class="pull-right">
                                                        <div class="btn-group">
                                                            <a href="#" data-crud="true" onclick="showM(&quot;?modal=time/edit&amp;reroute=inventory/assets/manage&amp;routeid=1&amp;id=3&amp;section=timelog&quot;);return false" class="btn btn-flat btn-success btn-sm"><i
                                                                   class="fa fa-edit"></i></a> <a href="#" data-crud="true" onclick="showM(&quot;?modal=time/delete&amp;reroute=inventory/assets/manage&amp;routeid=1&amp;id=3&amp;section=timelog&quot;);return false"
                                                               class="btn btn-flat btn-danger btn-sm"><i class="fa fa-trash-o"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="bottom"></div>
                                    <div class="row dt-margin">
                                        <div class="col-md-6">
                                            <div class="dataTables_info" id="dataTablesFullDesc_info" role="status" aria-live="polite">Showing 1 to 1 of 1 entries</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="dataTables_paginate paging_simple_numbers" id="dataTablesFullDesc_paginate">
                                                <ul class="pagination">
                                                    <li class="paginate_button previous disabled" id="dataTablesFullDesc_previous"><a href="#" aria-controls="dataTablesFullDesc" data-dt-idx="0" tabindex="0">Previous</a></li>
                                                    <li class="paginate_button active"><a href="#" aria-controls="dataTablesFullDesc" data-dt-idx="1" tabindex="0">1</a></li>
                                                    <li class="paginate_button next disabled" id="dataTablesFullDesc_next"><a href="#" aria-controls="dataTablesFullDesc" data-dt-idx="2" tabindex="0">Next</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="dt-buttons btn-group"><a class="btn btn-default buttons-copy buttons-html5" tabindex="0" aria-controls="dataTablesFullDesc" href="#"><span>Copy</span></a><a
                                                   class="btn btn-default buttons-csv buttons-html5" tabindex="0" aria-controls="dataTablesFullDesc" href="#"><span>CSV</span></a><a class="btn btn-default buttons-excel buttons-html5" tabindex="0"
                                                   aria-controls="dataTablesFullDesc" href="#"><span>Excel</span></a><a class="btn btn-default buttons-pdf buttons-html5" tabindex="0" aria-controls="dataTablesFullDesc"
                                                   href="#"><span>PDF</span></a><a class="btn btn-default buttons-print" tabindex="0" aria-controls="dataTablesFullDesc" href="#"><span>Print</span></a></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane " id="tab-edit">
                            <div class="row">
                                <div class="container-fluid">

                                    <form role="form" method="post">


                                        <div class="col-md-6">

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="clientid">Client</label>
                                                        <select class="form-control select2 select2-hidden-accessible" id="clientid" name="clientid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                            <option value="0">None</option>
                                                            <option value="1" selected="">Politeknik Pariwisata Lombok</option>
                                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single"
                                                                      role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-labelledby="select2-clientid-container"><span class="select2-selection__rendered"
                                                                          id="select2-clientid-container" title="Politeknik Pariwisata Lombok">Politeknik Pariwisata Lombok</span><span class="select2-selection__arrow" role="presentation"><b
                                                                           role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="tag">Asset Tag *</label>
                                                        <input type="text" class="form-control" id="tag" name="tag" value="IT-1" required="">
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="name">Asset Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="Desktop 1">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="category">Category *</label>
                                                        <select class="form-control select2tag select2-hidden-accessible" id="category" name="category" style="width: 100%;" tabindex="-1" aria-hidden="true" multiple="">
                                                            <option value="Desktops" selected="">Desktops</option>
                                                            <option value="Laptops">Laptops</option>
                                                            <option value="Servers">Servers</option>
                                                            <option value="Printers">Printers</option>
                                                            <option value="Routers">Routers</option>
                                                            <option value="Switch Managed">Switch Managed</option>
                                                            <option value="Switch UnManaged">Switch UnManaged</option>
                                                            <option value="AIO Desktops">AIO Desktops</option>
                                                            <option value="Monitors">Monitors</option>
                                                            <option value="Projectors">Projectors</option>
                                                            <option value="NVR (Network Video Recorder)">NVR (Network Video Recorder)</option>
                                                            <option value="IP Camera">IP Camera</option>
                                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--multiple"
                                                                      role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1">
                                                                    <ul class="select2-selection__rendered">
                                                                        <li class="select2-selection__choice" title="Desktops"><span class="select2-selection__choice__remove" role="presentation">×</span>Desktops</li>
                                                                        <li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off"
                                                                                   spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li>
                                                                    </ul>
                                                                </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="supplier">Supplier</label>
                                                        <select class="form-control select2tag select2-hidden-accessible" id="supplier" name="supplier" style="width: 100%;" tabindex="-1" aria-hidden="true" multiple="">
                                                            <option value="PT Jedag Jedug" selected="">PT Jedag Jedug</option>
                                                            <option value="CV Ngaiti">CV Ngaiti</option>
                                                            <option value="UD Persediaan ITiers">UD Persediaan ITiers</option>
                                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--multiple"
                                                                      role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1">
                                                                    <ul class="select2-selection__rendered">
                                                                        <li class="select2-selection__choice" title="PT Jedag Jedug"><span class="select2-selection__choice__remove" role="presentation">×</span>PT Jedag Jedug</li>
                                                                        <li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off"
                                                                                   spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li>
                                                                    </ul>
                                                                </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="location">Location</label>
                                                        <select class="form-control select2tag select2-hidden-accessible" id="location" name="location" style="width: 100%;" tabindex="-1" aria-hidden="true" multiple="">

                                                            <option value="Rektorat">Rektorat</option>
                                                            <option value="Gedung Kuliah 1">Gedung Kuliah 1</option>
                                                            <option value="Gedung Kuliah 2">Gedung Kuliah 2</option>
                                                            <option value="Hotel DBSH">Hotel DBSH</option>
                                                            <option value="Masjid Al-Hanif">Masjid Al-Hanif</option>
                                                            <option value="Gedung Kuliah Terpadu">Gedung Kuliah Terpadu</option>
                                                            <option value="Zona B">Zona B</option>
                                                            <option value="Kantin">Kantin</option>
                                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--multiple"
                                                                      role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1">
                                                                    <ul class="select2-selection__rendered">
                                                                        <li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off"
                                                                                   spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li>
                                                                    </ul>
                                                                </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12"></div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="statusid">Status *</label>
                                                        <select class="form-control select2 select2-hidden-accessible" id="statusid" name="statusid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                            <option value="1">Requested</option>
                                                            <option value="2">Pending</option>
                                                            <option value="3" selected="">Deployed</option>
                                                            <option value="4">Archived</option>
                                                            <option value="5">In Repair</option>
                                                            <option value="6">Broken</option>
                                                            <option value="7">Deposit</option>
                                                            <option value="8">Withdraw</option>
                                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single"
                                                                      role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-labelledby="select2-statusid-container"><span class="select2-selection__rendered"
                                                                          id="select2-statusid-container" title="Deployed">Deployed</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span
                                                                  class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="userid">Asset User</label>
                                                        <select class="form-control select2 select2-hidden-accessible" id="userid" name="userid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                            <option value="0">None</option>
                                                            <option value="5">tester</option>
                                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single"
                                                                      role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-labelledby="select2-userid-container"><span class="select2-selection__rendered"
                                                                          id="select2-userid-container" title="None">None</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span
                                                                  class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="adminid">Asset Admin</label>
                                                        <select class="form-control select2 select2-hidden-accessible" id="adminid" name="adminid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                            <option value="0">None</option>
                                                            <option value="1">superadmin</option>
                                                            <option value="2">kiki7x</option>
                                                            <option value="3">zakaria</option>
                                                            <option value="4">pati</option>
                                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single"
                                                                      role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-labelledby="select2-adminid-container"><span class="select2-selection__rendered"
                                                                          id="select2-adminid-container" title="None">None</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span
                                                                  class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="manufacturer">Manufacturer</label>
                                                        <select class="form-control select2tag select2-hidden-accessible" id="manufacturer" name="manufacturer" style="width: 100%;" tabindex="-1" aria-hidden="true" multiple="">
                                                            <option value="Apple">Apple</option>
                                                            <option value="Dell">Dell</option>
                                                            <option value="Microsoft">Microsoft</option>
                                                            <option value="HP">HP</option>
                                                            <option value="Samsung">Samsung</option>
                                                            <option value="ASUS">ASUS</option>
                                                            <option value="Canon">Canon</option>
                                                            <option value="Cisco">Cisco</option>
                                                            <option value="Lenovo">Lenovo</option>
                                                            <option value="Acer">Acer</option>
                                                            <option value="Epson">Epson</option>
                                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--multiple"
                                                                      role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1">
                                                                    <ul class="select2-selection__rendered">
                                                                        <li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off"
                                                                                   spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li>
                                                                    </ul>
                                                                </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="model">Model</label>
                                                        <select class="form-control select2tag select2-hidden-accessible" id="model" name="model" style="width: 100%;" tabindex="-1" aria-hidden="true" multiple="">
                                                            <option value="MacBook Pro">MacBook Pro</option>
                                                            <option value="MacBook Air">MacBook Air</option>
                                                            <option value="PowerEdge R220">PowerEdge R220</option>
                                                            <option value="Optiplex 3020 MT" selected="">Optiplex 3020 MT</option>
                                                        </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--multiple"
                                                                      role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1">
                                                                    <ul class="select2-selection__rendered">
                                                                        <li class="select2-selection__choice" title="Optiplex 3020 MT"><span class="select2-selection__choice__remove" role="presentation">×</span>Optiplex 3020 MT</li>
                                                                        <li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off"
                                                                                   spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li>
                                                                    </ul>
                                                                </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <input type="hidden" name="qrvalue" value="">
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="purchase_date">Purchase Date</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="purchase_date" name="purchase_date" value="01-02-2016">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="warranty_months">Warranty</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="warranty_months" name="warranty_months" value="24">
                                                            <span class="input-group-addon">months</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="serial">Serial Number</label>
                                                        <input type="text" class="form-control" id="serial" name="serial" value="QWERT12345">
                                                    </div>
                                                </div>





                                            </div>


                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="notes">Notes</label>
                                                <textarea class="form-control summernoteLarge" id="notes" name="notes" style="display: none;"></textarea>
                                                <div class="note-editor note-frame panel panel-default">
                                                    <div class="note-dropzone">
                                                        <div class="note-dropzone-message"></div>
                                                    </div>
                                                    <div class="note-toolbar panel-heading">
                                                        <div class="note-btn-group btn-group note-style">
                                                            <div class="note-btn-group btn-group"><button type="button" class="note-btn btn btn-default btn-sm dropdown-toggle" tabindex="-1" data-toggle="dropdown" title=""
                                                                        data-original-title="Style"><i class="note-icon-magic"></i> <span class="note-icon-caret"></span></button>
                                                                <div class="dropdown-menu dropdown-style">
                                                                    <li><a href="#" data-value="p">
                                                                            <p>Normal</p>
                                                                        </a></li>
                                                                    <li><a href="#" data-value="blockquote">
                                                                            <blockquote>Quote</blockquote>
                                                                        </a></li>
                                                                    <li><a href="#" data-value="pre">
                                                                            <pre>Code</pre>
                                                                        </a></li>
                                                                    <li><a href="#" data-value="h1">
                                                                            <h1>Header 1</h1>
                                                                        </a></li>
                                                                    <li><a href="#" data-value="h2">
                                                                            <h2>Header 2</h2>
                                                                        </a></li>
                                                                    <li><a href="#" data-value="h3">
                                                                            <h3>Header 3</h3>
                                                                        </a></li>
                                                                    <li><a href="#" data-value="h4">
                                                                            <h4>Header 4</h4>
                                                                        </a></li>
                                                                    <li><a href="#" data-value="h5">
                                                                            <h5>Header 5</h5>
                                                                        </a></li>
                                                                    <li><a href="#" data-value="h6">
                                                                            <h6>Header 6</h6>
                                                                        </a></li>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="note-btn-group btn-group note-font"><button type="button" class="note-btn btn btn-default btn-sm note-btn-bold" tabindex="-1" title="" data-original-title="Bold (CTRL+B)"><i
                                                                   class="note-icon-bold"></i></button><button type="button" class="note-btn btn btn-default btn-sm note-btn-underline" tabindex="-1" title="" data-original-title="Underline (CTRL+U)"><i
                                                                   class="note-icon-underline"></i></button><button type="button" class="note-btn btn btn-default btn-sm" tabindex="-1" title="" data-original-title="Remove Font Style (CTRL+\)"><i
                                                                   class="note-icon-eraser"></i></button></div>
                                                        <div class="note-btn-group btn-group note-fontname">
                                                            <div class="note-btn-group btn-group"><button type="button" class="note-btn btn btn-default btn-sm dropdown-toggle" tabindex="-1" data-toggle="dropdown" title=""
                                                                        data-original-title="Font Family"><span class="note-current-fontname">Source Sans Pro</span> <span class="note-icon-caret"></span></button>
                                                                <div class="dropdown-menu note-check dropdown-fontname">
                                                                    <li><a href="#" data-value="Arial" class=""><i class="note-icon-check"></i> <span style="font-family:Arial">Arial</span></a></li>
                                                                    <li><a href="#" data-value="Arial Black" class=""><i class="note-icon-check"></i> <span style="font-family:Arial Black">Arial Black</span></a></li>
                                                                    <li><a href="#" data-value="Comic Sans MS" class=""><i class="note-icon-check"></i> <span style="font-family:Comic Sans MS">Comic Sans MS</span></a></li>
                                                                    <li><a href="#" data-value="Courier New" class=""><i class="note-icon-check"></i> <span style="font-family:Courier New">Courier New</span></a></li>
                                                                    <li><a href="#" data-value="Helvetica" class=""><i class="note-icon-check"></i> <span style="font-family:Helvetica">Helvetica</span></a></li>
                                                                    <li><a href="#" data-value="Impact" class=""><i class="note-icon-check"></i> <span style="font-family:Impact">Impact</span></a></li>
                                                                    <li><a href="#" data-value="Tahoma" class=""><i class="note-icon-check"></i> <span style="font-family:Tahoma">Tahoma</span></a></li>
                                                                    <li><a href="#" data-value="Times New Roman" class=""><i class="note-icon-check"></i> <span style="font-family:Times New Roman">Times New Roman</span></a></li>
                                                                    <li><a href="#" data-value="Verdana" class=""><i class="note-icon-check"></i> <span style="font-family:Verdana">Verdana</span></a></li>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="note-btn-group btn-group note-color">
                                                            <div class="note-btn-group btn-group note-color"><button type="button" class="note-btn btn btn-default btn-sm note-current-color-button" tabindex="-1" title=""
                                                                        data-original-title="Recent Color" data-backcolor="#FFFF00"><i class="note-icon-font note-recent-color" style="background-color: rgb(255, 255, 0);"></i></button><button
                                                                        type="button" class="note-btn btn btn-default btn-sm dropdown-toggle" tabindex="-1" data-toggle="dropdown" title="" data-original-title="More Color"><span
                                                                          class="note-icon-caret"></span></button>
                                                                <div class="dropdown-menu">
                                                                    <li>
                                                                        <div class="btn-group">
                                                                            <div class="note-palette-title">Background Color</div>
                                                                            <div> <button type="button" class="note-color-reset btn btn-default" data-event="backColor" data-value="inherit">Transparent </button> </div>
                                                                            <div class="note-holder" data-event="backColor">
                                                                                <div class="note-color-palette">
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#000000" data-event="backColor" data-value="#000000" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#000000"></button><button type="button" class="note-color-btn" style="background-color:#424242"
                                                                                                data-event="backColor" data-value="#424242" title="" data-toggle="button" tabindex="-1" data-original-title="#424242"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#636363" data-event="backColor" data-value="#636363" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#636363"></button><button type="button" class="note-color-btn" style="background-color:#9C9C94" data-event="backColor"
                                                                                                data-value="#9C9C94" title="" data-toggle="button" tabindex="-1" data-original-title="#9C9C94"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#CEC6CE" data-event="backColor" data-value="#CEC6CE" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#CEC6CE"></button><button type="button" class="note-color-btn" style="background-color:#EFEFEF" data-event="backColor"
                                                                                                data-value="#EFEFEF" title="" data-toggle="button" tabindex="-1" data-original-title="#EFEFEF"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#F7F7F7" data-event="backColor" data-value="#F7F7F7" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#F7F7F7"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="backColor"
                                                                                                data-value="#FFFFFF" title="" data-toggle="button" tabindex="-1" data-original-title="#FFFFFF"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#FF0000" data-event="backColor" data-value="#FF0000" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#FF0000"></button><button type="button" class="note-color-btn" style="background-color:#FF9C00"
                                                                                                data-event="backColor" data-value="#FF9C00" title="" data-toggle="button" tabindex="-1" data-original-title="#FF9C00"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#FFFF00" data-event="backColor" data-value="#FFFF00" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#FFFF00"></button><button type="button" class="note-color-btn" style="background-color:#00FF00" data-event="backColor"
                                                                                                data-value="#00FF00" title="" data-toggle="button" tabindex="-1" data-original-title="#00FF00"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#00FFFF" data-event="backColor" data-value="#00FFFF" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#00FFFF"></button><button type="button" class="note-color-btn" style="background-color:#0000FF" data-event="backColor"
                                                                                                data-value="#0000FF" title="" data-toggle="button" tabindex="-1" data-original-title="#0000FF"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#9C00FF" data-event="backColor" data-value="#9C00FF" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#9C00FF"></button><button type="button" class="note-color-btn" style="background-color:#FF00FF" data-event="backColor"
                                                                                                data-value="#FF00FF" title="" data-toggle="button" tabindex="-1" data-original-title="#FF00FF"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#F7C6CE" data-event="backColor" data-value="#F7C6CE" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#F7C6CE"></button><button type="button" class="note-color-btn" style="background-color:#FFE7CE"
                                                                                                data-event="backColor" data-value="#FFE7CE" title="" data-toggle="button" tabindex="-1" data-original-title="#FFE7CE"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#FFEFC6" data-event="backColor" data-value="#FFEFC6" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#FFEFC6"></button><button type="button" class="note-color-btn" style="background-color:#D6EFD6" data-event="backColor"
                                                                                                data-value="#D6EFD6" title="" data-toggle="button" tabindex="-1" data-original-title="#D6EFD6"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#CEDEE7" data-event="backColor" data-value="#CEDEE7" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#CEDEE7"></button><button type="button" class="note-color-btn" style="background-color:#CEE7F7" data-event="backColor"
                                                                                                data-value="#CEE7F7" title="" data-toggle="button" tabindex="-1" data-original-title="#CEE7F7"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#D6D6E7" data-event="backColor" data-value="#D6D6E7" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#D6D6E7"></button><button type="button" class="note-color-btn" style="background-color:#E7D6DE" data-event="backColor"
                                                                                                data-value="#E7D6DE" title="" data-toggle="button" tabindex="-1" data-original-title="#E7D6DE"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#E79C9C" data-event="backColor" data-value="#E79C9C" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#E79C9C"></button><button type="button" class="note-color-btn" style="background-color:#FFC69C"
                                                                                                data-event="backColor" data-value="#FFC69C" title="" data-toggle="button" tabindex="-1" data-original-title="#FFC69C"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#FFE79C" data-event="backColor" data-value="#FFE79C" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#FFE79C"></button><button type="button" class="note-color-btn" style="background-color:#B5D6A5" data-event="backColor"
                                                                                                data-value="#B5D6A5" title="" data-toggle="button" tabindex="-1" data-original-title="#B5D6A5"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#A5C6CE" data-event="backColor" data-value="#A5C6CE" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#A5C6CE"></button><button type="button" class="note-color-btn" style="background-color:#9CC6EF" data-event="backColor"
                                                                                                data-value="#9CC6EF" title="" data-toggle="button" tabindex="-1" data-original-title="#9CC6EF"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#B5A5D6" data-event="backColor" data-value="#B5A5D6" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#B5A5D6"></button><button type="button" class="note-color-btn" style="background-color:#D6A5BD" data-event="backColor"
                                                                                                data-value="#D6A5BD" title="" data-toggle="button" tabindex="-1" data-original-title="#D6A5BD"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#E76363" data-event="backColor" data-value="#E76363" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#E76363"></button><button type="button" class="note-color-btn" style="background-color:#F7AD6B"
                                                                                                data-event="backColor" data-value="#F7AD6B" title="" data-toggle="button" tabindex="-1" data-original-title="#F7AD6B"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#FFD663" data-event="backColor" data-value="#FFD663" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#FFD663"></button><button type="button" class="note-color-btn" style="background-color:#94BD7B" data-event="backColor"
                                                                                                data-value="#94BD7B" title="" data-toggle="button" tabindex="-1" data-original-title="#94BD7B"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#73A5AD" data-event="backColor" data-value="#73A5AD" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#73A5AD"></button><button type="button" class="note-color-btn" style="background-color:#6BADDE" data-event="backColor"
                                                                                                data-value="#6BADDE" title="" data-toggle="button" tabindex="-1" data-original-title="#6BADDE"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#8C7BC6" data-event="backColor" data-value="#8C7BC6" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#8C7BC6"></button><button type="button" class="note-color-btn" style="background-color:#C67BA5" data-event="backColor"
                                                                                                data-value="#C67BA5" title="" data-toggle="button" tabindex="-1" data-original-title="#C67BA5"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#CE0000" data-event="backColor" data-value="#CE0000" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#CE0000"></button><button type="button" class="note-color-btn" style="background-color:#E79439"
                                                                                                data-event="backColor" data-value="#E79439" title="" data-toggle="button" tabindex="-1" data-original-title="#E79439"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#EFC631" data-event="backColor" data-value="#EFC631" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#EFC631"></button><button type="button" class="note-color-btn" style="background-color:#6BA54A" data-event="backColor"
                                                                                                data-value="#6BA54A" title="" data-toggle="button" tabindex="-1" data-original-title="#6BA54A"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#4A7B8C" data-event="backColor" data-value="#4A7B8C" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#4A7B8C"></button><button type="button" class="note-color-btn" style="background-color:#3984C6" data-event="backColor"
                                                                                                data-value="#3984C6" title="" data-toggle="button" tabindex="-1" data-original-title="#3984C6"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#634AA5" data-event="backColor" data-value="#634AA5" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#634AA5"></button><button type="button" class="note-color-btn" style="background-color:#A54A7B" data-event="backColor"
                                                                                                data-value="#A54A7B" title="" data-toggle="button" tabindex="-1" data-original-title="#A54A7B"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#9C0000" data-event="backColor" data-value="#9C0000" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#9C0000"></button><button type="button" class="note-color-btn" style="background-color:#B56308"
                                                                                                data-event="backColor" data-value="#B56308" title="" data-toggle="button" tabindex="-1" data-original-title="#B56308"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#BD9400" data-event="backColor" data-value="#BD9400" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#BD9400"></button><button type="button" class="note-color-btn" style="background-color:#397B21" data-event="backColor"
                                                                                                data-value="#397B21" title="" data-toggle="button" tabindex="-1" data-original-title="#397B21"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#104A5A" data-event="backColor" data-value="#104A5A" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#104A5A"></button><button type="button" class="note-color-btn" style="background-color:#085294" data-event="backColor"
                                                                                                data-value="#085294" title="" data-toggle="button" tabindex="-1" data-original-title="#085294"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#311873" data-event="backColor" data-value="#311873" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#311873"></button><button type="button" class="note-color-btn" style="background-color:#731842" data-event="backColor"
                                                                                                data-value="#731842" title="" data-toggle="button" tabindex="-1" data-original-title="#731842"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#630000" data-event="backColor" data-value="#630000" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#630000"></button><button type="button" class="note-color-btn" style="background-color:#7B3900"
                                                                                                data-event="backColor" data-value="#7B3900" title="" data-toggle="button" tabindex="-1" data-original-title="#7B3900"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#846300" data-event="backColor" data-value="#846300" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#846300"></button><button type="button" class="note-color-btn" style="background-color:#295218" data-event="backColor"
                                                                                                data-value="#295218" title="" data-toggle="button" tabindex="-1" data-original-title="#295218"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#083139" data-event="backColor" data-value="#083139" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#083139"></button><button type="button" class="note-color-btn" style="background-color:#003163" data-event="backColor"
                                                                                                data-value="#003163" title="" data-toggle="button" tabindex="-1" data-original-title="#003163"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#21104A" data-event="backColor" data-value="#21104A" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#21104A"></button><button type="button" class="note-color-btn" style="background-color:#4A1031" data-event="backColor"
                                                                                                data-value="#4A1031" title="" data-toggle="button" tabindex="-1" data-original-title="#4A1031"></button></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <div class="note-palette-title">Foreground Color</div>
                                                                            <div> <button type="button" class="note-color-reset btn btn-default" data-event="removeFormat" data-value="foreColor">Reset to default </button> </div>
                                                                            <div class="note-holder" data-event="foreColor">
                                                                                <div class="note-color-palette">
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#000000" data-event="foreColor" data-value="#000000" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#000000"></button><button type="button" class="note-color-btn" style="background-color:#424242"
                                                                                                data-event="foreColor" data-value="#424242" title="" data-toggle="button" tabindex="-1" data-original-title="#424242"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#636363" data-event="foreColor" data-value="#636363" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#636363"></button><button type="button" class="note-color-btn" style="background-color:#9C9C94" data-event="foreColor"
                                                                                                data-value="#9C9C94" title="" data-toggle="button" tabindex="-1" data-original-title="#9C9C94"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#CEC6CE" data-event="foreColor" data-value="#CEC6CE" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#CEC6CE"></button><button type="button" class="note-color-btn" style="background-color:#EFEFEF" data-event="foreColor"
                                                                                                data-value="#EFEFEF" title="" data-toggle="button" tabindex="-1" data-original-title="#EFEFEF"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#F7F7F7" data-event="foreColor" data-value="#F7F7F7" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#F7F7F7"></button><button type="button" class="note-color-btn" style="background-color:#FFFFFF" data-event="foreColor"
                                                                                                data-value="#FFFFFF" title="" data-toggle="button" tabindex="-1" data-original-title="#FFFFFF"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#FF0000" data-event="foreColor" data-value="#FF0000" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#FF0000"></button><button type="button" class="note-color-btn" style="background-color:#FF9C00"
                                                                                                data-event="foreColor" data-value="#FF9C00" title="" data-toggle="button" tabindex="-1" data-original-title="#FF9C00"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#FFFF00" data-event="foreColor" data-value="#FFFF00" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#FFFF00"></button><button type="button" class="note-color-btn" style="background-color:#00FF00" data-event="foreColor"
                                                                                                data-value="#00FF00" title="" data-toggle="button" tabindex="-1" data-original-title="#00FF00"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#00FFFF" data-event="foreColor" data-value="#00FFFF" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#00FFFF"></button><button type="button" class="note-color-btn" style="background-color:#0000FF" data-event="foreColor"
                                                                                                data-value="#0000FF" title="" data-toggle="button" tabindex="-1" data-original-title="#0000FF"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#9C00FF" data-event="foreColor" data-value="#9C00FF" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#9C00FF"></button><button type="button" class="note-color-btn" style="background-color:#FF00FF" data-event="foreColor"
                                                                                                data-value="#FF00FF" title="" data-toggle="button" tabindex="-1" data-original-title="#FF00FF"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#F7C6CE" data-event="foreColor" data-value="#F7C6CE" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#F7C6CE"></button><button type="button" class="note-color-btn" style="background-color:#FFE7CE"
                                                                                                data-event="foreColor" data-value="#FFE7CE" title="" data-toggle="button" tabindex="-1" data-original-title="#FFE7CE"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#FFEFC6" data-event="foreColor" data-value="#FFEFC6" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#FFEFC6"></button><button type="button" class="note-color-btn" style="background-color:#D6EFD6" data-event="foreColor"
                                                                                                data-value="#D6EFD6" title="" data-toggle="button" tabindex="-1" data-original-title="#D6EFD6"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#CEDEE7" data-event="foreColor" data-value="#CEDEE7" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#CEDEE7"></button><button type="button" class="note-color-btn" style="background-color:#CEE7F7" data-event="foreColor"
                                                                                                data-value="#CEE7F7" title="" data-toggle="button" tabindex="-1" data-original-title="#CEE7F7"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#D6D6E7" data-event="foreColor" data-value="#D6D6E7" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#D6D6E7"></button><button type="button" class="note-color-btn" style="background-color:#E7D6DE" data-event="foreColor"
                                                                                                data-value="#E7D6DE" title="" data-toggle="button" tabindex="-1" data-original-title="#E7D6DE"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#E79C9C" data-event="foreColor" data-value="#E79C9C" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#E79C9C"></button><button type="button" class="note-color-btn" style="background-color:#FFC69C"
                                                                                                data-event="foreColor" data-value="#FFC69C" title="" data-toggle="button" tabindex="-1" data-original-title="#FFC69C"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#FFE79C" data-event="foreColor" data-value="#FFE79C" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#FFE79C"></button><button type="button" class="note-color-btn" style="background-color:#B5D6A5" data-event="foreColor"
                                                                                                data-value="#B5D6A5" title="" data-toggle="button" tabindex="-1" data-original-title="#B5D6A5"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#A5C6CE" data-event="foreColor" data-value="#A5C6CE" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#A5C6CE"></button><button type="button" class="note-color-btn" style="background-color:#9CC6EF" data-event="foreColor"
                                                                                                data-value="#9CC6EF" title="" data-toggle="button" tabindex="-1" data-original-title="#9CC6EF"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#B5A5D6" data-event="foreColor" data-value="#B5A5D6" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#B5A5D6"></button><button type="button" class="note-color-btn" style="background-color:#D6A5BD" data-event="foreColor"
                                                                                                data-value="#D6A5BD" title="" data-toggle="button" tabindex="-1" data-original-title="#D6A5BD"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#E76363" data-event="foreColor" data-value="#E76363" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#E76363"></button><button type="button" class="note-color-btn" style="background-color:#F7AD6B"
                                                                                                data-event="foreColor" data-value="#F7AD6B" title="" data-toggle="button" tabindex="-1" data-original-title="#F7AD6B"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#FFD663" data-event="foreColor" data-value="#FFD663" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#FFD663"></button><button type="button" class="note-color-btn" style="background-color:#94BD7B" data-event="foreColor"
                                                                                                data-value="#94BD7B" title="" data-toggle="button" tabindex="-1" data-original-title="#94BD7B"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#73A5AD" data-event="foreColor" data-value="#73A5AD" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#73A5AD"></button><button type="button" class="note-color-btn" style="background-color:#6BADDE" data-event="foreColor"
                                                                                                data-value="#6BADDE" title="" data-toggle="button" tabindex="-1" data-original-title="#6BADDE"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#8C7BC6" data-event="foreColor" data-value="#8C7BC6" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#8C7BC6"></button><button type="button" class="note-color-btn" style="background-color:#C67BA5" data-event="foreColor"
                                                                                                data-value="#C67BA5" title="" data-toggle="button" tabindex="-1" data-original-title="#C67BA5"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#CE0000" data-event="foreColor" data-value="#CE0000" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#CE0000"></button><button type="button" class="note-color-btn" style="background-color:#E79439"
                                                                                                data-event="foreColor" data-value="#E79439" title="" data-toggle="button" tabindex="-1" data-original-title="#E79439"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#EFC631" data-event="foreColor" data-value="#EFC631" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#EFC631"></button><button type="button" class="note-color-btn" style="background-color:#6BA54A" data-event="foreColor"
                                                                                                data-value="#6BA54A" title="" data-toggle="button" tabindex="-1" data-original-title="#6BA54A"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#4A7B8C" data-event="foreColor" data-value="#4A7B8C" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#4A7B8C"></button><button type="button" class="note-color-btn" style="background-color:#3984C6" data-event="foreColor"
                                                                                                data-value="#3984C6" title="" data-toggle="button" tabindex="-1" data-original-title="#3984C6"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#634AA5" data-event="foreColor" data-value="#634AA5" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#634AA5"></button><button type="button" class="note-color-btn" style="background-color:#A54A7B" data-event="foreColor"
                                                                                                data-value="#A54A7B" title="" data-toggle="button" tabindex="-1" data-original-title="#A54A7B"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#9C0000" data-event="foreColor" data-value="#9C0000" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#9C0000"></button><button type="button" class="note-color-btn" style="background-color:#B56308"
                                                                                                data-event="foreColor" data-value="#B56308" title="" data-toggle="button" tabindex="-1" data-original-title="#B56308"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#BD9400" data-event="foreColor" data-value="#BD9400" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#BD9400"></button><button type="button" class="note-color-btn" style="background-color:#397B21" data-event="foreColor"
                                                                                                data-value="#397B21" title="" data-toggle="button" tabindex="-1" data-original-title="#397B21"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#104A5A" data-event="foreColor" data-value="#104A5A" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#104A5A"></button><button type="button" class="note-color-btn" style="background-color:#085294" data-event="foreColor"
                                                                                                data-value="#085294" title="" data-toggle="button" tabindex="-1" data-original-title="#085294"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#311873" data-event="foreColor" data-value="#311873" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#311873"></button><button type="button" class="note-color-btn" style="background-color:#731842" data-event="foreColor"
                                                                                                data-value="#731842" title="" data-toggle="button" tabindex="-1" data-original-title="#731842"></button></div>
                                                                                    <div class="note-color-row"><button type="button" class="note-color-btn" style="background-color:#630000" data-event="foreColor" data-value="#630000" title=""
                                                                                                data-toggle="button" tabindex="-1" data-original-title="#630000"></button><button type="button" class="note-color-btn" style="background-color:#7B3900"
                                                                                                data-event="foreColor" data-value="#7B3900" title="" data-toggle="button" tabindex="-1" data-original-title="#7B3900"></button><button
                                                                                                type="button" class="note-color-btn" style="background-color:#846300" data-event="foreColor" data-value="#846300" title="" data-toggle="button"
                                                                                                tabindex="-1" data-original-title="#846300"></button><button type="button" class="note-color-btn" style="background-color:#295218" data-event="foreColor"
                                                                                                data-value="#295218" title="" data-toggle="button" tabindex="-1" data-original-title="#295218"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#083139" data-event="foreColor" data-value="#083139" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#083139"></button><button type="button" class="note-color-btn" style="background-color:#003163" data-event="foreColor"
                                                                                                data-value="#003163" title="" data-toggle="button" tabindex="-1" data-original-title="#003163"></button><button type="button"
                                                                                                class="note-color-btn" style="background-color:#21104A" data-event="foreColor" data-value="#21104A" title="" data-toggle="button" tabindex="-1"
                                                                                                data-original-title="#21104A"></button><button type="button" class="note-color-btn" style="background-color:#4A1031" data-event="foreColor"
                                                                                                data-value="#4A1031" title="" data-toggle="button" tabindex="-1" data-original-title="#4A1031"></button></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="note-btn-group btn-group note-para"><button type="button" class="note-btn btn btn-default btn-sm" tabindex="-1" title=""
                                                                    data-original-title="Unordered list (CTRL+SHIFT+NUM7)"><i class="note-icon-unorderedlist"></i></button><button type="button" class="note-btn btn btn-default btn-sm" tabindex="-1"
                                                                    title="" data-original-title="Ordered list (CTRL+SHIFT+NUM8)"><i class="note-icon-orderedlist"></i></button>
                                                            <div class="note-btn-group btn-group"><button type="button" class="note-btn btn btn-default btn-sm dropdown-toggle" tabindex="-1" data-toggle="dropdown" title=""
                                                                        data-original-title="Paragraph"><i class="note-icon-align-left"></i> <span class="note-icon-caret"></span></button>
                                                                <div class="dropdown-menu">
                                                                    <div class="note-btn-group btn-group note-align"><button type="button" class="note-btn btn btn-default btn-sm" tabindex="-1" title=""
                                                                                data-original-title="Align left (CTRL+SHIFT+L)"><i class="note-icon-align-left"></i></button><button type="button" class="note-btn btn btn-default btn-sm" tabindex="-1"
                                                                                title="" data-original-title="Align center (CTRL+SHIFT+E)"><i class="note-icon-align-center"></i></button><button type="button" class="note-btn btn btn-default btn-sm"
                                                                                tabindex="-1" title="" data-original-title="Align right (CTRL+SHIFT+R)"><i class="note-icon-align-right"></i></button><button type="button"
                                                                                class="note-btn btn btn-default btn-sm" tabindex="-1" title="" data-original-title="Justify full (CTRL+SHIFT+J)"><i class="note-icon-align-justify"></i></button></div>
                                                                    <div class="note-btn-group btn-group note-list"><button type="button" class="note-btn btn btn-default btn-sm" tabindex="-1" title="" data-original-title="Outdent (CTRL+[)"><i
                                                                               class="note-icon-align-outdent"></i></button><button type="button" class="note-btn btn btn-default btn-sm" tabindex="-1" title=""
                                                                                data-original-title="Indent (CTRL+])"><i class="note-icon-align-indent"></i></button></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="note-btn-group btn-group note-table">
                                                            <div class="note-btn-group btn-group"><button type="button" class="note-btn btn btn-default btn-sm dropdown-toggle" tabindex="-1" data-toggle="dropdown" title=""
                                                                        data-original-title="Table"><i class="note-icon-table"></i> <span class="note-icon-caret"></span></button>
                                                                <div class="dropdown-menu note-table">
                                                                    <div class="note-dimension-picker">
                                                                        <div class="note-dimension-picker-mousecatcher" data-event="insertTable" data-value="1x1" style="width: 10em; height: 10em;"></div>
                                                                        <div class="note-dimension-picker-highlighted"></div>
                                                                        <div class="note-dimension-picker-unhighlighted"></div>
                                                                    </div>
                                                                    <div class="note-dimension-display">1 x 1</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="note-btn-group btn-group note-insert"><button type="button" class="note-btn btn btn-default btn-sm" tabindex="-1" title="" data-original-title="Link (CTRL+K)"><i
                                                                   class="note-icon-link"></i></button><button type="button" class="note-btn btn btn-default btn-sm" tabindex="-1" title="" data-original-title="Picture"><i
                                                                   class="note-icon-picture"></i></button><button type="button" class="note-btn btn btn-default btn-sm" tabindex="-1" title="" data-original-title="Video"><i
                                                                   class="note-icon-video"></i></button></div>
                                                        <div class="note-btn-group btn-group note-view"><button type="button" class="note-btn btn btn-default btn-sm btn-fullscreen" tabindex="-1" title="" data-original-title="Full Screen"><i
                                                                   class="note-icon-arrows-alt"></i></button><button type="button" class="note-btn btn btn-default btn-sm btn-codeview" tabindex="-1" title="" data-original-title="Code View"><i
                                                                   class="note-icon-code"></i></button><button type="button" class="note-btn btn btn-default btn-sm" tabindex="-1" title="" data-original-title="Help"><i
                                                                   class="note-icon-question"></i></button></div>
                                                    </div>
                                                    <div class="note-editing-area">
                                                        <div class="note-handle">
                                                            <div class="note-control-selection">
                                                                <div class="note-control-selection-bg"></div>
                                                                <div class="note-control-holder note-control-nw"></div>
                                                                <div class="note-control-holder note-control-ne"></div>
                                                                <div class="note-control-holder note-control-sw"></div>
                                                                <div class="note-control-sizing note-control-se"></div>
                                                                <div class="note-control-selection-info"></div>
                                                            </div>
                                                        </div>
                                                        <textarea class="note-codable"></textarea>
                                                        <div class="note-editable panel-body" contenteditable="true" style="height: 400px;">
                                                            <p><br></p>
                                                        </div>
                                                    </div>
                                                    <div class="note-statusbar">
                                                        <div class="note-resizebar">
                                                            <div class="note-icon-bar"></div>
                                                            <div class="note-icon-bar"></div>
                                                            <div class="note-icon-bar"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 text-right">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success"><i class="fa fa-save fa-fw"></i> Save Changes</button>
                                            </div>
                                        </div>

                                        <input type="hidden" name="route" value="inventory/assets/manage">
                                        <input type="hidden" name="routeid" value="1">
                                        <input type="hidden" name="section" value="edit">

                                        <input type="hidden" name="action" value="editAsset">
                                        <input type="hidden" name="id" value="1">


                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->

                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection

@section('script-foot')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- script tambahan -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
