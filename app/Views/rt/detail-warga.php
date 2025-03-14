<!-- app/Views/home.php -->
<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Detail <?php echo $warga['nama_kk'] ?></h1>
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
              <h3 class="card-title">Data A.1 KETERATURAN BANGUNAN HUNIAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Bangunan hunian memiliki Akses langsung ke jalan dan tidak terhalang oleh bangunan lain</th>
                    <th>Posisi muka bangunan hunian menghadap ke jalan</th>
                    <th>Menghadap langsung sungai/rawa/danau dan/atau TIDAK berada di atas sungai/rawa/danau</th>
                    <th>Di atas sempadan sungai/rawa/danau</th>
                    <th>Di daerah buangan limbah pabrik/ di bawah jalur listrik tegangan tinggi (sutet)</th>
                    <th>"SKOR A.1 KETERATURAN BANGUNAN"</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $a1Data['akses_jalan'] ?></td>
                    <td><?php echo $a1Data['posisi_bangunan'] ?></td>
                    <td><?php echo $a1Data['menghadap_sungai'] ?></td>
                    <td><?php echo $a1Data['diatas_sungai'] ?></td>
                    <td><?php echo $a1Data['buangan_limbah'] ?></td>
                    <td><?php if($a1Data['akses_jalan'] == 'Ya' && $a1Data['posisi_bangunan'] == 'Ya' && $a1Data['buangan_limbah'] == 'Tidak' && ($a1Data['diatas_sungai'] == 'Tdk ada sungai dll' || $a1Data['diatas_sungai'] == 'Ya') && ($a1Data['menghadap_sungai'] == 'Tdk ada sungai dll' || $a1Data['menghadap_sungai'] == 'Ya') ){
                      echo 1;
                    } else echo 0; ?></td>
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
              <h3 class="card-title">Data A.2 KELAYAKAN BANGUNAN HUNIAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Panjang</th>
                    <th>Lebar</th>
                    <th>Jumlah Lantai</th>
                    <th>Jumlah penghuni</th>
                    <th>Kondisi atap terluas</th>
                    <th>Kondisi dinding terluas</th>
                    <th>Jenis lantai terluas</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $a2Data['panjang_hunian'] ?></td>
                    <td><?php echo $a2Data['lebar_hunian'] ?></td>
                    <td><?php echo $a2Data['jumlah_lantai'] ?></td>
                    <td><?php echo $a2Data['jumlah_penghuni'] ?></td>
                    <td><?php echo $a2Data['kondisi_atap'] ?></td>
                    <td><?php echo $a2Data['kondisi_dinding'] ?></td>
                    <td><?php echo $a2Data['jenis_lantai'] ?></td>
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
              <h3 class="card-title">Data A.3 AIR MINUM</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Sumber utama AIR MINUM, MANDI, CUCI</th>
                    <th>Jarak ke septic tank terdekat (termasuk milik tetangga)</th>
                    <th>Kecukupan air minum, mandi, cuci sepanjang tahun</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $a3Data['sumber_air'] ?></td>
                    <td><?php echo $a3Data['jarak_septic_tank'] ?></td>
                    <td><?php echo $a3Data['kecukupan_air'] ?></td>
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
              <h3 class="card-title">Data A.4 PENGELOLAAN AIR LIMBAH/SANITASI</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Tempat Buang Air Besar</th>
                    <th>Jenis kloset yang digunakan</th>
                    <th>Pembuangan limbah tinja</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $a4Data['tempat_bab'] ?></td>
                    <td><?php echo $a4Data['jenis_kloset'] ?></td>
                    <td><?php echo $a4Data['pembuangan_tinja'] ?></td>
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
              <h3 class="card-title">Data A.5 PENGELOLAAN SAMPAH RUMAH TANGGA</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Pembuangan sampah rumah tangga</th>
                    <th>Pengangkutan sampah dari rumah ke TPS / TPA</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $a5Data['pembuangan_sampah'] ?></td>
                    <td><?php echo $a5Data['pengangkutan_sampah'] ?></td>
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
              <h3 class="card-title">Data A.6.1 PENDAPATAN RUMAH TANGGA</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Mata pencaharian utama rumah tangga</th>
                    <th>Daya Listrik yang digunakan (Watt)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $a61Data['pekerjaan'] ?></td>
                    <td><?php echo $a61Data['daya_listrik'] ?></td>
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
              <h3 class="card-title">Data A.6.2 PELAYANAN FASILITAS SOSIAL</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Jenis fasilitas kesehatan paling sering digunakan rumah tangga</th>
                    <th>Lokasi fasilitas kesehatan paling sering digunakan rumah tangga</th>
                    <th>Jika ada anggota rumah tangga usia wajib belajar (9 tahun): Lokasi SD/SMP sederajat yang digunakan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $a62Data['fasilitas_kesehatan'] ?></td>
                    <td><?php echo $a62Data['lokasi_fasilitas_kesehatan'] ?></td>
                    <td><?php echo $a62Data['lokasi_sekolah'] ?></td>
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
              <h3 class="card-title">Data A.6.3 ASPEK PENGUASAAN BANGUNAN DAN LAHAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Status penguasaan bangunan hunian</th>
                    <th>Status Legalitas bangunan hunian</th>
                    <th>Status penguasaan lahan bangunan hunian</th>
                    <th>Status legalitas lahan bangunan hunian</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $a63Data['status_hunian'] ?></td>
                    <td><?php echo $a63Data['legalitas_hunian'] ?></td>
                    <td><?php echo $a63Data['status_lahan_hunian'] ?></td>
                    <td><?php echo $a63Data['legalitas_lahan_hunian'] ?></td>
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