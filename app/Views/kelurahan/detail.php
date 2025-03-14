<!-- app/Views/home.php -->
<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Detail</h1>
          <br>
          <?php if (!empty(session()->getFlashdata('message'))) : ?>
            <div class="alert alert-success">
              <?php echo session()->getFlashdata('message'); ?>
            </div>
          <?php endif ?>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fcol-lg-4luid">
      <!-- Main row -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data RT</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example231" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Provinsi</th>
                    <th>Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan</th>
                    <th>RT</th>
                    <th>RW</th>
                    <th>Tanggal Pendataan</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $rt['prov_name'] ?></td>
                    <td><?php echo $rt['city_name'] ?></td>
                    <td><?php echo $rt['dis_name'] ?></td>
                    <td><?php echo $rt['subdis_name'] ?></td>
                    <td><?php echo $rt['rt'] ?></td>
                    <td><?php echo $rt['rw'] ?></td>
                    <td><?php echo $rt['tanggal_pendataan'] ?></td>
                    <td><?php echo $rt['latitude'] ?></td>
                    <td><?php echo $rt['longitude'] ?></td>
                  </tr>
                </tbody>
              </table>
              <br>
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Rekap Data RT</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">
                      <a href="<?php echo base_url('kelurahan/rekaprt/' . $idRT) ?>" class="btn btn-sm btn-success">Lihat Detail</a>
                    </td>
                  </tr>
                </tbody>
              </table>
              <br>
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Kekumuhan Awal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">
                      <a href="<?php echo base_url('kelurahan/kekumuhanawal/' . $idRT) ?>" class="btn btn-sm btn-success">Lihat Detail</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row (main row) -->
      <!-- Main row -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">File Pendukung</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example23" class="table table-bordered table-hover">
                <tbody>
                  <tr>
                    <td>
                      <?php if ($petaName) { ?>
                        <iframe src="<?= base_url('kelurahan/showPdf/' . $petaName) ?>" width="100%" height="700"></iframe>
                      <?php } ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  $(document).ready(function() {
    $('#example2').DataTable();
  });
</script>
<?= $this->endSection() ?>