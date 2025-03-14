<!-- app/Views/home.php -->
<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Detail <?php echo $rt['prov_name'] . ', ' . $rt['city_name'] . ', ' . $rt['dis_name'] . ', ' . $rt['subdis_name'] . ', ' . $rt['rt'] . ', ' . $rt['rw'] ?></h1>
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
              <h3 class="card-title">Data B1.KEPADATAN BANGUNAN HUNIAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Luas RT</th>
                    <th>Luas Permukiman</th>
                    <th>Jml Total Bangunan</th>
                    <th>Kawasan permukman yg terletak di wil. Kemiringan >15%</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $b1Data['luas_rt'] ?></td>
                    <td><?php echo $b1Data['luas_permukiman'] ?></td>
                    <td><?php echo $b1Data['jumlah_total_bangunan'] ?></td>
                    <td><?php echo $b1Data['kawasan_permukaan'] ?></td>
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
              <h3 class="card-title">Data B2. AKSESIBILITAS LINGKUNGAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Total Jaringan Jalan Lingkungan yang telah ada/eksisting</th>
                    <th>Panjang jalan lingkungan dgn lebar ≥ 1,5 meter</th>
                    <th>Panjang jalan lingkungan dgn lebar ≥ 1.5 meter yang permukaannya diperkeras</th>
                    <th>Panjang kebutuhan Jalan baru diluar yang telah ada /eksisting untuk melayani permukiman</th>
                    <th>Panjang jalan lingkungan dgn lebar ≥1,5 meter yang permukaannya diperkeras dan tidak rusak</th>
                    <th>Panjang jalan lingkungan dgn lebar ≥1,5 meter yang permukaannya tanah (tidak diperkeras) dan tidak rusak</th>
                    <th>Panjang jalan lingkungan dgn lebar < 1,5 meter yang permukaannya diperkeras dan tidak rusak </th>
                    <th>Panjang jalan lingkungan dgn lebar < 1,5 meter yang permukaannya tanah (tidak diperkeras) dan tidak rusak </th>
                    <th>Panjang jalan lingkungan dgn lebar ≥1,5 meter yang dilengkapi sal. samping jalan</th>
                    <th>Panjang jalan lingkungan dgn lebar < 1,5 meter yang dilengkapi sal. samping jalan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $b2Data['total_jaringan_jalan'] ?></td>
                    <td><?php echo $b2Data['panjang_jalan_lingkungan'] ?></td>
                    <td><?php echo $b2Data['panjang_jalan_lingkungan_diperkeras'] ?></td>
                    <td><?php echo $b2Data['panjang_kebutuhan_jalan'] ?></td>
                    <td><?php echo $b2Data['panjang_jaringan_jalan'] ?></td>
                    <td><?php echo $b2Data['panjang_jalan_tanah_tidak_rusak'] ?></td>
                    <td><?php echo $b2Data['panjang_jalan_diperkeras_tidak_rusak_kurang'] ?></td>
                    <td><?php echo $b2Data['panjanng_jalan_tanah_tidak_rusak_kurang'] ?></td>
                    <td><?php echo $b2Data['panjang_jalan_lengkap_saluran_samping'] ?></td>
                    <td><?php echo $b2Data['panjang_jalan_lengkap_saluran_samping_kurang'] ?></td>
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
              <h3 class="card-title">Data B3. DRAINASE LINGKUNGAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Tinggi Genangan</th>
                    <th>Durasi/lama genangan</th>
                    <th>Frekuensi genangan</th>
                    <th>Luas Area Genangan (dalam permukiman)</th>
                    <th>Sumber genangan</th>
                    <th>Panjang total drainase yang telah ada / eksisting</th>
                    <th>Apakah ada kebutuhan drainase baru untuk melayani permukiman?</th>
                    <th>Panjang kebutuhan drainase baru sehingga permukiman terlayani jaringan drainase seluruhnya</th>
                    <th>Panjang drainase dengan kondisi fisik baik/tidak rusak</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $b3Data['tinggi_genangan'] ?></td>
                    <td><?php echo $b3Data['durasi_genangan'] ?></td>
                    <td><?php echo $b3Data['frekuensi_genangan'] ?></td>
                    <td><?php echo $b3Data['luas_area_genangan'] ?></td>
                    <td><?php echo $b3Data['sumber_genangan'] ?></td>
                    <td><?php echo $b3Data['panjang_total_drainase'] ?></td>
                    <td><?php echo $b3Data['kebutuhan_drainase_baru'] ?></td>
                    <td><?php echo $b3Data['panjang_drainase_baru'] ?></td>
                    <td><?php echo $b3Data['panjang_drainase_konsdisi_baik'] ?></td>
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
              <h3 class="card-title">Data B.4 SANITASI LINGKUNGAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Apakah Saluran Drainase bercampur dengan buangan limbah cair Rumah tangga?</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $b4Data['saluran_drainase_bercampur_limbah'] ?></td>
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
              <h3 class="card-title">Data B.5 PENGELOLAAN PERSAMPAHAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Apakah ada prasarana pengelolaan sampah yang melayani permukiman (TPS/TPS-3R/TPST)?</th>
                    <th>Apakah ada sarana pengangkutan sampah yang melayani permukiman (Gerobak/Motor/Mobil)?</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $b5Data['prasarana_sampah'] ?></td>
                    <td><?php echo $b5Data['pengangkutan_sampah'] ?></td>
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
              <h3 class="card-title">Data B6. PENGAMANAN BAHAYA KEBAKARAN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Kejadian kebakaran</th>
                    <th>Penyebab Kejadian Bencana Kebakaran</th>
                    <th>Prasarana/Sarana Pencegahan Bahaya Kebakaran</th>
                    <th>Ketersediaan jalan dgn lebar minimal 3,5 m di lingkungan permukiman dengan jarak rumah terjauh < 100 m</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $b6Data['kejadian_kebakaran'] ?></td>
                    <td><?php echo $b6Data['penyebab_kejadian_kebakaran'] ?></td>
                    <td><?php echo $b6Data['sapras_pecegahan'] ?></td>
                    <td><?php echo $b6Data['ketersediaan_jalan'] ?></td>
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
              <h3 class="card-title">Data B7. DATA NON FISIK</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Rumah Sakit</th>
                    <th>Prakter Dokter/ Poliklinik</th>
                    <th>Puskesmas/ Pustu</th>
                    <th>Dukun/ pengobatan tradisional</th>
                    <th>Bidan/ Mantri</th>
                    <th>Tidak ada Faskes</th>
                    <th>TK/ PAUD</th>
                    <th>SD/sederajat</th>
                    <th>SMP/sederajat</th>
                    <th>SMA/SMK/sederajat</th>
                    <th>Perguruan Tinggi</th>
                    <th>Tidak ada Fasilitas Kesehatan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $b7Data['rumah_sakit'] ?></td>
                    <td><?php echo $b7Data['praktek_dokter'] ?></td>
                    <td><?php echo $b7Data['puskesmas'] ?></td>
                    <td><?php echo $b7Data['dukun'] ?></td>
                    <td><?php echo $b7Data['bidan'] ?></td>
                    <td><?php echo $b7Data['tidak_ada_faskes'] ?></td>
                    <td><?php echo $b7Data['tk'] ?></td>
                    <td><?php echo $b7Data['sd'] ?></td>
                    <td><?php echo $b7Data['smp'] ?></td>
                    <td><?php echo $b7Data['sma'] ?></td>
                    <td><?php echo $b7Data['kampus'] ?></td>
                    <td><?php echo $b7Data['tidak_ada_sekolah'] ?></td>
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
              <h3 class="card-title">Data B.8. DATA PERTIMBANGAN LAIN</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table id="example23" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Pertimbangan Strategis lokasi</th>
                    <th>Lokasi memiliki Potensi Sosial, ekonomi, budaya untuk dikembangkan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php echo $b8Data['lokasi_strategis'] ?></td>
                    <td><?php echo $b8Data['lokasi_potensi'] ?></td>
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