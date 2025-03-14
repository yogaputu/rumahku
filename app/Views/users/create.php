<!-- app/Views/home.php -->
<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Users</h1>

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
          <?php if (isset($validation)) { ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $validation->listErrors() ?>
            </div>
          <?php } ?>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Tambah Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="<?php echo base_url('users/store') ?>" method="POST">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" name="username" placeholder="Masukkan Username" required>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Masukkan Password">
                </div>
                <div class="form-group">
                  <label>Kecamatan</label>
                  <select name="dis_id" id="kecamatan" class="form-control">
                    <option value="">--- Pilih Kecamatan ---</option>
                    <?php foreach ($kecamatan as $key => $kecamatan) : ?>
                      <option value="<?= $kecamatan['dis_id'] ?>"><?= $kecamatan['dis_name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Desa</label>
                  <select name="subdis_id" id="desa" class="form-control">

                  </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </form>
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
    $('#kecamatan').change(function() {
      var kecamatanId = $(this).val();

      // AJAX request to fetch Desa data
      $.ajax({
        type: 'POST',
        url: '<?= base_url('users/getDesaByKecamatan') ?>',
        data: {
          dis_id: kecamatanId
        },
        dataType: 'json',
        success: function(data) {
          var options = '<option value="">--- Pilih Desa ---</option>';
          // Append fetched data to the Desa dropdown
          $.each(data, function(key, value) {
            options += '<option value="' + value.subdis_id + '">' + value.subdis_name + '</option>';
          });
          $('#desa').html(options); // Update the Desa dropdown
        }
      });
    });
  });
</script>
<?= $this->endSection() ?>