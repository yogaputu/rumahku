<!-- app/Views/home.php -->
<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-9">
              <h1 class="m-0">Data Users</h1>
            </div>
            <div class="col-3">
              <a href="<?= base_url('users/create') ?>" class="btn btn-success" style="float: right">Tambah Data</a>
            </div>
          </div>
          <br>
          <?php if (!empty(session()->getFlashdata('message'))) : ?>
            <div class="alert alert-success">
              <?php echo session()->getFlashdata('message'); ?>
            </div>
          <?php endif ?>
          <?php if (!empty(session()->getFlashdata('alert'))) : ?>
            <div class="alert alert-danger">
              <?php echo session()->getFlashdata('alert'); ?>
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
              <h3 class="card-title">Data Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Desa</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
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
    function numberFormat(value) {
      return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    $('#example2').DataTable({
      "ajax": {
        "url": "<?= base_url('users/ajax') ?>", // Endpoint to fetch data from server
        "dataSrc": "data"
      },
      "columns": [{
          "data": null,
          "render": function(data, type, row, meta) {
            // 'meta.row' contains the index of the row
            return meta.row + 1; // Display row number starting from 1
          }
        },
        {
          "data": "username"
        },
        {
          "data": "role",
        },
        {
          "data": "subdis_name"
        },
        {
          "data": "id",
          "orderable": false,
          "render": function(data) {
            return '<a href="users/edit/' + data + '" class="btn btn-sm btn-primary">Edit</a>' +
              '<a href="users/delete/' + data + '" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Hapus</a>';
          }
        }
      ]
    });
  });

  function confirmDelete() {
    if (confirm('Yakin ingin menghapus?')) {
      return true; // Proceed with the deletion
    } else {
      return false; // Cancel the deletion
    }
  }
</script>
<?= $this->endSection() ?>