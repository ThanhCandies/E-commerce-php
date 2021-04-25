@extends('layouts.dashboard')
@section('header')
    <title>Categories List</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/file-uploaders/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/css/form-validation.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/semi-dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/js/vendors/toastr/toastr.min.css">
    <!-- END: Theme CSS -->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/file-uploaders/dropzone.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/data-list-view.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!-- END: Custom CSS-->
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Category</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/admin">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Category
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrum-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                        class="feather icon-settings"></i></button>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Chat</a><a
                                        class="dropdown-item" href="#">Email</a><a class="dropdown-item" href="#">Calendar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Data list view starts -->
                <section id="data-list-view" class="data-list-view-header">
                    <div class="action-btns d-none">
                        <div class="btn-dropdown mr-1 mb-1">
                            <div class="btn-group dropdown actions-dropodown">
                                <button type="button"
                                        class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" data-role="delete-list" href="#"><i class="feather icon-trash"></i>Delete</a>
                                    <a class="dropdown-item" href="#"><i class="feather icon-archive"></i>Archive</a>
                                    <a class="dropdown-item" href="#"><i class="feather icon-file"></i>Print</a>
                                    <a class="dropdown-item" href="#"><i class="feather icon-save"></i>Another
                                        Action</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTable starts -->
                    <div class="table-responsive">
                        <table class="table data-list-view">
                            <thead>
                            <tr>
                                <th></th>
                                <th>IMAGE</th>
                                <th>NAME</th>
                                <th>POPULARITY</th>
                                <th>STATUS</th>
                                <th>PRODUCTS</th>
                                <th>CREATE</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            <tr>--}}
{{--                                <td></td>--}}
{{--                                <td class="product-name">Computers</td>--}}
{{--                                <td>--}}
{{--                                    <div class="progress progress-bar-success">--}}
{{--                                        <div class="progress-bar" role="progressbar" aria-valuenow="40"--}}
{{--                                             aria-valuemin="40" aria-valuemax="100" style="width:97%"></div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <div class="chip chip-warning">--}}
{{--                                        <div class="chip-body">--}}
{{--                                            <div class="chip-text">on hold</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td class="product-name">Computers</td>--}}

{{--                                <td class="product-action">--}}
{{--                                    <span class="action-edit"><i class="feather icon-edit"></i></span>--}}
{{--                                    <span class="action-delete"><i class="feather icon-trash"></i></span>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
                            </tbody>
                        </table>
                    </div>
                    <!-- DataTable ends -->

                    <!-- add new sidebar starts -->
                    <div class="add-new-data-sidebar">
                        <div class="overlay-bg"></div>

                        <form class="add-new-data" method="POST" action="{{route('category.create')}}" id="create_form" novalidate>
                            <div class="div mt-2 px-2 d-flex new-data-title justify-content-between">
                                <div>
                                    <h4 class="text-uppercase"  id="header_table">ADD NEW CATEGORY</h4>
                                </div>
                                <div class="hide-data-sidebar">
                                    <i class="feather icon-x"></i>
                                </div>
                            </div>
                            <div class="data-items pb-3">
                                <div class="data-fields px-2 mt-3">
                                    <div class="row">
                                        <div class="col-sm-12 data-field-col form-group mb-0">
                                            <label for="data-name">Name</label>
                                            <input type="text" class="form-control" id="data-name" name="name" required="" autocomplete="off">
                                            <div class="help-block"  style="right: inherit"></div>
                                        </div>
                                        <div class="col-sm-12 data-field-col form-group mb-0">
                                            <label for="data-description">Descriptions</label>
                                            <textarea type="text" class="form-control" id="data-description" name="description" required=""
                                            rows="4" style="resize: none;width: 100%" autocomplete="off"
                                            ></textarea>
                                            <div class="help-block"  style="right: inherit"></div>
                                        </div>
                                        <div class="col-sm-12 data-field-col">
                                            <label for="data-status">Published</label>
                                            <select class="form-control" id="data-status" name="published">
                                                <option value="0">UnPublished</option>
                                                <option value="1">Published</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12 data-field-col data-list-upload">
                                            <div class="dropzone dropzone-area" id="dataListUpload">
                                                <div class="dz-message">Upload Image</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add-data-footer d-flex justify-content-around px-3 mt-2">
                                <div class="add-data-btn">
                                    <button type="submit" class="btn btn-primary">Add Data</button>
                                </div>
                                <div class="cancel-data-btn">
                                    <button type="reset" class="btn btn-outline-danger">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- add new sidebar ends -->
                </section>
                <!-- Data list view end -->

            </div>
        </div>
    </div>
@endsection

@section('footer')

    <!-- BEGIN: Vendor JS-->
    <script src="/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="/app-assets/vendors/js/extensions/dropzone.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/dataTables.select.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>

    <script src="/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="/app-assets/js/core/app-menu.js"></script>
    <script src="/app-assets/js/core/app.js"></script>
    <script src="/app-assets/js/scripts/components.js"></script>
    <script src="/js/vendors/validation/jqBootstrapValidation.js"></script>

    <script src="/js/vendors/serializeObject/jquery.serialize-object.min.js"></script>

    <script src="/js/vendors/toastr/toastr.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    {{--    <script src="/app-assets/js/scripts/ui/data-list-view.js"></script>--}}
    <script src="/assets/js/products.js"></script>
    <!-- END: Page JS-->
@endsection