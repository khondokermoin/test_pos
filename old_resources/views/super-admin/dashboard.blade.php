@extends('layouts.admin_master')

@section('content')
    <div class="page-container">


        <div class="page-title-head d-flex align-items-center gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-17 mb-0">Dashboard</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0 fs-13">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Zircos</a></li>

                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>




        <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1">

            <!-- Total Visitors -->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted fs-13 text-uppercase" title="Total Visitors">Total Visitors</h5>
                        <div class="d-flex align-items-center gap-2 my-3">
                            <h3 class="mb-0"><span data-counter data-target="701.8">0</span>k</h3>
                            <i data-lucide="globe"
                                class="ms-auto display-2 position-absolute opacity-25 text-muted widget-icon"></i>
                        </div>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-2"><i class="ti ti-caret-up-filled"></i> 14.2%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Unique Visitors -->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted fs-13 text-uppercase" title="Unique Visitors">Unique Visitors</h5>
                        <div class="d-flex align-items-center gap-2 my-3">
                            <h3 class="mb-0"><span data-counter data-target="467.25">0</span>k</h3>
                            <i class="ti ti-eye ms-auto display-1 position-absolute opacity-25 text-muted widget-icon"></i>
                        </div>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-2"><i class="ti ti-caret-up-filled"></i> 7.8%</span>
                            <span class="text-nowrap">Compared to last week</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Page Views -->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted fs-13 text-uppercase" title="Page Views">Page Views</h5>
                        <div class="d-flex align-items-center gap-2 my-3">
                            <h3 class="mb-0"><span data-counter data-target="2.5">0</span>M</h3>
                            <i
                                class="ti ti-chart-bar ms-auto display-1 position-absolute opacity-25 text-muted widget-icon"></i>
                        </div>
                        <p class="mb-0 text-muted">
                            <span class="text-danger me-2"><i class="ti ti-caret-down-filled"></i> 3.1%</span>
                            <span class="text-nowrap">Drop from last month</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bounce Rate -->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted fs-13 text-uppercase" title="Bounce Rate">Bounce Rate</h5>
                        <div class="d-flex align-items-center gap-2 my-3">
                            <h3 class="mb-0"><span data-counter data-target="42.7">0</span>%</h3>
                            <i
                                class="ti ti-arrow-back ms-auto display-1 position-absolute opacity-25 text-muted widget-icon"></i>
                        </div>
                        <p class="mb-0 text-muted">
                            <span class="text-danger me-2"><i class="ti ti-caret-down-filled"></i> 1.5%</span>
                            <span class="text-nowrap">Compared to last month</span>
                        </p>
                    </div>
                </div>
            </div>

        </div><!-- end row -->


        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body pb-2">
                        <div class="d-flex mb-3 justify-content-between">
                            <div>
                                <h4 class="card-title mb-1">Daily Sales</h4>
                                <p class="text-muted fs-12">March 26 2025 - April 01 2026</p>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle drop-arrow-none card-drop"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                </div>
                            </div>
                        </div>

                        <div dir="ltr">
                            <div id="data-visits-chart" class="apex-charts" data-colors="#f5707a,#3ac9d6,#4bd396"></div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body pb-2">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title mb-1">Statistics</h4>
                                <p class="text-muted">March 26 2025 - April 01 2026</p>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle drop-arrow-none card-drop"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                </div>
                            </div>
                        </div>

                        <div dir="ltr">
                            <div id="statistics-chart" class="apex-charts" data-colors="#3bafda,#f9c851"></div>
                        </div>

                    </div>
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body pb-2">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title mb-1">Total Revenue</h4>
                                <p class="text-muted">March 26 2025 - April 01 2026</p>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle drop-arrow-none card-drop"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                </div>
                            </div>
                        </div>

                        <div dir="ltr">
                            <div id="daily-sales" class="apex-charts" data-colors="#188ae2,#10c469"></div>
                        </div>

                    </div>
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row-->


        <div class="row">
            <div class="col-xxl-6">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="card-title">Brands Listing</h4>
                        <a href="javascript:void(0);" class="btn btn-sm btn-light">Add Brand <i
                                class="ti ti-plus ms-1"></i></a>
                    </div>
                    <div class="card-body p-0">
                        <div class="bg-light bg-opacity-50 py-1 text-center">
                            <p class="m-0"><b>69</b> Active brands out of <span class="fw-medium">102</span></p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-sm table-nowrap table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-md flex-shrink-0 me-2">
                                                    <span class="avatar-title text-bg-primary rounded-circle fw-semibold">
                                                        EM
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12">Electronics</span> <br />
                                                    <h5 class="fs-14 mt-1">ElectroMart - USA</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Established</span>
                                            <h5 class="fs-14 mt-1 fw-normal">Since 2015</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Stores</span> <br />
                                            <h5 class="fs-14 mt-1 fw-normal">300</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Products</span>
                                            <h5 class="fs-14 mt-1 fw-normal">5,200</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Status</span>
                                            <h5 class="fs-14 mt-1 fw-normal"><i
                                                    class="ti ti-circle-filled fs-12 text-success"></i> Active
                                            </h5>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-md flex-shrink-0 me-2">
                                                    <span class="avatar-title text-bg-success rounded-circle fw-semibold">
                                                        FS
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12">Furniture</span> <br />
                                                    <h5 class="fs-14 mt-1">FurniStyle - UK</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Established</span>
                                            <h5 class="fs-14 mt-1 fw-normal">Since 2010</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Stores</span> <br />
                                            <h5 class="fs-14 mt-1 fw-normal">120</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Products</span>
                                            <h5 class="fs-14 mt-1 fw-normal">1,100</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Status</span>
                                            <h5 class="fs-14 mt-1 fw-normal"><i
                                                    class="ti ti-circle-filled fs-12 text-success"></i> Active
                                            </h5>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-md flex-shrink-0 me-2">
                                                    <span class="avatar-title text-bg-info rounded-circle fw-semibold">
                                                        AG
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12">Automotive</span> <br />
                                                    <h5 class="fs-14 mt-1">AutoGear - Germany</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Established</span>
                                            <h5 class="fs-14 mt-1 fw-normal">Since 2005</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Stores</span> <br />
                                            <h5 class="fs-14 mt-1 fw-normal">50</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Products</span>
                                            <h5 class="fs-14 mt-1 fw-normal">850</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Status</span>
                                            <h5 class="fs-14 mt-1 fw-normal"><i
                                                    class="ti ti-circle-filled fs-12 text-warning"></i> Pending
                                            </h5>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-md flex-shrink-0 me-2">
                                                    <span class="avatar-title text-bg-warning rounded-circle fw-semibold">
                                                        SC
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12">Fashion</span> <br />
                                                    <h5 class="fs-14 mt-1">StyleCore - Italy</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Established</span>
                                            <h5 class="fs-14 mt-1 fw-normal">Since 1998</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Stores</span> <br />
                                            <h5 class="fs-14 mt-1 fw-normal">200</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Products</span>
                                            <h5 class="fs-14 mt-1 fw-normal">2,300</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Status</span>
                                            <h5 class="fs-14 mt-1 fw-normal"><i
                                                    class="ti ti-circle-filled fs-12 text-danger"></i> Inactive
                                            </h5>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-md flex-shrink-0 me-2">
                                                    <span class="avatar-title text-bg-danger rounded-circle fw-semibold">
                                                        TV
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12">Tech</span> <br />
                                                    <h5 class="fs-14 mt-1">TechVerse - India</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Established</span>
                                            <h5 class="fs-14 mt-1 fw-normal">Since 2020</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Stores</span> <br />
                                            <h5 class="fs-14 mt-1 fw-normal">400</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Products</span>
                                            <h5 class="fs-14 mt-1 fw-normal">7,500</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Status</span>
                                            <h5 class="fs-14 mt-1 fw-normal"><i
                                                    class="ti ti-circle-filled fs-12 text-success"></i> Active
                                            </h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div> <!-- end table-responsive-->
                    </div> <!-- end card-body-->

                    <div class="card-footer border-0">
                        <div class="align-items-center justify-content-between row text-center text-sm-start">
                            <div class="col-sm">
                                <div class="text-muted">
                                    Showing <span class="fw-semibold">5</span> of <span class="fw-semibold">15</span>
                                    Results
                                </div>
                            </div>
                            <div class="col-sm-auto mt-3 mt-sm-0">
                                <ul class="pagination pagination-boxed pagination-sm mb-0 justify-content-center">
                                    <li class="page-item disabled">
                                        <a href="#" class="page-link"><i class="ti ti-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item active">
                                        <a href="#" class="page-link">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link"><i class="ti ti-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div> <!-- -->
                    </div>

                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-xxl-6">
                <div class="card card-h-100">
                    <div class="card-header d-flex flex-wrap align-items-center gap-2">
                        <h4 class="card-title me-auto">Recent New Signup</h4>

                        <div class="d-flex gap-2 justify-content-end text-end">
                            <a href="javascript:void(0);" class="btn btn-sm btn-light">Import <i
                                    class="ti ti-download ms-1"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary">Export <i
                                    class="ti ti-file-export ms-1"></i></a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="bg-light bg-opacity-50 py-1 text-center">
                            <p class="m-0"><b>895k</b> Active users out of <span class="fw-medium">965k</span>
                            </p>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-sm table-nowrap table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-md flex-shrink-0 me-2">
                                                    <span class="avatar-title bg-primary-subtle rounded-circle">
                                                        <img src="{{ asset('') }}frontend_assets/images/users/avatar-1.jpg"
                                                            alt="" height="30" class="rounded-circle">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12">Name</span> <br />
                                                    <h5 class="fs-14 mt-1">John Doe</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Email</span>
                                            <h5 class="fs-14 mt-1 fw-normal">john.doe@example.com</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Role</span> <br />
                                            <h5 class="fs-14 mt-1 fw-normal">Administrator</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Status</span>
                                            <h5 class="fs-14 mt-1 fw-normal"><i
                                                    class="ti ti-circle-filled fs-12 text-success"></i> Active
                                            </h5>
                                        </td>
                                        <td style="width: 30px;">
                                            <div class="dropdown">
                                                <a href="#"
                                                    class="dropdown-toggle text-muted drop-arrow-none card-drop p-0"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:void(0);" class="dropdown-item">View
                                                        Profile</a>
                                                    <a href="javascript:void(0);" class="dropdown-item">Deactivate</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-md flex-shrink-0 me-2">
                                                    <span class="avatar-title bg-info-subtle rounded-circle">
                                                        <img src="{{ asset('') }}frontend_assets/images/users/avatar-2.jpg"
                                                            alt="" height="30" class="rounded-circle">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12">Name</span> <br />
                                                    <h5 class="fs-14 mt-1">Jane Smith</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Email</span>
                                            <h5 class="fs-14 mt-1 fw-normal">jane.smith@example.com</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Role</span> <br />
                                            <h5 class="fs-14 mt-1 fw-normal">Editor</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Status</span>
                                            <h5 class="fs-14 mt-1 fw-normal"><i
                                                    class="ti ti-circle-filled fs-12 text-warning"></i> Pending
                                            </h5>
                                        </td>
                                        <td style="width: 30px;">
                                            <div class="dropdown">
                                                <a href="#"
                                                    class="dropdown-toggle text-muted drop-arrow-none card-drop p-0"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:void(0);" class="dropdown-item">View
                                                        Profile</a>
                                                    <a href="javascript:void(0);" class="dropdown-item">Activate</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-md flex-shrink-0 me-2">
                                                    <span class="avatar-title bg-secondary-subtle rounded-circle">
                                                        <img src="{{ asset('') }}frontend_assets/images/users/avatar-3.jpg"
                                                            alt="" height="30" class="rounded-circle">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12">Name</span> <br />
                                                    <h5 class="fs-14 mt-1">Michael Brown</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Email</span>
                                            <h5 class="fs-14 mt-1 fw-normal">michael.brown@example.com</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Role</span> <br />
                                            <h5 class="fs-14 mt-1 fw-normal">Viewer</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Status</span>
                                            <h5 class="fs-14 mt-1 fw-normal"><i
                                                    class="ti ti-circle-filled fs-12 text-danger"></i> Inactive
                                            </h5>
                                        </td>
                                        <td style="width: 30px;">
                                            <div class="dropdown">
                                                <a href="#"
                                                    class="dropdown-toggle text-muted drop-arrow-none card-drop p-0"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:void(0);" class="dropdown-item">Activate</a>
                                                    <a href="javascript:void(0);" class="dropdown-item">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-md flex-shrink-0 me-2">
                                                    <span class="avatar-title bg-warning-subtle rounded-circle">
                                                        <img src="{{ asset('') }}frontend_assets/images/users/avatar-4.jpg"
                                                            alt="" height="30" class="rounded-circle">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12">Name</span> <br />
                                                    <h5 class="fs-14 mt-1">Emily Davis</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Email</span>
                                            <h5 class="fs-14 mt-1 fw-normal">emily.davis@example.com</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Role</span> <br />
                                            <h5 class="fs-14 mt-1 fw-normal">Manager</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Status</span>
                                            <h5 class="fs-14 mt-1 fw-normal"><i
                                                    class="ti ti-circle-filled fs-12 text-success"></i> Active
                                            </h5>
                                        </td>
                                        <td style="width: 30px;">
                                            <div class="dropdown">
                                                <a href="#"
                                                    class="dropdown-toggle text-muted drop-arrow-none card-drop p-0"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:void(0);" class="dropdown-item">View
                                                        Profile</a>
                                                    <a href="javascript:void(0);" class="dropdown-item">Deactivate</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-md flex-shrink-0 me-2">
                                                    <span class="avatar-title bg-danger-subtle rounded-circle">
                                                        <img src="{{ asset('') }}frontend_assets/images/users/avatar-5.jpg"
                                                            alt="" height="30" class="rounded-circle">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-muted fs-12">Name</span> <br />
                                                    <h5 class="fs-14 mt-1">Robert Taylor</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Email</span>
                                            <h5 class="fs-14 mt-1 fw-normal">robert.taylor@example.com</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Role</span> <br />
                                            <h5 class="fs-14 mt-1 fw-normal">Support</h5>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-12">Status</span>
                                            <h5 class="fs-14 mt-1 fw-normal"><i
                                                    class="ti ti-circle-filled fs-12 text-warning"></i> Pending
                                            </h5>
                                        </td>
                                        <td style="width: 30px;">
                                            <div class="dropdown">
                                                <a href="#"
                                                    class="dropdown-toggle text-muted drop-arrow-none card-drop p-0"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:void(0);" class="dropdown-item">View
                                                        Profile</a>
                                                    <a href="javascript:void(0);" class="dropdown-item">Activate</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div> <!-- end table-responsive-->
                    </div> <!-- end card-body-->

                    <div class="card-footer border-0">
                        <div class="align-items-center justify-content-between row text-center text-sm-start">
                            <div class="col-sm">
                                <div class="text-muted">
                                    Showing <span class="fw-semibold">5</span> of <span class="fw-semibold">10</span>
                                    Results
                                </div>
                            </div>
                            <div class="col-sm-auto mt-3 mt-sm-0">
                                <ul class="pagination pagination-boxed pagination-sm mb-0 justify-content-center">
                                    <li class="page-item disabled">
                                        <a href="#" class="page-link"><i class="ti ti-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item active">
                                        <a href="#" class="page-link">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link"><i class="ti ti-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div> <!-- -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row-->

    </div>
@endsection()
