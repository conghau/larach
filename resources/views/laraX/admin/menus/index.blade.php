@extends('admin.master')

@section('page-toolbar')

@endsection

@section('css')

@endsection
@section('js')
    {!! Theme::js('admin/theme/assets/global/scripts/datatable.js') !!}
    {!! Theme::js('admin/theme/assets/global/plugins/datatables/datatables.min.js') !!}
    {!! Theme::js('admin/theme/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') !!}
@endsection

@section('js-init')
    {!! Theme::js('admin/dist/pages/table-datatables-ajax.js') !!}
    <script>
        $(document).ready(function(){
            TableDatatablesAjax.init({
                ajaxGet: '{{ asset($adminPath.'/menus') }}',
                src: $('#datatable_ajax'),
                onSuccess: function(grid, response){

                },
                onError: function(grid){

                },
                onDataLoad: function(grid){

                },
                editableFields: [2, 3],
                actionPosition: 5,
                ajaxUrlSaveRow: '{{ asset($adminPath.'/menus/fast-edit') }}'
            });
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="note note-danger">
                <p>NOTE: You need to enable javascript.</p>
            </div>

            <!-- Begin: life time stats -->
            <div class="portlet light portlet-fit portlet-datatable bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-layers font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase">{{ $pageTitle or 'Menu Management' }}</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            <a class="btn btn-transparent btn-success btn-circle btn-sm" href="{{ asset($adminPath.'/menus/edit/0') }}"><i class="fa fa-plus"></i> Create</a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <!--div class="table-actions-wrapper">
                            <span></span>
                            <select class="table-group-action-input form-control input-inline input-small input-sm">
                                <option value="">Select...</option>
                                <option value="1">Activated</option>
                                <option value="0">Disabled</option>
                            </select>
                            <button class="btn btn-sm green table-group-action-submit" data-toggle="confirmation" title="">
                                <i class="fa fa-check"></i> Submit
                            </button>
                        </div-->
                        <table class="table table-striped table-bordered table-hover table-checkable vertical-middle" id="datatable_ajax">
                            <thead>
                            <tr role="row" class="heading">
                                <th width="1%">
                                    <input type="checkbox" class="group-checkable">
                                </th>
                                <th width="5%">
                                    #
                                </th>
                                <th width="40%">Name</th>
                                <th width="20%">Slug</th>
                                <th width="10%">Created at</th>
                                <th width="10%">Fast edit</th>
                                <th width="10%">Actions</th>
                            </tr>
                            <tr role="row" class="filter">
                                <td></td>
                                <td></td>
                                <td>
                                    <input placeholder="Search..." type="text" class="form-control form-filter input-sm" name="name">
                                </td>
                                <td>
                                    <input placeholder="Search..." type="text" class="form-control form-filter input-sm" name="slug">
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button class="btn btn-sm btn-success filter-submit margin-bottom">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning filter-cancel">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End: life time stats -->
        </div>
    </div>
@endsection
