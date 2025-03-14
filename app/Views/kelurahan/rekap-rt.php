<!-- app/Views/home.php -->
<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Rekap <?php echo $rt['prov_name'] . ', ' . $rt['city_name'] . ', ' . $rt['dis_name'] . ', ' . $rt['subdis_name'] . ', ' . $rt['rt'] . ', ' . $rt['rw'] ?></h1>
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
              <h3 class="card-title">Data Rekap RT</h3>
              <a href="<?php echo base_url('kelurahan/downloadrekaprt/' . $idRT) ?>" class="btn btn-sm btn-success" style="float: right;" target="_blank">Download</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Kriteria</th>
                    <th>Indikator</th>
                    <th>Nilai</th>
                    <th>Satuan</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Keteraturan Bangunan Hunian -->
                  <tr>
                    <td rowspan="2">Keteraturan Bangunan Hunian</td>
                    <td>Jumlah Keteraturan Bangunan Hunian</td>
                    <td><?php echo $rekapRTData['jumlah_keteraturan'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase Keteraturan Bangunan Hunian</td>
                    <td><?php echo $rekapRTData['persentase_keteraturan'] ?></td>
                    <td>persentase</td>
                  </tr>
                  <!-- Kepadatan Bangunan Hunian -->
                  <tr>
                    <td rowspan="4">Kepadatan Bangunan Hunian</td>
                    <td>Luas permukiman ….Ha</td>
                    <td><?php echo $rekapRTData['luas_permukiman'] ?></td>
                    <td>Ha</td>
                  </tr>
                  <tr>
                    <td>Jumlah total bangunan ……unit</td>
                    <td><?php echo $rekapRTData['jumlah_bangunan'] ?></td>
                    <td>Unit</td>
                  </tr>
                  <tr>
                    <td>Tingkat kepadatan bangunan …..unit/Ha</td>
                    <td><?php echo $rekapRTData['tingkat_kepadatan'] ?></td>
                    <td>Unit/Ha</td>
                  </tr>
                  <tr>
                    <td>Luas area dengan kepadatan tinggi</td>
                    <td><?php echo $rekapRTData['luas_area_padat'] ?></td>
                    <td>Ha</td>
                  </tr>
                  <!-- Kelayakan Bangunan Hunian -->
                  <tr>
                    <td rowspan="4">Kelayakan Bangunan Hunian</td>
                    <td>Jumlah Bangunan hunian memiliki luas lantai ≥ 7,2 m2 per orang</td>
                    <td><?php echo $rekapRTData['jumlah_bangunan_7m'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase Bangunan hunian memiliki luas lantai ≥ 7,2 m2 per orang</td>
                    <td><?php echo $rekapRTData['persentase_bangunan_7m'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <tr>
                    <td>Jumlah Bangunan hunian memiliki kondisi Atap, Lantai, Dinding sesuai persyaratan teknis</td>
                    <td><?php echo $rekapRTData['jumlah_bangunan_sesuai'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase Bangunan hunian memiliki kondisi Atap, Lantai, Dinding sesuai persyaratan teknis</td>
                    <td><?php echo $rekapRTData['persentase_bangunan_sesuai'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <!-- Aksesibilitas Lingkungan -->
                  <tr>
                    <td rowspan="15">Aksesibilitas Lingkungan</td>
                    <td>Panjang total Jaringan Jalan Lingkungan yg ada</td>
                    <td><?php echo $rekapRTData['panjang_total_jalan'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Panjang jalan lingkungan dgn lebar > 1,5 meter</td>
                    <td><?php echo $rekapRTData['panjang_jalan_lingkungan'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Panjang jalan lingkungan dgn lebar > 1.5 meter yang permukaannya diperkeras</td>
                    <td><?php echo $rekapRTData['panjang_jalan_diperkeras'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Panjang kebutuhan Jalan baru diluar eksisting untuk melayani permukiman, termasuk penghubung dengan sistem jalan perkotaan. (Jawaban sesuai hasil perencanaan)</td>
                    <td><?php echo $rekapRTData['panjangan_kebutuhan_jalan_baru'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Persentase panjang kebutuhan Jalan baru diluar eksisting untuk melayani permukiman, termasuk penghubung dengan sistem jalan perkotaan.</td>
                    <td><?php echo $rekapRTData['persentase_jalan_baru'] ?></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>Panjang total Jaringan Jalan Lingkungan yang Ideal</td>
                    <td><?php echo $rekapRTData['panjang_jalan_ideal'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Jangkauan Jaringan Jalan Lingkungan</td>
                    <td><?php echo $rekapRTData['jangkauan_jaringan_jalan'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <tr>
                    <td>Panjang jalan lingkungan dgn lebar ≥ 1,5 meter yang permukaannya diperkeras dan tidak rusak</td>
                    <td><?php echo $rekapRTData['panjang_jalan_15_tidak_rusak'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Panjang jalan lingkungan dgn lebar ≥ 1,5 meter yang permukaannya tanah (tidak diperkeras) dan tidak rusak</td>
                    <td><?php echo $rekapRTData['panjang_jalan_15_tanah'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Panjang jalan lingkungan dgn lebar < 1,5 meter yang permukaannya diperkeras dan tidak rusak</td>
                    <td><?php echo $rekapRTData['panjang_jalan_kurang_tidak_rusak'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Panjang jalan lingkungan dgn lebar < 1,5 meter yang permukaannya tanah (tidak diperkeras) dan tidak rusak</td>
                    <td><?php echo $rekapRTData['panjang_jalan_kurang_tanah'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Panjang jalan lingkungan dgn lebar ≥ 1,5 meter yang dilengkapi sal. samping jalan</td>
                    <td><?php echo $rekapRTData['panjang_jalan_15_samping'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Panjang jalan lingkungan dgn lebar < 1,5 meter yang dilengkapi sal. samping jalan</td>
                    <td><?php echo $rekapRTData['panjang_jalan_kurang_samping'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Total Panjang keseluruhan jalan lingkungan yang permukaannya tidak rusak</td>
                    <td><?php echo $rekapRTData['total_jalan_tidak_rusak'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Jalan Sesuai Persyaratan Teknis</td>
                    <td><?php echo $rekapRTData['jalan_sesuai_teknis'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <!-- Drainase Lingkungan -->
                  <tr>
                    <td rowspan="10">Drainase Lingkungan</td>
                    <td>Luas Area permukiman tidak terjadi genangan air/banjir</td>
                    <td><?php echo $rekapRTData['luas_area_tidak_banjir'] ?></td>
                    <td>ha</td>
                  </tr>
                  <tr>
                    <td>Persentase Kawasan permukiman tidak terjadi genangan air/banjir</td>
                    <td><?php echo $rekapRTData['persentase_tidak_banjir'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <tr>
                    <td>Panjang Total Drainase Eksisting</td>
                    <td><?php echo $rekapRTData['panjang_drainase'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Panjang kebutuhan drainase baru sehingga permukiman terlayani jaringan drainase seluruhnya. Jawaban sesuai hasil perencanaan</td>
                    <td><?php echo $rekapRTData['kebutuhan_darinase'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Persentase panjang kebutuhan drainase baru sehingga permukiman terlayani jaringan drainase seluruhnya.</td>
                    <td><?php echo $rekapRTData['persentase_kebutuhan_drainase'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <tr>
                    <td>Panjang drainase Ideal</td>
                    <td><?php echo $rekapRTData['panjang_drainase_ideal'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Panjang drainase yang bersih dan tidak bau</td>
                    <td><?php echo $rekapRTData['panjang_drainase_bersih'] ?></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>Persentase panjang drainase yang bersih dan tidak bau</td>
                    <td><?php echo $rekapRTData['persentase_drainase_bersih'] ?></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>Panjang Kondisi jaringan drainase pada lokasi permukiman memiliki kualitas tidak rusak/berfungsi baik</td>
                    <td><?php echo $rekapRTData['panjang_drainase_baik'] ?></td>
                    <td>meter</td>
                  </tr>
                  <tr>
                    <td>Persentase Kondisi jaringan drainase pada lokasi permukiman memiliki kualitas minimum memadai</td>
                    <td><?php echo $rekapRTData['persentase_drainase_baik'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <!-- Pelayanan Air Minum -->
                  <tr>
                    <td rowspan="4">Pelayanan Air Minum</td>
                    <td>Jumlah Masyarakat terlayani Sarana Air Minum untuk minum, mandi, dan cuci (perpipaan atau non perpipaan terlindungi yang layak)</td>
                    <td><?php echo $rekapRTData['jumlah_air_minum'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase Masyarakat terlayani Sarana Air Minum untuk minum, mandi, dan cuci (perpipaan atau non perpipaan terlindungi yang layak)</td>
                    <td><?php echo $rekapRTData['persentase_air_minum'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <tr>
                    <td>Jumlah Masyarakat terpenuhi kebutuhan air minum, mandi, cuci (minimal 60liter/org/hari)</td>
                    <td><?php echo $rekapRTData['jumlah_terpenuhi'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase Masyarakat terpenuhi kebutuhan air minum, mandi, cuci (minimal 60liter/org/hari)</td>
                    <td><?php echo $rekapRTData['persentase_terpenuhi'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <!-- Pengelolaan Air Limbah  -->
                  <tr>
                    <td rowspan="5">Pengelolaan Air Limbah</td>
                    <td>Jumlah Masyarakat memiliki akses jamban keluarga / jamban bersama (5 KK/jamban)</td>
                    <td><?php echo $rekapRTData['jumlah_akses_jamban'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase Masyarakat memiliki akses jamban keluarga / jamban bersama (5 KK/jamban)</td>
                    <td><?php echo $rekapRTData['persentase_akses_jamban'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <tr>
                    <td>Jumlah Jamban keluarga/jamban bersama sesuai persyaratan teknis (memiliki kloset leher angsa yang terhubung dengan septic-tank)</td>
                    <td><?php echo $rekapRTData['jumlah_jamban_sesuai'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase Jamban keluarga/jamban bersama sesuai persyaratan teknis (memiliki kloset leher angsa yang terhubung dengan septic-tank)</td>
                    <td><?php echo $rekapRTData['persentase_jamban_sesuai'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <tr>
                    <td>Saluran pembuangan air limbah rumah tangga terpisah dengan saluran drainase lingkungan</td>
                    <td><?php echo $rekapRTData['saluran_pembuangan_air'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <!-- Pengelolaan Persampahan -->
                  <tr>
                    <td rowspan="6">Pengelolaan Persampahan</td>
                    <td>Jumlah Kepala Keluarga dengan Prasarana dan Sarana Persampahan Sesuai dengan persyaratan Teknis</td>
                    <td><?php echo $rekapRTData['jumlah_sarana_sesuai'] ?></td>
                    <td>Kepala Keluarga</td>
                  </tr>
                  <tr>
                    <td>Persentase Prasarana dan Sarana Persampahan Sesuai dengan persyaratan Teknis</td>
                    <td><?php echo $rekapRTData['persentase_sarana_sesuai'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <tr>
                    <td>Jumlah Sampah domestik rumah tangga di kawasan permukiman terangkut ke TPS/TPA min. dua kali seminggu</td>
                    <td><?php echo $rekapRTData['jumlah_sampah'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase Sampah domestik rumah tangga di kawasan permukiman terangkut ke TPS/TPA min. dua kali seminggu</td>
                    <td><?php echo $rekapRTData['persentase_sampah'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <tr>
                    <td>Jumlah KK dengan prasarana & sarana persampahan yang kondisi konstruksinya baik/tidak rusak (terpelihara)?</td>
                    <td><?php echo $rekapRTData['jumlah_sarana_baik'] ?></td>
                    <td>Kepala Keluarga</td>
                  </tr>
                  <tr>
                    <td>Persentase prasarana & sarana persampahan dengan kondisi konstruksinya baik/tidak rusak (terpelihara)?</td>
                    <td><?php echo $rekapRTData['persentase_sarana_baik'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <!-- Pengamanan Bahaya Kebakaran  -->
                  <tr>
                    <td rowspan="4">Pengamanan Bahaya Kebakaran</td>
                    <td>Jumlah Bangunan Hunian memiliki prasarana proteksi kebakaran</td>
                    <td><?php echo $rekapRTData['jumlah_proteksi_kebakaran'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase Kawasan permukiman memiliki prasarana proteksi kebakaran</td>
                    <td><?php echo $rekapRTData['persentase_proteksi_kebakaran'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <tr>
                    <td>Jumlah Bangunan Hunian dengan kawasan permukiman memiliki sarana proteksi kebakaran</td>
                    <td><?php echo $rekapRTData['jumlah_sarana_proteksi_kebakaran'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase sarana proteksi kebakaran</td>
                    <td><?php echo $rekapRTData['persentase_sarana_proteksi_kebakaran'] ?></td>
                    <td>persentase </td>
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
      <!-- Main row -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Rekap RT Non Fisik</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Kriteria</th>
                    <th>Indikator</th>
                    <th>Nilai</th>
                    <th>Satuan</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Legalitas pendirian bangunan -->
                  <tr>
                    <td rowspan="4">Legalitas pendirian bangunan</td>
                    <td>Jumlah Bangunan hunian memiliki IMB</td>
                    <td><?php echo $rekapRTNonData['jumlah_imb'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase Bangunan hunian memiliki IMB</td>
                    <td><?php echo $rekapRTNonData['persentase_imb'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <tr>
                    <td>Jumlah Lahan bangunan hunian memiliki SHM/ HGB/ Surat yang diakui pemerintah</td>
                    <td><?php echo $rekapRTNonData['jumlah_shm'] ?></td>
                    <td>unit rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Persentase Lahan bangunan hunian memiliki SHM/ HGB/ Surat yang diakui pemerintah</td>
                    <td><?php echo $rekapRTNonData['persentase_shm'] ?></td>
                    <td>persentase </td>
                  </tr>
                  <!-- Kepadatan penduduk  -->
                  <tr>
                    <td rowspan="3">Kepadatan penduduk </td>
                    <td>Kepadatan penduduk …..jiwa/Ha (=jumlah penduduk dibagi luas wilayah RT)</td>
                    <td><?php echo $rekapRTNonData['kepadatan_penduduk'] ?></td>
                    <td>jiwa/Ha</td>
                  </tr>
                  <tr>
                    <td>Jumlah penduduk </td>
                    <td><?php echo $rekapRTNonData['jumlah_penduduk'] ?></td>
                    <td>jiwa</td>
                  </tr>
                  <tr>
                    <td>Luas wilayah RT</td>
                    <td><?php echo $rekapRTNonData['luas_rt'] ?></td>
                    <td>Ha</td>
                  </tr>
                  <!-- Mata pencarian penduduk  -->
                  <tr>
                    <td rowspan="7">Mata pencarian penduduk </td>
                    <td>Pertanian,perkebunan, kehutanan, peternakan</td>
                    <td><?php echo $rekapRTNonData['pertanian'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Perikanan/nelayan</td>
                    <td><?php echo $rekapRTNonData['perikanan'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Pertambangan/galian</td>
                    <td><?php echo $rekapRTNonData['pertambangan'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Industri/pabrik</td>
                    <td><?php echo $rekapRTNonData['industri'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Konstruksi/bangunan</td>
                    <td><?php echo $rekapRTNonData['kontruksi'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Perdagangan/jasa (guru, tenaga kesehatan, hotel, dll)</td>
                    <td><?php echo $rekapRTNonData['perdagangan'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Pegawai pemerintah</td>
                    <td><?php echo $rekapRTNonData['pns'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <!-- Penggunaan Daya Listrik -->
                  <tr>
                    <td rowspan="5">Penggunaan Daya Listrik </td>
                    <td>
                      < 450 Watt</td>
                    <td><?php echo $rekapRTNonData['listrik_450'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>900 Watt</td>
                    <td><?php echo $rekapRTNonData['listrik_900'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>1300 Watt</td>
                    <td><?php echo $rekapRTNonData['listrik_1300'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>≥ 2200 Watt</td>
                    <td><?php echo $rekapRTNonData['listrik_2200'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Menumpang/tidak punya meteran sendiri/dll</td>
                    <td><?php echo $rekapRTNonData['menumpang'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <!-- Fasilitas Pelayanan Kesehatan -->
                  <tr>
                    <td rowspan="6">Fasilitas Pelayanan Kesehatan </td>
                    <td>Rumah Sakit</td>
                    <td><?php echo $rekapRTNonData['rs'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Praktik dokter/poliklinik</td>
                    <td><?php echo $rekapRTNonData['dokter'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Puskesmas/Pustu</td>
                    <td><?php echo $rekapRTNonData['puskesmas'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Dukun/Pengobatan tradisional</td>
                    <td><?php echo $rekapRTNonData['dukun'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Bidan/mantri</td>
                    <td><?php echo $rekapRTNonData['bidan'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Tidak pernah </td>
                    <td><?php echo $rekapRTNonData['tidak_pernah'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <!-- Fasilitas Pelayanan Pendidikan -->
                  <tr>
                    <td rowspan="5">Fasilitas Pelayanan Pendidikan </td>
                    <td>Dalam kelurahan/kecamatan yang sama</td>
                    <td><?php echo $rekapRTNonData['dalam_kelurahan'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Luar kecamatan</td>
                    <td><?php echo $rekapRTNonData['luar_kecamatan'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Di kota lain</td>
                    <td><?php echo $rekapRTNonData['kota_lain'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Tidak sekolah</td>
                    <td><?php echo $rekapRTNonData['tidak_ada_sekolah'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <tr>
                    <td>Tidak ada anggota rumah tangga usia wajib belajar</td>
                    <td><?php echo $rekapRTNonData['tidak_ada_anggota'] ?></td>
                    <td>rumah tangga</td>
                  </tr>
                  <!-- Pertimbangan Fungsi Strategis Lokasi -->
                  <tr>
                    <td rowspan="2">Pertimbangan Fungsi Strategis Lokasi </td>
                    <td>Lokasi "berada" pada fungsi strategis Kab/Kota</td>
                    <td><?php echo $rekapRTNonData['strategis'] ?></td>
                    <td>RT (Rukun Tetangga)</td>
                  </tr>
                  <tr>
                    <td>Lokasi "tidak" berada pada fungsi strategis Kab/Kota yang</td>
                    <td><?php echo $rekapRTNonData['tidak_strategis'] ?></td>
                    <td>RT (Rukun Tetangga)</td>
                  </tr>
                  <!-- Potensi Sosial, ekonomi, budaya untuk dikembangkan -->
                  <tr>
                    <td rowspan="2">Potensi Sosial, ekonomi, budaya untuk dikembangkan </td>
                    <td>Lokasi "memiliki" Potensi Sosial, ekonomi, budaya untuk dikembangkan</td>
                    <td><?php echo $rekapRTNonData['potensial'] ?></td>
                    <td>RT (Rukun Tetangga)</td>
                  </tr>
                  <tr>
                    <td>Lokasi "tidak" memiliki Potensi Sosial, ekonomi, budaya untuk dikembangkan</td>
                    <td><?php echo $rekapRTNonData['tidak_potensial'] ?></td>
                    <td>RT (Rukun Tetangga)</td>
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