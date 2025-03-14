<!-- app/Views/home.php -->
<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Kekumuhan Awal <?php echo $rt['prov_name'] . ', ' . $rt['city_name'] . ', ' . $rt['dis_name'] . ', ' . $rt['subdis_name'] . ', ' . $rt['rt'] . ', ' . $rt['rw'] ?></h1>
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
              <h3 class="card-title">Data Kekumuhan Awal</h3>
              <a href="<?php echo base_url('kelurahan/downloadkekumuhanawal/' . $idRT) ?>" class="btn btn-sm btn-success" style="float: right;" target="_blank">Download</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th rowspan="2">Aspek</th>
                    <th rowspan="2">Kriteria</th>
                    <th colspan="4">Kondisi Awal (Baseline)</th>
                  </tr>
                  <tr>
                    <th>Volume</th>
                    <th>Satuan</th>
                    <th>Prosen (%)</th>
                    <th>Nilai</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- KONDISI BANGUNAN GEDUNG -->
                  <tr>
                    <td rowspan="3">1. KONDISI BANGUNAN GEDUNG</td>
                    <td>a. Ketidakteraturan Bangunan</td>
                    <td><?php echo $kekumuhanAwalData['volume_ketidakteraturan_bangunan'] ?></td>
                    <td> Unit </td>
                    <td><?php echo $kekumuhanAwalData['persentase_ketidakteraturan_bangunan'] ?></td>
                    <td><?php echo $kekumuhanAwalData['ketidakteraturan_bangunan'] ?></td>
                  </tr>
                  <tr>
                    <td>b. Kepadatan Bangunan</td>
                    <td><?php echo $kekumuhanAwalData['volume_kepadatan_penduduk'] ?></td>
                    <td> Ha </td>
                    <td><?php echo $kekumuhanAwalData['persentase_kepadatan_penduduk'] ?></td>
                    <td><?php echo $kekumuhanAwalData['kepadatan_penduduk'] ?></td>
                  </tr>
                  <tr>
                    <td>c. Ketidaksesuaian dengan Persy Teknis Bangunan</td>
                    <td><?php echo $kekumuhanAwalData['volume_ketidaksesuaian_persyaratan'] ?></td>
                    <td> Unit </td>
                    <td><?php echo $kekumuhanAwalData['persentase_ketidaksesuaian_persyaratan'] ?></td>
                    <td><?php echo $kekumuhanAwalData['ketidaksesuaian_persyaratan'] ?></td>
                  </tr>
                  <tr>
                    <td colspan="2">Rata-rata Kondisi Bangunan Gedung</td>
                    <td colspan="4"><?php echo $kekumuhanAwalData['rata_kondisi_gedung'] ?></td>
                  </tr>
                  <!-- Kondisi Jalan Lingkungan -->
                  <tr>
                    <td rowspan="2">2. Kondisi Jalan Lingkungan</td>
                    <td>a. Cakupan Pelayanan Jalan Lingkungan</td>
                    <td><?php echo $kekumuhanAwalData['volume_cakupan_jalan'] ?></td>
                    <td> Meter </td>
                    <td><?php echo $kekumuhanAwalData['persentase_cakupan_jalan'] ?></td>
                    <td><?php echo $kekumuhanAwalData['cakupan_jalan'] ?></td>
                  </tr>
                  <tr>
                    <td>b. Kualitas Permukaan Jalan lingkungan</td>
                    <td><?php echo $kekumuhanAwalData['volume_kualitas_jalan'] ?></td>
                    <td> Meter </td>
                    <td><?php echo $kekumuhanAwalData['persentase_kualitas_jalan'] ?></td>
                    <td><?php echo $kekumuhanAwalData['kualitas_jalan'] ?></td>
                  </tr>
                  <tr>
                    <td colspan="2">Rata-rata Kondisi Jalan Lingkungan</td>
                    <td colspan="4"><?php echo $kekumuhanAwalData['rata_jalan'] ?></td>
                  </tr>
                  <!-- 3. Kondisi Penyediaan Air Minum -->
                  <tr>
                    <td rowspan="2">3. Kondisi Penyediaan Air Minum</td>
                    <td>a. Ketersediaan Akses Aman Air Minum</td>
                    <td><?php echo $kekumuhanAwalData['volume_akses_air_minum'] ?></td>
                    <td> KK </td>
                    <td><?php echo $kekumuhanAwalData['persentase_akses_air_minum'] ?></td>
                    <td><?php echo $kekumuhanAwalData['akses_air_minum'] ?></td>
                  </tr>
                  <tr>
                    <td>b. Tidak terpenuhinya Kebutuhan Air Minum</td>
                    <td><?php echo $kekumuhanAwalData['volume_tidak_terpenuhi_air_minum'] ?></td>
                    <td> KK </td>
                    <td><?php echo $kekumuhanAwalData['persentase_tidak_terpenuhi_air_minum'] ?></td>
                    <td><?php echo $kekumuhanAwalData['tidak_terpenuhi_air_minum'] ?></td>
                  </tr>
                  <tr>
                    <td colspan="2">Rata-rata Kondisi Penyediaan Air Minum</td>
                    <td colspan="4"><?php echo $kekumuhanAwalData['rata_kondisi_air_minum'] ?></td>
                  </tr>
                  <!-- 4. Kondisi Drainase Lingkungan -->
                  <tr>
                    <td rowspan="3">4. Kondisi Drainase Lingkungan</td>
                    <td>a. Ketidakmampuan Mengalirkan Limpasan Air</td>
                    <td><?php echo $kekumuhanAwalData['volume_limpasan_air'] ?></td>
                    <td> Ha </td>
                    <td><?php echo $kekumuhanAwalData['persentase_limpasan_air'] ?></td>
                    <td><?php echo $kekumuhanAwalData['limpasan_air'] ?></td>
                  </tr>
                  <tr>
                    <td>b. Ketidaktersediaan Drainase</td>
                    <td><?php echo $kekumuhanAwalData['volume_tidak_drainase'] ?></td>
                    <td> Meter </td>
                    <td><?php echo $kekumuhanAwalData['persentase_tidak_drainase'] ?></td>
                    <td><?php echo $kekumuhanAwalData['tidak_drainase'] ?></td>
                  </tr>
                  <tr>
                    <td>c. Kualitas Konstruksi Drainase</td>
                    <td><?php echo $kekumuhanAwalData['volume_kualitas_drainase'] ?></td>
                    <td> Meter </td>
                    <td><?php echo $kekumuhanAwalData['persentase_kualitas_drainase'] ?></td>
                    <td><?php echo $kekumuhanAwalData['kualitas_drainase'] ?></td>
                  </tr>
                  <tr>
                    <td colspan="2">Rata-rata Kondisi Drainase Lingkungan</td>
                    <td colspan="4"><?php echo $kekumuhanAwalData['rata_drainase'] ?></td>
                  </tr>
                  <!-- 5. Kondisi Pengelolaan Air Limbah -->
                  <tr>
                    <td rowspan="2">5. Kondisi Pengelolaan Air Limbah</td>
                    <td>a. Sistem Pengelolaan Air Limbah Tidak Sesuai Standar Teknis</td>
                    <td><?php echo $kekumuhanAwalData['volume_air_limbah'] ?></td>
                    <td> KK </td>
                    <td><?php echo $kekumuhanAwalData['persentase_air_limbah'] ?></td>
                    <td><?php echo $kekumuhanAwalData['air_limbah'] ?></td>
                  </tr>
                  <tr>
                    <td>b. Prasarana dan Sarana Pengelolaan Air Limbah Tidak Sesuai dengan Persyaratan Teknis</td>
                    <td><?php echo $kekumuhanAwalData['volume_sarana_air_limbah'] ?></td>
                    <td> KK </td>
                    <td><?php echo $kekumuhanAwalData['persentase_sarana_air_limbah'] ?></td>
                    <td><?php echo $kekumuhanAwalData['sarana_air_limbah'] ?></td>
                  </tr>
                  <tr>
                    <td colspan="2">Rata-rata Kondisi Penyediaan Air Limbah</td>
                    <td colspan="4"><?php echo $kekumuhanAwalData['rata_air_limbah'] ?></td>
                  </tr>
                  <!-- 6. Kondisi Pengelolaan Persampahan -->
                  <tr>
                    <td rowspan="2">6. Kondisi Pengelolaan Persampahan</td>
                    <td>a. Prasarana dan Sarana Persampahan Tidak Sesuai dengan persyaratan Teknis</td>
                    <td><?php echo $kekumuhanAwalData['volume_sarana_sampah'] ?></td>
                    <td>KK</td>
                    <td><?php echo $kekumuhanAwalData['persentase_sarana_sampah'] ?></td>
                    <td><?php echo $kekumuhanAwalData['sarana_sampah'] ?></td>
                  </tr>
                  <tr>
                    <td>b. Sistem Pengelolaan Persampahan yang tidak sesuai Standar Teknis</td>
                    <td><?php echo $kekumuhanAwalData['volume_pengelolaan_sampah'] ?></td>
                    <td>KK</td>
                    <td><?php echo $kekumuhanAwalData['persentase_pengelolaan_sampah'] ?></td>
                    <td><?php echo $kekumuhanAwalData['pengelolaan_sampah'] ?></td>
                  </tr>
                  <tr>
                    <td colspan="2">Rata-rata Kondisi Pengelolaan Persampahan</td>
                    <td colspan="4"><?php echo $kekumuhanAwalData['rata_pengelolaan_sampah'] ?></td>
                  </tr>
                  <!-- 7. Kondisi Proteksi Kebakaran -->
                  <tr>
                    <td rowspan="2">7. Kondisi Proteksi Kebakaran</td>
                    <td>a. Ketidaktersediaan Prasarana Proteksi Kebakaran</td>
                    <td><?php echo $kekumuhanAwalData['volume_prasarana_kebakaran'] ?></td>
                    <td>Unit</td>
                    <td><?php echo $kekumuhanAwalData['persentase_prasarana_kebakaran'] ?></td>
                    <td><?php echo $kekumuhanAwalData['prasarana_kebakaran'] ?></td>
                  </tr>
                  <tr>
                    <td>b. Ketidaktersediaan Sarana Proteksi Kebakaran</td>
                    <td><?php echo $kekumuhanAwalData['volume_sarana_kebakaran'] ?></td>
                    <td>Unit</td>
                    <td><?php echo $kekumuhanAwalData['persentase_sarana_kebakaran'] ?></td>
                    <td><?php echo $kekumuhanAwalData['sarana_kebakaran'] ?></td>
                  </tr>
                  <tr>
                    <td colspan="2">Rata-rata Kondisi Proteksi Kebakaran</td>
                    <td colspan="4"><?php echo $kekumuhanAwalData['rata_kebakaran'] ?></td>
                  </tr>
                  <!-- total nilai -->
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="3">Total Nilai</td>
                    <td><?php echo $kekumuhanAwalData['total_nilai'] ?></td>
                  </tr>
                  <!-- TINGKAT KEKUMUHAN -->
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="3">Tingkat Kekumuhan</td>
                    <td><?php echo $kekumuhanAwalData['tingkat_kekumuhan'] ?></td>
                  </tr>
                  <!-- RATA2 KEKUMUHAN SEKTORAL -->
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="3">Rata-rata Kekumuhan Sektoral</td>
                    <td><?php echo $kekumuhanAwalData['kekumuhan_sektoral'] ?></td>
                  </tr>
                  <!-- KONTRIBUSI PENANGANAN -->
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="3">Kontribusi Penanganan</td>
                    <td><?php echo $kekumuhanAwalData['penanganan'] ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body table-responsive -->
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