
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <base href="../" />

    <title>Dashboard - KzParking Admin</title>

    <!-- include common vendor stylesheets & fontawesome -->
    <!-- <link rel="stylesheet" type="text/css" href="./node_modules/bootstrap/dist/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/regular.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/brands.css">
    <link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/solid.css"> -->

    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">


<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">




    <!-- include vendor stylesheets used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-stylesheets.hbs" -->


    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="./dist/css/ace-font.css">



    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="./dist/css/ace.css">


    <!-- favicon -->
    <link rel="icon" type="image/png" href="./assets/favicon.png" />

    <!-- "Dashboard" page styles, specific to this page for demo only
    <link rel="stylesheet" type="text/css" href="./views/pages/dashboard/@page-style.css"> -->
  </head>

  <body>
    <div class="body-container">
      <nav class="navbar navbar-expand-lg navbar-fixed navbar-blue">
        <div class="navbar-inner">

          <div class="navbar-intro justify-content-xl-between">

            <button type="button" class="btn btn-burger burger-arrowed static collapsed ml-2 d-flex d-xl-none" data-toggle-mobile="sidebar" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle sidebar">
              <span class="bars"></span>
            </button><!-- mobile sidebar toggler button -->

            <a class="navbar-brand text-white" href="#">
              <i class="fa fa-leaf"></i>
              <span>KzTek</span>
              <span>Ipaking</span>
            </a><!-- /.navbar-brand -->

            <button type="button" class="btn btn-burger mr-2 d-none d-xl-flex" data-toggle="sidebar" data-target="#sidebar" aria-controls="sidebar" aria-expanded="true" aria-label="Toggle sidebar">
              <span class="bars"></span>
            </button><!-- sidebar toggler button -->

          </div><!-- /.navbar-intro -->


       


          <!-- mobile #navbarMenu toggler button -->
          <button class="navbar-toggler ml-1 mr-2 px-1" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navbar menu">
            <span class="pos-rel">
                  <img class="border-2 brc-white-tp1 radius-round" width="36" src="assets/image/avatar/avatar6.jpg" alt="Jason's Photo">
                  <span class="bgc-warning radius-round border-2 brc-white p-1 position-tr mr-n1px mt-n1px"></span>
            </span>
          </button>


          <div class="navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">

            <div class="navbar-nav">
              <ul class="nav">
                <li class="nav-item dropdown order-first order-lg-last">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img id="id-navbar-user-image" class="d-none d-lg-inline-block radius-round border-2 brc-white-tp1 mr-2 w-6" src="assets/image/avatar/avatar6.jpg" alt="Jason's Photo">
                    <span class="d-inline-block d-lg-none d-xl-inline-block">
                              <span class="text-90" id="id-user-welcome">Welcome,</span>
                    <span class="nav-user-name"><?= htmlspecialchars($_SESSION['user']['Name']) ?></span>
                    </span>

                    <i class="caret fa fa-angle-down d-none d-xl-block"></i>
                    <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                  </a>

                  <div class="dropdown-menu dropdown-caret dropdown-menu-right dropdown-animated brc-primary-m3 py-1">
                    <div class="d-none d-lg-block d-xl-none">
                      <div class="dropdown-header">
                        Welcome, Jason
                      </div>
                      <div class="dropdown-divider"></div>
                    </div>

                    <div class="dropdown-clickable px-3 py-25 bgc-h-secondary-l3 border-b-1 brc-secondary-l2">
                      <!-- online/offline toggle -->
                      <div class="d-flex justify-content-center align-items-center tex1t-600">
                        <label for="id-user-online" class="text-grey-d1 pt-2 px-2">offline</label>
                        <input type="checkbox" class="ace-switch ace-switch-sm text-grey-l1 brc-green-d1" id="id-user-online" />
                        <label for="id-user-online" class="text-green-d1 text-600 pt-2 px-2">online</label>
                      </div>
                    </div>

                    <a class="mt-1 dropdown-item btn btn-outline-grey bgc-h-primary-l3 btn-h-light-primary btn-a-light-primary" href="index.php?page=profile">
                      <i class="fa fa-user text-primary-m1 text-105 mr-1"></i>
                      Profile
                    </a>

                    <a class="dropdown-item btn btn-outline-grey bgc-h-success-l3 btn-h-light-success btn-a-light-success" href="#" data-toggle="modal" data-target="#id-ace-settings-modal">
                      <i class="fa fa-cog text-success-m1 text-105 mr-1"></i>
                      Settings
                    </a>

                    <div class="dropdown-divider brc-primary-l2"></div>

                    <a class="dropdown-item btn btn-outline-grey bgc-h-secondary-l3 btn-h-light-secondary btn-a-light-secondary" href="../pages/logout.php">
                      <i class="fa fa-power-off text-warning-d1 text-105 mr-1"></i>
                      Logout
                    </a>
                  </div>
                </li><!-- /.nav-item:last -->

              </ul><!-- /.navbar-nav menu -->
            </div><!-- /.navbar-nav -->

          </div><!-- /#navbarMenu -->


        </div><!-- /.navbar-inner -->
      </nav>