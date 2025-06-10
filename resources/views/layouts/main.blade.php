<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords"
        content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>New SIPADAN</title>

    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/fonts/meteocons/style.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/chartist.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/chartist-plugin-tooltip.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/timeline.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/dashboard-ecommerce.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->
</head>

<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar" data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav
        class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-lg-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item mr-auto"><a class="navbar-brand" href="index.html"><img class="brand-logo"
                                alt="modern admin logo" src="../../../app-assets/images/logo/logo.png">
                            <h3 class="brand-text"><?= env('APP_TITLE') ?></h3>
                        </a></li>
                    <li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0"
                            data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 white"
                                data-ticon="ft-toggle-right"></i></a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                            data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">

                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label"
                                href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i><span
                                    class="badge badge-pill badge-danger badge-up badge-glow">5</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span>
                                    </h6><span class="notification-tag badge badge-danger float-right m-0">5 New</span>
                                </li>
                                <li class="scrollable-container media-list w-100"><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i
                                                    class="ft-plus-square icon-bg-circle bg-cyan mr-0"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">You have new order!</h6>
                                                <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor
                                                    sit amet, consectetuer elit.</p><small>
                                                    <time class="media-meta text-muted"
                                                        datetime="2015-06-11T18:29:20+08:00">30 minutes
                                                        ago</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i
                                                    class="ft-download-cloud icon-bg-circle bg-red bg-darken-1 mr-0"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading red darken-1">99% Server load</h6>
                                                <p class="notification-text font-small-3 text-muted">Aliquam tincidunt
                                                    mauris eu risus.</p><small>
                                                    <time class="media-meta text-muted"
                                                        datetime="2015-06-11T18:29:20+08:00">Five hour
                                                        ago</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i
                                                    class="ft-alert-triangle icon-bg-circle bg-yellow bg-darken-3 mr-0"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading yellow darken-3">Warning notifixation</h6>
                                                <p class="notification-text font-small-3 text-muted">Vestibulum auctor
                                                    dapibus neque.</p><small>
                                                    <time class="media-meta text-muted"
                                                        datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i
                                                    class="ft-check-circle icon-bg-circle bg-cyan mr-0"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Complete the task</h6><small>
                                                    <time class="media-meta text-muted"
                                                        datetime="2015-06-11T18:29:20+08:00">Last week</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i
                                                    class="ft-file icon-bg-circle bg-teal mr-0"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Generate monthly report</h6><small>
                                                    <time class="media-meta text-muted"
                                                        datetime="2015-06-11T18:29:20+08:00">Last month</time></small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                        href="javascript:void(0)">Read all notifications</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label"
                                href="#" data-toggle="dropdown"><i class="ficon ft-mail"></i></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Messages</span></h6>
                                    <span class="notification-tag badge badge-warning float-right m-0">4 New</span>
                                </li>
                                <li class="scrollable-container media-list w-100"><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span
                                                    class="avatar avatar-sm avatar-online rounded-circle"><img
                                                        src="../../../app-assets/images/portrait/small/avatar-s-19.png"
                                                        alt="avatar"><i></i></span></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Margaret Govan</h6>
                                                <p class="notification-text font-small-3 text-muted">I like your
                                                    portfolio, let's start.</p><small>
                                                    <time class="media-meta text-muted"
                                                        datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span
                                                    class="avatar avatar-sm avatar-busy rounded-circle"><img
                                                        src="../../../app-assets/images/portrait/small/avatar-s-2.png"
                                                        alt="avatar"><i></i></span></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Bret Lezama</h6>
                                                <p class="notification-text font-small-3 text-muted">I have seen your
                                                    work, there is</p><small>
                                                    <time class="media-meta text-muted"
                                                        datetime="2015-06-11T18:29:20+08:00">Tuesday</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span
                                                    class="avatar avatar-sm avatar-online rounded-circle"><img
                                                        src="../../../app-assets/images/portrait/small/avatar-s-3.png"
                                                        alt="avatar"><i></i></span></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Carie Berra</h6>
                                                <p class="notification-text font-small-3 text-muted">Can we have call
                                                    in this week ?</p><small>
                                                    <time class="media-meta text-muted"
                                                        datetime="2015-06-11T18:29:20+08:00">Friday</time></small>
                                            </div>
                                        </div>
                                    </a><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left"><span
                                                    class="avatar avatar-sm avatar-away rounded-circle"><img
                                                        src="../../../app-assets/images/portrait/small/avatar-s-6.png"
                                                        alt="avatar"><i></i></span></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Eric Alsobrook</h6>
                                                <p class="notification-text font-small-3 text-muted">We have project
                                                    party this saturday.</p><small>
                                                    <time class="media-meta text-muted"
                                                        datetime="2015-06-11T18:29:20+08:00">last month</time></small>
                                            </div>
                                        </div>
                                    </a></li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                        href="javascript:void(0)">Read all messages</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a
                                class="dropdown-toggle nav-link dropdown-user-link" href="#"
                                data-toggle="dropdown"><span class="mr-1 user-name text-bold-700">John Doe</span><span
                                    class="avatar avatar-online"><img
                                        src="../../../app-assets/images/portrait/small/avatar-s-19.png"
                                        alt="avatar"><i></i></span></a>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i
                                        class="ft-user"></i> Edit Profile</a><a class="dropdown-item"
                                    href="#"><i class="ft-clipboard"></i> Todo</a><a class="dropdown-item"
                                    href="#"><i class="ft-check-square"></i> Task</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item"
                                    href="login-with-bg-image.html"><i class="ft-power"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->

    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="active"><a href="/dashboard"><i class="la la-home"></i><span class="menu-title"
                            data-i18n="eCommerce Dashboard">Dashboard</span></a>
                </li>
                <li class=" navigation-header"><span data-i18n="Ecommerce">Menu Utama</span><i
                        class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right"
                        data-original-title="menuutama"></i>
                </li>
                <li class=" nav-item"><a href="/dashboard"><i class="la la-th-large"></i><span class="menu-title"
                            data-i18n="Shop">Ringkasan</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-list"></i><span class="menu-title"
                            data-i18n="Product Detail">Kas Awal Kampus</span></a>
                </li>
                <li class=" nav-item"><a href="/noperki"><i class="la la-newspaper-o"></i><span class="menu-title"
                            data-i18n="Shopping Cart">Nomor Perkiraan</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-clipboard"></i><span class="menu-title"
                            data-i18n="Invoice">Transaksi Kas</span></a>
                    <ul class="menu-content">
<<<<<<< HEAD
                        <li><a class="menu-item" href="invoice-summary.html"><i></i><span
                                    data-i18n="Invoice Summary">Kas Masuk</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">Kas Keluar</span></a>
=======
                        <li><a class="menu-item" href="/kas/masuk"><i></i><span data-i18n="Invoice Summary">Kas
                                    Masuk</span></a>
                        </li>
                        <li><a class="menu-item" href="/kas/keluar"><i></i><span data-i18n="Invoice Template">Kas
                                    Keluar</span></a>
>>>>>>> 0b8f2a4f51b14d58eb6e8f5f84f115632ee3170d
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-shopping-cart"></i><span class="menu-title"
                            data-i18n="Invoice">Data Pengajuan</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="invoice-summary.html"><i></i><span
                                    data-i18n="Invoice Summary">Riwayat Pengajuan</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">Cari Pengajuan</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-briefcase"></i><span class="menu-title"
                            data-i18n="Invoice">Laporan BAKU</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="invoice-summary.html"><i></i><span
                                    data-i18n="Invoice Summary">Periode</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">Kas Baku</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">Kas Kampus</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">Kategori</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">Perbank</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-calendar"></i><span class="menu-title"
                            data-i18n="Invoice">Laporan Fakultas</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="invoice-summary.html"><i></i><span
                                    data-i18n="Invoice Summary">FTI</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">FKB</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">FEB</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="ecommerce-checkout.html"><i class="la la-credit-card"></i><span
                            class="menu-title" data-i18n="Checkout">Buat Voucher</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-check-square"></i><span class="menu-title"
                            data-i18n="Invoice">Pengajuan</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="invoice-summary.html"><i></i><span
                                    data-i18n="Invoice Summary">Buat Pengajuan</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">Multi Pengajuan</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-list.html"><i></i><span
                                    data-i18n="Invoice List">History Pengajuan</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header"><span data-i18n="Ecommerce">KAMPUS</span><i class="la la-ellipsis-h"
                        data-toggle="tooltip" data-placement="right" data-original-title="kampus"></i>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-home"></i><span class="menu-title"
                            data-i18n="Invoice">Kas Kampus</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="invoice-summary.html"><i></i><span
                                    data-i18n="Invoice Summary">Kas Masuk</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">Kas Keluar</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-bank"></i><span class="menu-title"
                            data-i18n="Invoice">Laporan Kas Kampus</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="invoice-summary.html"><i></i><span
                                    data-i18n="Invoice Summary">Kas Kampus</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">Periode</span></a>
                        </li>
                        <li><a class="menu-item" href="invoice-template.html"><i></i><span
                                    data-i18n="Invoice Template">Lap Tahunan</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header"><span data-i18n="User Interface">TOOLS</span><i
                        class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right"
                        data-original-title="User Interface"></i>
                </li>
                <li class=" nav-item"><a href="ecommerce-order.html"><i class="la la-check-circle-o"></i><span
                            class="menu-title" data-i18n="Order">Input No Rekening</span></a>
                </li>
                <li class=" nav-item"><a href="#"><i class="la la-server"></i><span class="menu-title"
                            data-i18n="Components">Top List Pengajuan</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="component-alerts.html"><i></i><span
                                    data-i18n="Alerts">Servis</span></a>
                        </li>
                        <li><a class="menu-item" href="component-callout.html"><i></i><span
                                    data-i18n="Callout">UPD</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" nav-item"><a href="ecommerce-order.html"><i class="la la-lock"></i><span
                            class="menu-title" data-i18n="Order">Reset Password</span></a>
                </li>
                <li class=" nav-item"><a href="ecommerce-order.html"><i class="la la-search"></i><span
                            class="menu-title" data-i18n="Order">Support</span></a>
                </li>
                <li class=" nav-item"><a href="ecommerce-order.html"><i class="ft-power"></i><span
                            class="menu-title" data-i18n="Order">Logout</span></a>
                </li>
            </ul>
        </div>
    </div>

    <!-- END: Main Menu-->
    <!-- BEGIN: Content-->
    @yield('content');
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span
                class="float-md-left d-block d-md-inline-block">Copyright &copy; 2025 <a
                    class="text-bold-800 grey darken-2" href="https://1.envato.market/modern_admin"
                    target="_blank"><?= env('CIVITAS') ?></a></span><span class="float-md-right d-none d-lg-block">BTI
                &
                Made with<i class="ft-heart pink"></i><span id="scroll-top"></span></span></p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/charts/chartist.min.js"></script>
    <script src="../../../app-assets/vendors/js/charts/chartist-plugin-tooltip.min.js"></script>
    <script src="../../../app-assets/vendors/js/charts/raphael-min.js"></script>
    <script src="../../../app-assets/vendors/js/charts/morris.min.js"></script>
    <script src="../../../app-assets/vendors/js/timeline/horizontal-timeline.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>
    <!-- END: Page JS-->

    <script src="../../../app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/jszip.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/pdfmake.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/vfs_fonts.js"></script>
    <script src="../../../app-assets/vendors/js/tables/buttons.html5.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/buttons.print.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/buttons.colVis.min.js"></script>
    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/scripts/tables/datatables-extensions/datatable-button/datatable-html5.js"></script>
<<<<<<< HEAD
=======
    <script src="../../../app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
>>>>>>> 0b8f2a4f51b14d58eb6e8f5f84f115632ee3170d
    <!-- END: Page JS-->


</body>
<!-- END: Body-->

</html>
