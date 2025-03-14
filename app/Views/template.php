<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dinas Perumahan dan Permukiman Kab. Sukoharjo</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">
</head>

<body class="dark-mode hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <?php
      if (is_null(session()->get('logged_in'))) {
      ?>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Navbar Search -->
          <li class="nav-item">
            <a href="/login/index" class="nav-link">
              <i class="nav-icon fas fa fa-sign-out-alt"></i> Login
            </a>
          </li>
        </ul>

      <?php
      }
      ?>

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
        <img src="<?= base_url('logo/logo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-dark">Dinas PKP Sukoharjo</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <?php
            if (!is_null(session()->get('logged_in'))) {
            ?>
              <li class="nav-item">
                <a href="<?= base_url() ?>" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <?php if (session()->get('role') == 'admin') { ?>
                <li class="nav-item">
                  <a href="<?= base_url() ?>upload" class="nav-link">
                    <i class="nav-icon fas fa-upload"></i>
                    <p>
                      Upload
                    </p>
                  </a>
                </li>
              <?php } ?>
              <li class="nav-item">
                <a href="<?php if (session()->get('role') == 'admin') {
                  echo base_url('rt');
                } elseif (!session()->get('subdisId') || session()->get('subdisId') == 0) {
                  echo base_url('rt/detailKecamatan/'. session()->get('disId'));
                } else echo base_url('rt/detailKelurahan/' . session()->get('disId') .'/'. session()->get('subdisId')); ?>" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Data RT
                  </p>
                </a>
              </li>
              <?php if (session()->get('role') == 'admin') { ?>
                <li class="nav-item">
                  <a href="<?= base_url() ?>users" class="nav-link">
                    <i class="fa fa-users"></i>
                    <p>
                      Manajemen Users
                    </p>
                  </a>
                </li>
              <?php } ?>
              <li class="nav-item">
                <a href="<?= base_url('users/changePassword') ?>" class="nav-link">
                  <i class="fa fa-key"></i>
                  <p>
                    Ganti Password
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url() ?>logout" class="nav-link">
                  <i class="nav-icon fas fa fa-sign-out-alt"></i>
                  <p>
                    Logout
                  </p>
                </a>
              </li>
            <?php
            } else {
            ?>
              <li class="nav-item">
                <a href="<?= base_url() ?>login/index" class="nav-link">
                  <i class="nav-icon fas fa fa-sign-out-alt"></i>
                  <p>
                    Login
                  </p>
                </a>
              </li>
            <?php
            }
            ?>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <?= $this->renderSection('content') ?>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2023 <a href="https://lynxitboyolali.com">Lynx IT Boyolali</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 0.1.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="<?= base_url('adminlte/plugins/jquery/jquery.min.js') ?>"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <!-- ChartJS -->
  <script src="<?= base_url('adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?= base_url('adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/plugins/jszip/jszip.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/plugins/pdfmake/pdfmake.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/plugins/pdfmake/vfs_fonts.js') ?>"></script>
  <script src="<?= base_url('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
  <script src="<?= base_url('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('adminlte/dist/js/adminlte.js') ?>"></script>
  <?= $this->renderSection('script') ?>
</body>

</html>