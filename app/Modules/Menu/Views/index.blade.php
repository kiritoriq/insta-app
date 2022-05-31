@extends('layout.default')
@section('title', 'Menu')
@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon">
                                <span class="svg-icon svg-icon-primary svg-icon-3x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Text/Menu.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5"/>
                                        <path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg><!--end::Svg Icon--></span>
                            </span>
                            <h3 class="card-label mt-2 display-4">Menu Management
                            <small>Managing Side Menu</small></h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row fv-plugins-icon-container">
                            <div class="col-lg-8">
                                @if(Menu::canAdd(Request::path()))
                                <a href="{{ route('menu.create') }}" class="btn btn-primary btn-sm py-3" title="Create Menu">
                                    <span class="svg-icon svg-icon-white"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-07-07-181510/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                                        </g>
                                    </svg><!--end::Svg Icon--></span> Create
                                </a>
                                @endif
                            </div>
                            <div class="col-lg-4 text-right">
                                <input type="text" id="search-title" name="title" class="form-control" placeholder="Title Search">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover datatable-init" id="table-user">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>Title</th>
                                        <th>Is Parent</th>
                                        <th>Is Section</th>
                                        <th>Page Destination</th>
                                        <th>Active</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{ Request::path() }} --}}
                                    @foreach($menus as $key => $menu)
                                        <tr>
                                            <td>{!! $key++ !!}</td>
                                            <td>{{ $menu->title }}</td>
                                            <td>{{ (($menu->parent_id == 0 && $menu->has_submenu == 1)?'Yes':'No') }}</td>
                                            <td>{{ (($menu->is_section == 1)?'Yes':'No') }}</td>
                                            <td>{{ $menu->page }}</td>
                                            <td>{!! ($menu->is_active == 1)?'<span class="text-success">Active</span>':'<span class="text-danger">Inactive</span>' !!}</td>
                                            <td>
                                                @if(Menu::canEdit(Request::path()))
                                                    <button type="button" class="btn btn-sm btn-clean btn-icon" data-fancybox data-type="ajax" data-src="{{ route('menu.edit', $menu->id) }}" data-toggle="tooltip" data-theme="dark" title="Edit Menu">
                                                        <span class="la la-2x la-edit text-primary"></span>
                                                    </button>
                                                @endif
                                                @if($menu->parent_id != 0 && $menu->has_submenu != 1)
                                                    @if(Menu::canDelete(Request::path()))
                                                    <a href="#" class="btn btn-sm btn-clean btn-icon delete-menu" data-menu="{{ $menu->id }}" data-toggle="tooltip" data-theme="dark" title="Delete Menu">
                                                        <span class="la la-2x la-trash text-danger"></span>
                                                    </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script>
        const KTDatatablesBasicBasic = function () {
            const dataTableInit = function dataTableInit() {
                let table = $('.datatable-init').DataTable({
                    responsive: true,
                    dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    lengthMenu: [5, 10, 25, 50],
                    pageLength: 10,
                    info: false,
                    language: {
                        'lengthMenu': 'Display _MENU_'
                    },
                    columnDefs: []
                });

                table.on('order.dt search.dt', function () {
                    table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();

                $("#search-title").on("keyup", function (e) {
                    if ($(this).val() === "") {
                    table.search($("#search-title").val()).draw();
                    } else {
                    table.columns(1).search($("#search-title").val()).draw();
                    }
                });

            };

    
            return {
                init: function init() {
                dataTableInit();
                }
            };
        }();
        $(document).ready(function() {
            KTDatatablesBasicBasic.init();
        })
    </script>
@endsection
