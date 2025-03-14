<?php

namespace App\Controllers;

ini_set('max_execution_time', 3600);
ini_set('memory_limit', -1);

use App\Models\DataRTModel;
use App\Models\ProvincesModel;
use App\Models\CityModel;
use App\Models\DistrictsModel;
use App\Models\SubdistrictsModel;
use App\Models\WargaModel;
use App\Models\A1Model;
use App\Models\A2Model;
use App\Models\A3Model;
use App\Models\A4Model;
use App\Models\A5Model;
use App\Models\A61Model;
use App\Models\A62Model;
use App\Models\A63Model;
use App\Models\B1Model;
use App\Models\B2Model;
use App\Models\B3Model;
use App\Models\B4Model;
use App\Models\B5Model;
use App\Models\B6Model;
use App\Models\B7Model;
use App\Models\B8Model;
use App\Models\KekumuhanAwalModel;
use App\Models\RekapRTModel;
use App\Models\RekapRTNonModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Upload extends BaseController
{
  public function index()
  {
    return view('upload/upload');
  }
  /**
   * store function
   */
  public function store()
  {
    $uploadedFiles = $this->request->getFiles();
    foreach ($uploadedFiles['files'] as $file) {
      $newName = 'data.xlsx';
      $originalName = $file->getClientName();
      // Cek apakah terdapat file data.xlsx pada folder tmp
      if (is_file(ROOTPATH . 'public/uploads/' . $originalName)) // Jika file tersebut ada
        unlink(ROOTPATH . 'public/uploads/' . $originalName); // Hapus file tersebut

      $ext = $file->getExtension();

      // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
      if ($ext == 'xlsx') {

        $file->move(ROOTPATH . 'public/uploads', $originalName);

        $inputFileName = ROOTPATH . 'public/uploads/'. $originalName;
        // $reader = new Xlsx();
        $loadexcel = IOFactory::load($inputFileName);
        // $loadexcel = $reader->load($inputFileName);

        $sheet = $loadexcel->getSheetByName('Cover');
        $provinsi = $sheet->getCell('F17')->getValue();
        $kabupaten = $sheet->getCell('F18')->getValue();
        $kecamatan = $sheet->getCell('F19')->getValue();
        $kelurahan = $sheet->getCell('F20')->getValue();
        $rtrw = $sheet->getCell('F21')->getValue();
        if (strpos($rtrw, '-') !== false) {
          $rtrw = explode('-', $rtrw);
        } else {
          $rtrw = explode('_', $rtrw);
        }
        $rt = $rtrw[0];
        $rw = $rtrw[1];
        $tanggal_pendataan = $sheet->getCell('F22')->getValue();

        $provincesModel = new ProvincesModel();
        $provincesData = $provincesModel->where('prov_name', $provinsi)->first();

        $cityModel = new CityModel();
        $cityData = $cityModel->where('city_name', $kabupaten)->first();

        $districtModel = new DistrictsModel();
        $districtData = $districtModel->where('dis_name', $kecamatan)->first();

        $subDistrictModel = new SubdistrictsModel();
        $subDistrictData = $subDistrictModel->where('subdis_name', $kelurahan)->first();

        $dataRT = new DataRTModel();

        if ($existingData = $this->isDataRTDuplicate($provincesData['prov_id'], $cityData['city_id'], $districtData['dis_id'], $subDistrictData['subdis_id'], $rt, $rw)) {
          $idRT = $existingData['id_rt'];
          $dataRT->where('prov_id', $provincesData['prov_id'])
          ->where('city_id', $cityData['city_id'])
          ->where('dis_id', $districtData['dis_id'])
          ->where('subdis_id', $subDistrictData['subdis_id'])
          ->where('rt', $rt)
          ->where('rw', $rw)
          ->set([
            'file' => $originalName,
          ])
          ->update();
        } else {
          $dataRT->insert([
            'prov_id'   => $provincesData['prov_id'],
            'city_id' => $cityData['city_id'],
            'dis_id' => $districtData['dis_id'],
            'subdis_id' => $subDistrictData['subdis_id'],
            'rt' => $rt,
            'rw' => $rw,
            'file' => $originalName,
          ]);
          $idRT = $dataRT->insertID();
        }

        $sheet = $loadexcel->getSheetByName('Form Lingkungan TK RT');
        $this->insertB1Data($sheet, $idRT);
        $this->insertB2Data($sheet, $idRT);
        $this->insertB3Data($sheet, $idRT);
        $this->insertB4Data($sheet, $idRT);
        $this->insertB5Data($sheet, $idRT);
        $this->insertB6Data($sheet, $idRT);
        $this->insertB7Data($sheet, $idRT);
        $this->insertB8Data($sheet, $idRT);

        $sheet = $loadexcel->getSheetByName('Form FGD RT Versi 1 Lembar A3')->toArray(null, true, true, true);

        foreach ($sheet as $row) { // Lakukan perulangan dari data yang ada di excel
          $no = $row['C'];
          if (!is_numeric($no)) continue;
          if ($row['D'] != '') {
            // warga
            $nama_kk = $row['D'];
            $no_ktp = $row['E'];

            $wargaModel = new WargaModel();

            if ($existingWarga = $this->isWargaDuplicate($idRT, $no_ktp, $nama_kk)) {
              $idWarga = $existingWarga['id_warga'];
            } else {
              $wargaModel->insert([
                'id_rt' => $idRT,
                'no_ktp' => $no_ktp,
                'nama_kk' => $nama_kk,
              ]);

              $idWarga = $wargaModel->insertID();
            }

            $this->insertA1Data($row, $idWarga);
            $this->insertA2Data($row, $idWarga);
            $this->insertA3Data($row, $idWarga);
            $this->insertA4Data($row, $idWarga);
            $this->insertA5Data($row, $idWarga);
            $this->insertA61Data($row, $idWarga);
            $this->insertA62Data($row, $idWarga);
            $this->insertA63Data($row, $idWarga);
          }
        }

        $sheet = $loadexcel->getSheetByName('C. Rekap data RT (logbook SIM)');
        $this->insertRekapRTData($sheet, $idRT);
        $this->insertRekapRTNonData($sheet, $idRT);

        $sheet = $loadexcel->getSheetByName('Kekumuhan Awal_RT');
        $this->insertKekumuhanAwal($sheet, $idRT);
      } else {
        //flash message
        session()->setFlashdata('message', 'File Harus xlsx');

        return redirect()->to(base_url('upload'));
      }
    }

    //flash message
    session()->setFlashdata('message', 'Upload Berhasil');

    return redirect()->to(base_url('upload'));
  }


  private function insertA1Data($row, $idWarga)
  {
    $akses_jalan = $row['F'] == 1 ? 'Ya' : 'Tidak';
    $posisi_bangunan = $row['G'] == 1 ? 'Ya' : 'Tidak';

    if ($row['J'] == 1) {
      $menghadap_sungai = 'Tdk ada sungai dll';
    } elseif ($row['K'] == 1) {
      $menghadap_sungai = 'Ya';
    } else $menghadap_sungai = 'Tidak';

    if ($row['M'] == 1) {
      $diatas_sungai = 'Tdk ada sungai dll';
    } elseif ($row['N'] == 1) {
      $diatas_sungai = 'Ya';
    } else $diatas_sungai = 'Tidak';

    $buangan_limbah = $row['P'] == 1 ? 'Tidak' : 'Ya';

    $a1Model = new A1Model();
    $updateData = [
      'akses_jalan' => $akses_jalan,
      'posisi_bangunan' => $posisi_bangunan,
      'menghadap_sungai' => $menghadap_sungai,
      'diatas_sungai' => $diatas_sungai,
      'buangan_limbah' => $buangan_limbah,
    ];

    // If no rows were updated, perform an insert
    if ($a1Model->where('id_warga', $idWarga)->first()) {
      $a1Model->where('id_warga', $idWarga)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_warga' => $idWarga,
        'akses_jalan' => $akses_jalan,
        'posisi_bangunan' => $posisi_bangunan,
        'menghadap_sungai' => $menghadap_sungai,
        'diatas_sungai' => $diatas_sungai,
        'buangan_limbah' => $buangan_limbah,
      ];

      $a1Model->insert($insertData);
    }
  }

  private function insertA2Data($row, $idWarga)
  {
    $panjang_hunian = $row['R'];
    $lebar_hunian = $row['S'];
    $jumlah_lantai = $row['T'];
    $jumlah_penghuni = $row['U'];
    $kondisi_atap = $row['V'] == 1 ? 'Tidak Bocor' : 'Bocor';
    $kondisi_dinding = $row['X'] == 1 ? 'Baik' : 'Rusak';
    $jenis_lantai = $row['Z'] == 1 ? 'Bukan Tanah' : 'Tanah';

    $a2Model = new A2Model();
    $updateData = [
      'panjang_hunian' => $panjang_hunian,
      'lebar_hunian' => $lebar_hunian,
      'jumlah_lantai' => $jumlah_lantai,
      'jumlah_penghuni' => $jumlah_penghuni,
      'kondisi_atap' => $kondisi_atap,
      'kondisi_dinding' => $kondisi_dinding,
      'jenis_lantai' => $jenis_lantai,
    ];

    // If no rows were updated, perform an insert
    if ($a2Model->where('id_warga', $idWarga)->first()) {
      $a2Model->where('id_warga', $idWarga)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_warga' => $idWarga,
        'panjang_hunian' => $panjang_hunian,
        'lebar_hunian' => $lebar_hunian,
        'jumlah_lantai' => $jumlah_lantai,
        'jumlah_penghuni' => $jumlah_penghuni,
        'kondisi_atap' => $kondisi_atap,
        'kondisi_dinding' => $kondisi_dinding,
        'jenis_lantai' => $jenis_lantai,
      ];

      $a2Model->insert($insertData);
    }
  }

  private function insertA3Data($row, $idWarga)
  {
    if ($row['AB'] == 1) {
      $sumber_air = 'Ledeng Meteran';
    } elseif ($row['AC'] == 1) {
      $sumber_air = 'Ledeng Tanpa Meteran';
    } elseif ($row['AD'] == 1) {
      $sumber_air = 'Sumur Bor/Pompa';
    } elseif ($row['AE'] == 1) {
      $sumber_air = 'Sumur Terlindungi';
    } elseif ($row['AF'] == 1) {
      $sumber_air = 'Mata Air Terlindungi';
    } elseif ($row['AG'] == 1) {
      $sumber_air = 'Air Hujan';
    } elseif ($row['AH'] == 1) {
      $sumber_air = 'Air Kemasan / Air Isi Ulang';
    } elseif ($row['AI'] == 1) {
      $sumber_air = 'Sumur Tidak Terlindungi';
    } elseif ($row['AJ'] == 1) {
      $sumber_air = 'Mata Air Tidak Terlindungi';
    } elseif ($row['AK'] == 1) {
      $sumber_air = 'Sungai/Danau/Kolam';
    } elseif ($row['AL'] == 1) {
      $sumber_air = 'Tangki/Mobil/Gerobak Air';
    }

    $jarak_septic_tank = NULL;
    if ($row['AM'] == 1) {
      $jarak_septic_tank = '≥ 10 m';
    } elseif ($row['AN'] == 1) {
      $jarak_septic_tank = '< 10 m';
    }

    if ($row['AO'] == 1) {
      $kecukupan_air = 'Tercukupi';
    } elseif ($row['AP'] == 1) {
      $kecukupan_air = 'tercukupi bulan tertentu';
    } else {
      $kecukupan_air = 'tidak pernah cukup';
    }

    $a3Model = new A3Model();
    $updateData = [
      'sumber_air' => $sumber_air,
      'jarak_septic_tank' => $jarak_septic_tank,
      'kecukupan_air' => $kecukupan_air,
    ];

    // If no rows were updated, perform an insert
    if ($a3Model->where('id_warga', $idWarga)->first()) {
      $a3Model->where('id_warga', $idWarga)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_warga' => $idWarga,
        'sumber_air' => $sumber_air,
        'jarak_septic_tank' => $jarak_septic_tank,
        'kecukupan_air' => $kecukupan_air,
      ];

      $a3Model->insert($insertData);
    }
  }

  private function insertA4Data($row, $idWarga)
  {
    $tempat_bab = $row['AR'] == 1 ? 'Jamban Sendiri/ bersama' : ($row['AS'] == 1 ? 'Jamban umum' : 'Tidak di jamban');
    $jenis_kloset = $row['AU'] == 1 ? 'Leher Angsa' : 'Bukan Leher Angsa';
    $pembuangan_tinja = $row['AW'] == 1 ? 'Septictank pribadi/komunal/ IPAL' : 'Bukan Septictank pribadi/komunal/ IPAL';

    $a4Model = new A4Model();
    $updateData = [
      'tempat_bab' => $tempat_bab,
      'jenis_kloset' => $jenis_kloset,
      'pembuangan_tinja' => $pembuangan_tinja,
    ];

    // If no rows were updated, perform an insert
    if ($a4Model->where('id_warga', $idWarga)->first()) {
      $a4Model->where('id_warga', $idWarga)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_warga' => $idWarga,
        'tempat_bab' => $tempat_bab,
        'jenis_kloset' => $jenis_kloset,
        'pembuangan_tinja' => $pembuangan_tinja,
      ];

      $a4Model->insert($insertData);
    }
  }

  private function insertA5Data($row, $idWarga)
  {
    if ($row['AY'] == 1) {
      $pembuangan_sampah = 'Tempat sampah pribadi';
    } elseif ($row['AZ'] == 1) {
      $pembuangan_sampah = 'Tempat sampah komunal/ TPS/TPS-3R';
    } elseif ($row['BA'] == 1) {
      $pembuangan_sampah = 'Dalam Lubang/ dibakar';
    } elseif ($row['BB'] == 1) {
      $pembuangan_sampah = 'Ruang terbuka/ lahan kosong/ jalan';
    } elseif ($row['BC'] == 1) {
      $pembuangan_sampah = 'Sungai/ Saluran Irigasi/ Danau/ Laut/ Drainase (Got/ Selokan)';
    }
    $pengangkutan_sampah = NULL;
    if ($row['BD'] == 1) {
      $pengangkutan_sampah = '≥ 2x seminggu';
    } elseif ($row['BE'] == 1) {
      $pengangkutan_sampah = '≤ 1x seminggu';
    }

    $a5Model = new A5Model();
    $updateData = [
      'pembuangan_sampah' => $pembuangan_sampah,
      'pengangkutan_sampah' => $pengangkutan_sampah,
    ];

    // If no rows were updated, perform an insert
    if ($a5Model->where('id_warga', $idWarga)->first()) {
      $a5Model->where('id_warga', $idWarga)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_warga' => $idWarga,
        'pembuangan_sampah' => $pembuangan_sampah,
        'pengangkutan_sampah' => $pengangkutan_sampah,
      ];

      $a5Model->insert($insertData);
    }
  }

  private function insertA61Data($row, $idWarga)
  {
    if ($row['BF'] == 1) {
      $pekerjaan = 'Pertanian, perkebunan, kehutanan, peternakan';
    } elseif ($row['BG'] == 1) {
      $pekerjaan = 'Perikanan/ nelayan';
    } elseif ($row['BH'] == 1) {
      $pekerjaan = 'Pertambangan/ galian';
    } elseif ($row['BI'] == 1) {
      $pekerjaan = 'Industri/ pabrik';
    } elseif ($row['BJ'] == 1) {
      $pekerjaan = 'Konstruksi/ bangunan';
    } elseif ($row['BK'] == 1) {
      $pekerjaan = 'Perdagangan/ jasa (guru, tenaga kesehatan, hotel, dll)';
    } elseif ($row['BL'] == 1) {
      $pekerjaan = 'Pegawai pemerintah';
    }

    if ($row['BM'] == 1) {
      $daya_listrik = '450';
    } elseif ($row['BN'] == 1) {
      $daya_listrik = '900';
    } elseif ($row['BO'] == 1) {
      $daya_listrik = '1300';
    } elseif ($row['BP'] == 1) {
      $daya_listrik = '2200 Keatas';
    } elseif ($row['BQ'] == 1) {
      $daya_listrik = 'Menumpang ke tetangga/ tidak punya meteran sendiri/dll';
    }

    $a61Model = new A61Model();
    $updateData = [
      'pekerjaan' => $pekerjaan,
      'daya_listrik' => $daya_listrik,
    ];

    // If no rows were updated, perform an insert
    if ($a61Model->where('id_warga', $idWarga)->first()) {
      $a61Model->where('id_warga', $idWarga)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_warga' => $idWarga,
        'pekerjaan' => $pekerjaan,
        'daya_listrik' => $daya_listrik,
      ];

      $a61Model->insert($insertData);
    }
  }

  private function insertA62Data($row, $idWarga)
  {
    if ($row['BZ'] == 1) {
      $fasilitas_kesehatan = 'Rumah Sakit';
    } elseif ($row['CA'] == 1) {
      $fasilitas_kesehatan = 'Prakter Dokter/ Poliklinik';
    } elseif ($row['CB'] == 1) {
      $fasilitas_kesehatan = 'Puskesmas/ Pustu';
    } elseif ($row['CC'] == 1) {
      $fasilitas_kesehatan = 'Dukun/ pengobatan tradisional';
    } elseif ($row['CD'] == 1) {
      $fasilitas_kesehatan = 'Bidan/ mantri';
    } elseif ($row['CE'] == 1) {
      $fasilitas_kesehatan = 'Tidak Pernah';
    }

    if ($row['CF'] == 1) {
      $lokasi_fasilitas_kesehatan = 'Dalam kel/ kec yg sama';
    } elseif ($row['CG'] == 1) {
      $lokasi_fasilitas_kesehatan = 'luar kecamatan ';
    } elseif ($row['CH'] == 1) {
      $lokasi_fasilitas_kesehatan = ' kota lain';
    }

    if ($row['CI'] == 1) {
      $lokasi_sekolah = 'Dalam kel/ kec yg sama';
    } elseif ($row['CJ'] == 1) {
      $lokasi_sekolah = 'Luar kecamatan';
    } elseif ($row['CK'] == 1) {
      $lokasi_sekolah = 'Di kota lain';
    } elseif ($row['CL'] == 1) {
      $lokasi_sekolah = 'Tidak sekolah';
    } elseif ($row['CM'] == 1) {
      $lokasi_sekolah = 'Tidak ada anggota rumah tangga usia wajib belajar';
    }

    $a62Model = new A62Model();
    $updateData = [
      'fasilitas_kesehatan' => $fasilitas_kesehatan,
      'lokasi_fasilitas_kesehatan' => $lokasi_fasilitas_kesehatan,
      'lokasi_sekolah' => $lokasi_sekolah,
    ];

    // If no rows were updated, perform an insert
    if ($a62Model->where('id_warga', $idWarga)->first()) {
      $a62Model->where('id_warga', $idWarga)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_warga' => $idWarga,
        'fasilitas_kesehatan' => $fasilitas_kesehatan,
        'lokasi_fasilitas_kesehatan' => $lokasi_fasilitas_kesehatan,
        'lokasi_sekolah' => $lokasi_sekolah,
      ];

      $a62Model->insert($insertData);
    }
  }

  private function insertA63Data($row, $idWarga)
  {
    if ($row['CN'] == 1) {
      $status_hunian = 'Milik Sendiri';
    } elseif ($row['CO'] == 1) {
      $status_hunian = 'Sewa/Kontrak';
    } elseif ($row['CP'] == 1) {
      $status_hunian = 'Numpang/milik pihak lain';
    }

    if ($row['CQ'] == 1) {
      $legalitas_hunian = 'Memiliki IMB';
    } elseif ($row['CR'] == 1) {
      $legalitas_hunian = 'Tidak/belum memiliki IMB ';
    }

    if ($row['CS'] == 1) {
      $status_lahan_hunian = 'Milik Sendiri';
    } elseif ($row['CT'] == 1) {
      $status_lahan_hunian = 'Sewa/kontrak';
    } elseif ($row['CU'] == 1) {
      $status_lahan_hunian = 'Numpang/milik pihak lain';
    }

    if ($row['CV'] == 1) {
      $legalitas_lahan_hunian = 'SHM/ HGB/ Surat yang diakui pemerintah';
    } elseif ($row['CW'] == 1) {
      $legalitas_lahan_hunian = 'Milik pihak lain/ surat perjanjian lainnya (termasuk surat adat)';
    } elseif ($row['CX'] == 1) {
      $legalitas_lahan_hunian = 'Milik pihak lain tanpa surat perjanjian ';
    } elseif ($row['CY'] == 1) {
      $legalitas_lahan_hunian = 'Tidak ada/tidak tahu';
    }

    $a63Model = new A63Model();
    $updateData = [
      'status_hunian' => $status_hunian,
      'legalitas_hunian' => $legalitas_hunian,
      'status_lahan_hunian' => $status_lahan_hunian,
      'legalitas_lahan_hunian' => $legalitas_lahan_hunian,
    ];

    // If no rows were updated, perform an insert
    if ($a63Model->where('id_warga', $idWarga)->first()) {
      $a63Model->where('id_warga', $idWarga)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_warga' => $idWarga,
        'status_hunian' => $status_hunian,
        'legalitas_hunian' => $legalitas_hunian,
        'status_lahan_hunian' => $status_lahan_hunian,
        'legalitas_lahan_hunian' => $legalitas_lahan_hunian,
      ];

      $a63Model->insert($insertData);
    }
  }

  private function insertB1Data($sheet, $idRT)
  {
    $luas_rt = $sheet->getCell('B19')->getValue();
    $luas_permukiman = $sheet->getCell('C19')->getValue();
    $jumlah_total_bangunan = $sheet->getCell('D19')->getValue();
    $kawasan_permukaan = $sheet->getCell('E19')->getValue();

    $b1Model = new B1Model();
    $updateData = [
      'luas_rt' => $luas_rt,
      'luas_permukiman' => $luas_permukiman,
      'jumlah_total_bangunan' => $jumlah_total_bangunan,
      'kawasan_permukaan' => $kawasan_permukaan,
    ];

    // If no rows were updated, perform an insert
    if ($b1Model->where('id_rt', $idRT)->first()) {
      $b1Model->where('id_rt', $idRT)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_rt' => $idRT,
        'luas_rt' => $luas_rt,
        'luas_permukiman' => $luas_permukiman,
        'jumlah_total_bangunan' => $jumlah_total_bangunan,
        'kawasan_permukaan' => $kawasan_permukaan,
      ];

      $b1Model->insert($insertData);
    }
  }

  private function insertB2Data($sheet, $idRT)
  {
    $total_jaringan_jalan = $sheet->getCell('H19')->getValue();
    $panjang_jalan_lingkungan = $sheet->getCell('I19')->getValue();
    $panjang_jalan_lingkungan_diperkeras = $sheet->getCell('J19')->getValue();
    $panjang_kebutuhan_jalan = $sheet->getCell('K19')->getValue();
    $panjang_jaringan_jalan = $sheet->getCell('M19')->getValue();
    $panjang_jalan_tanah_tidak_rusak = $sheet->getCell('N19')->getValue();
    $panjang_jalan_diperkeras_tidak_rusak_kurang = $sheet->getCell('O19')->getValue();
    $panjanng_jalan_tanah_tidak_rusak_kurang = $sheet->getCell('P19')->getValue();
    $panjang_jalan_lengkap_saluran_samping = $sheet->getCell('Q19')->getValue();
    $panjang_jalan_lengkap_saluran_samping_kurang = $sheet->getCell('R19')->getValue();

    $b2Model = new B2Model();
    $updateData = [
      'total_jaringan_jalan' => $total_jaringan_jalan,
      'panjang_jalan_lingkungan' => $panjang_jalan_lingkungan,
      'panjang_jalan_lingkungan_diperkeras' => $panjang_jalan_lingkungan_diperkeras,
      'panjang_kebutuhan_jalan' => $panjang_kebutuhan_jalan,
      'panjang_jaringan_jalan' => $panjang_jaringan_jalan,
      'panjang_jalan_tanah_tidak_rusak' => $panjang_jalan_tanah_tidak_rusak,
      'panjang_jalan_diperkeras_tidak_rusak_kurang' => $panjang_jalan_diperkeras_tidak_rusak_kurang,
      'panjanng_jalan_tanah_tidak_rusak_kurang' => $panjanng_jalan_tanah_tidak_rusak_kurang,
      'panjang_jalan_lengkap_saluran_samping' => $panjang_jalan_lengkap_saluran_samping,
      'panjang_jalan_lengkap_saluran_samping_kurang' => $panjang_jalan_lengkap_saluran_samping_kurang,
    ];

    // If no rows were updated, perform an insert
    if ($b2Model->where('id_rt', $idRT)->first()) {
      $b2Model->where('id_rt', $idRT)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_rt' => $idRT,
        'total_jaringan_jalan' => $total_jaringan_jalan,
        'panjang_jalan_lingkungan' => $panjang_jalan_lingkungan,
        'panjang_jalan_lingkungan_diperkeras' => $panjang_jalan_lingkungan_diperkeras,
        'panjang_kebutuhan_jalan' => $panjang_kebutuhan_jalan,
        'panjang_jaringan_jalan' => $panjang_jaringan_jalan,
        'panjang_jalan_tanah_tidak_rusak' => $panjang_jalan_tanah_tidak_rusak,
        'panjang_jalan_diperkeras_tidak_rusak_kurang' => $panjang_jalan_diperkeras_tidak_rusak_kurang,
        'panjanng_jalan_tanah_tidak_rusak_kurang' => $panjanng_jalan_tanah_tidak_rusak_kurang,
        'panjang_jalan_lengkap_saluran_samping' => $panjang_jalan_lengkap_saluran_samping,
        'panjang_jalan_lengkap_saluran_samping_kurang' => $panjang_jalan_lengkap_saluran_samping_kurang,
      ];

      $b2Model->insert($insertData);
    }
  }

  private function insertB3Data($sheet, $idRT)
  {
    if ($sheet->getCell('T19')->getValue() == 1) {
      $tinggi_genangan = 'Tidak Pernah Terjadi Genangan';
    } elseif ($sheet->getCell('U19')->getValue() == 1) {
      $tinggi_genangan = 'Tinggi genangan ≤ 30 cm';
    } else $tinggi_genangan = 'Tinggi genangan > 30 cm';

    $durasi_genangan = null;
    if ($sheet->getCell('W19')->getValue() == 1) {
      $durasi_genangan = '≤ 2 Jam';
    } elseif ($sheet->getCell('X19')->getValue() == 1) {
      $durasi_genangan = '> 2 Jam';
    }

    $frekuensi_genangan = null;
    if ($sheet->getCell('Y19')->getValue() == 1) {
      $frekuensi_genangan = '≤ 2 Kali per tahun';
    } elseif ($sheet->getCell('Z19')->getValue() == 1) {
      $frekuensi_genangan = '> 2 Kali per tahun';
    }
    $luas_area_genangan = $sheet->getCell('P19')->getValue();

    $sumber_genangan = null;
    if ($sheet->getCell('AB19')->getValue() == 1) {
      $sumber_genangan = 'Rob/ pasang air laut';
    } elseif ($sheet->getCell('AC19')->getValue() == 1) {
      $sumber_genangan = 'Sungai/ danau/ rawa';
    } elseif ($sheet->getCell('AD19')->getValue() == 1) {
      $sumber_genangan = 'Limpasan air hujan';
    }

    $panjang_total_drainase = $sheet->getCell('R19')->getValue();
    $kebutuhan_drainase_baru = $sheet->getCell('R19')->getValue() ==  1 ? 'Ya' : 'Tidak';
    $panjang_drainase_baru = $sheet->getCell('R19')->getValue();
    $panjang_drainase_konsdisi_baik = $sheet->getCell('R19')->getValue();

    $b3Model = new B3Model();
    $updateData = [
      'tinggi_genangan' => $tinggi_genangan,
      'durasi_genangan' => $durasi_genangan,
      'frekuensi_genangan' => $frekuensi_genangan,
      'luas_area_genangan' => $luas_area_genangan,
      'sumber_genangan' => $sumber_genangan,
      'panjang_total_drainase' => $panjang_total_drainase,
      'kebutuhan_drainase_baru' => $kebutuhan_drainase_baru,
      'panjang_drainase_baru' => $panjang_drainase_baru,
      'panjang_drainase_konsdisi_baik' => $panjang_drainase_konsdisi_baik,
    ];

    // If no rows were updated, perform an insert
    if ($b3Model->where('id_rt', $idRT)->first()) {
      $b3Model->where('id_rt', $idRT)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_rt' => $idRT,
        'tinggi_genangan' => $tinggi_genangan,
        'durasi_genangan' => $durasi_genangan,
        'frekuensi_genangan' => $frekuensi_genangan,
        'luas_area_genangan' => $luas_area_genangan,
        'sumber_genangan' => $sumber_genangan,
        'panjang_total_drainase' => $panjang_total_drainase,
        'kebutuhan_drainase_baru' => $kebutuhan_drainase_baru,
        'panjang_drainase_baru' => $panjang_drainase_baru,
        'panjang_drainase_konsdisi_baik' => $panjang_drainase_konsdisi_baik,
      ];

      $b3Model->insert($insertData);
    }
  }

  private function insertB4Data($sheet, $idRT)
  {
    $saluran_drainase_bercampur_limbah = $sheet->getCell('AK19')->getValue() ==  1 ? 'Ya' : 'Tidak';

    $b4Model = new B4Model();
    $updateData = [
      'saluran_drainase_bercampur_limbah' => $saluran_drainase_bercampur_limbah,
    ];

    // If no rows were updated, perform an insert
    if ($b4Model->where('id_rt', $idRT)->first()) {
      $b4Model->where('id_rt', $idRT)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_rt' => $idRT,
        'saluran_drainase_bercampur_limbah' => $saluran_drainase_bercampur_limbah,
      ];

      $b4Model->insert($insertData);
    }
  }

  private function insertB5Data($sheet, $idRT)
  {
    $prasarana_sampah = $sheet->getCell('B28')->getValue() ==  1 ? 'Ya' : 'Tidak';
    $pengangkutan_sampah = $sheet->getCell('D28')->getValue() ==  1 ? 'Ya' : 'Tidak';

    $b5Model = new B5Model();
    $updateData = [
      'prasarana_sampah' => $prasarana_sampah,
      'pengangkutan_sampah' => $pengangkutan_sampah,
    ];

    // If no rows were updated, perform an insert
    if ($b5Model->where('id_rt', $idRT)->first()) {
      $b5Model->where('id_rt', $idRT)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_rt' => $idRT,
        'prasarana_sampah' => $prasarana_sampah,
        'pengangkutan_sampah' => $pengangkutan_sampah,
      ];

      $b5Model->insert($insertData);
    }
  }

  private function insertB6Data($sheet, $idRT)
  {
    if ($sheet->getCell('F28')->getValue() ==  1) {
      $kejadian_kebakaran = '1-2 kali dalam 5 tahun';
    } elseif ($sheet->getCell('H28')->getValue() ==  1) {
      $kejadian_kebakaran = '>2 kali dalam 5 tahun';
    } else $kejadian_kebakaran = 'Tidak pernah terjadi kebakaran dalam 5 tahun';

    if ($sheet->getCell('J28')->getValue() ==  1) {
      $penyebab_kejadian_kebakaran = 'Tungku/ kompor masak';
    } elseif ($sheet->getCell('K28')->getValue() ==  1) {
      $penyebab_kejadian_kebakaran = 'Konsleting Listrik';
    } elseif ($sheet->getCell('L28')->getValue() ==  1) {
      $penyebab_kejadian_kebakaran = 'Kebakaran hutan/ ilalang';
    } elseif ($sheet->getCell('M28')->getValue() ==  1) {
      $penyebab_kejadian_kebakaran = 'Pembakaran sampah';
    } else $penyebab_kejadian_kebakaran = 'Lainnya';

    if ($sheet->getCell('O28')->getValue() ==  1) {
      $sapras_pecegahan = 'Pos/ Stasiun Pemadam Kebakaran';
    } elseif ($sheet->getCell('P28')->getValue() ==  1) {
      $sapras_pecegahan = 'Hidran air/Tangki Air/sumber air lain yang terbuka';
    } elseif ($sheet->getCell('Q28')->getValue() ==  1) {
      $sapras_pecegahan = 'Mobil/ Motor Damkar/APAR';
    } else $sapras_pecegahan = 'Tidak ada';

    $ketersediaan_jalan = $sheet->getCell('S28')->getValue() ==  1 ? 'Ya' : 'Tidak';

    $b6Model = new B6Model();
    $updateData = [
      'kejadian_kebakaran' => $kejadian_kebakaran,
      'penyebab_kejadian_kebakaran' => $penyebab_kejadian_kebakaran,
      'sapras_pecegahan' => $sapras_pecegahan,
      'ketersediaan_jalan' => $ketersediaan_jalan,
    ];

    // If no rows were updated, perform an insert
    if ($b6Model->where('id_rt', $idRT)->first()) {
      $b6Model->where('id_rt', $idRT)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_rt' => $idRT,
        'kejadian_kebakaran' => $kejadian_kebakaran,
        'penyebab_kejadian_kebakaran' => $penyebab_kejadian_kebakaran,
        'sapras_pecegahan' => $sapras_pecegahan,
        'ketersediaan_jalan' => $ketersediaan_jalan,
      ];

      $b6Model->insert($insertData);
    }
  }

  private function insertB7Data($sheet, $idRT)
  {
    $rumah_sakit = $sheet->getCell('U28')->getValue();
    $praktek_dokter = $sheet->getCell('V28')->getValue();
    $puskesmas = $sheet->getCell('W28')->getValue();
    $dukun = $sheet->getCell('X28')->getValue();
    $bidan = $sheet->getCell('Y28')->getValue();
    $tidak_ada_faskes = $sheet->getCell('Z28')->getValue();
    $tk = $sheet->getCell('AA28')->getValue();
    $sd = $sheet->getCell('AB28')->getValue();
    $smp = $sheet->getCell('AC28')->getValue();
    $sma = $sheet->getCell('AD28')->getValue();
    $kampus = $sheet->getCell('AE28')->getValue();
    $tidak_ada_sekolah = $sheet->getCell('AF28')->getValue();

    $b7Model = new B7Model();
    $updateData = [
      'rumah_sakit' => $rumah_sakit,
      'praktek_dokter' => $praktek_dokter,
      'puskesmas' => $puskesmas,
      'dukun' => $dukun,
      'bidan' => $bidan,
      'tidak_ada_faskes' => $tidak_ada_faskes,
      'tk' => $tk,
      'sd' => $sd,
      'smp' => $smp,
      'sma' => $sma,
      'kampus' => $kampus,
      'tidak_ada_sekolah' => $tidak_ada_sekolah,
    ];

    // If no rows were updated, perform an insert
    if ($b7Model->where('id_rt', $idRT)->first()) {
      $b7Model->where('id_rt', $idRT)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_rt' => $idRT,
        'rumah_sakit' => $rumah_sakit,
        'praktek_dokter' => $praktek_dokter,
        'puskesmas' => $puskesmas,
        'dukun' => $dukun,
        'bidan' => $bidan,
        'tidak_ada_faskes' => $tidak_ada_faskes,
        'tk' => $tk,
        'sd' => $sd,
        'smp' => $smp,
        'sma' => $sma,
        'kampus' => $kampus,
        'tidak_ada_sekolah' => $tidak_ada_sekolah,
      ];

      $b7Model->insert($insertData);
    }
  }

  private function insertB8Data($sheet, $idRT)
  {
    $lokasi_strategis = $sheet->getCell('B28')->getValue() ==  1 ? 'Lokasi Berada pada fungsi strategis Kab/Kota' : 'Lokasi Tidak Berada pada fungsi strategis Kab/Kota';
    $lokasi_potensi = $sheet->getCell('D28')->getValue() ==  1 ? 'Ya' : 'Tidak';

    $b8Model = new B8Model();
    $updateData = [
      'lokasi_strategis' => $lokasi_strategis,
      'lokasi_potensi' => $lokasi_potensi,
    ];

    // If no rows were updated, perform an insert
    if ($b8Model->where('id_rt', $idRT)->first()) {
      $b8Model->where('id_rt', $idRT)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_rt' => $idRT,
        'lokasi_strategis' => $lokasi_strategis,
        'lokasi_potensi' => $lokasi_potensi,
      ];

      $b8Model->insert($insertData);
    }
  }

  private function insertRekapRTData($sheet, $idRT)
  {
    $jumlah_keteraturan = $sheet->getCell('D18')->getFormattedValue();
    $persentase_keteraturan = $sheet->getCell('D19')->getFormattedValue();
    $luas_permukiman = $sheet->getCell('D20')->getFormattedValue();
    $jumlah_bangunan = $sheet->getCell('D21')->getFormattedValue();
    $tingkat_kepadatan = $sheet->getCell('D22')->getFormattedValue();
    $luas_area_padat = $sheet->getCell('D23')->getFormattedValue();
    $jumlah_bangunan_7m = $sheet->getCell('D24')->getFormattedValue();
    $persentase_bangunan_7m = $sheet->getCell('D25')->getFormattedValue();
    $jumlah_bangunan_sesuai = $sheet->getCell('D26')->getFormattedValue();
    $persentase_bangunan_sesuai = $sheet->getCell('D27')->getFormattedValue();
    $panjang_total_jalan = $sheet->getCell('D28')->getFormattedValue();
    $panjang_jalan_lingkungan = $sheet->getCell('D29')->getFormattedValue();
    $panjang_jalan_diperkeras = $sheet->getCell('D30')->getFormattedValue();
    $panjangan_kebutuhan_jalan_baru = $sheet->getCell('D31')->getFormattedValue();
    $persentase_jalan_baru = $sheet->getCell('D32')->getFormattedValue();
    $panjang_jalan_ideal = $sheet->getCell('D33')->getFormattedValue();
    $jangkauan_jaringan_jalan = $sheet->getCell('D34')->getFormattedValue();
    $panjang_jalan_15_tidak_rusak = $sheet->getCell('D35')->getFormattedValue();
    $panjang_jalan_15_tanah = $sheet->getCell('D36')->getFormattedValue();
    $panjang_jalan_kurang_tidak_rusak = $sheet->getCell('D37')->getFormattedValue();
    $panjang_jalan_kurang_tanah = $sheet->getCell('D38')->getFormattedValue();
    $panjang_jalan_15_samping = $sheet->getCell('D39')->getFormattedValue();
    $panjang_jalan_kurang_samping = $sheet->getCell('D40')->getFormattedValue();
    $total_jalan_tidak_rusak = $sheet->getCell('D41')->getFormattedValue();
    $jalan_sesuai_teknis = $sheet->getCell('D42')->getFormattedValue();
    $luas_area_tidak_banjir = $sheet->getCell('D43')->getFormattedValue();
    $persentase_tidak_banjir = $sheet->getCell('D44')->getFormattedValue();
    $panjang_drainase = $sheet->getCell('D45')->getFormattedValue();
    $kebutuhan_darinase = $sheet->getCell('D46')->getFormattedValue();
    $persentase_kebutuhan_drainase = $sheet->getCell('D47')->getFormattedValue();
    $panjang_drainase_ideal = $sheet->getCell('D50')->getFormattedValue();
    $panjang_drainase_bersih = $sheet->getCell('D51')->getFormattedValue();
    $persentase_drainase_bersih = $sheet->getCell('D52')->getFormattedValue();
    $panjang_drainase_baik = $sheet->getCell('D53')->getFormattedValue();
    $persentase_drainase_baik = $sheet->getCell('D54')->getFormattedValue();
    $jumlah_air_minum = $sheet->getCell('D55')->getFormattedValue();
    $persentase_air_minum = $sheet->getCell('D56')->getFormattedValue();
    $jumlah_terpenuhi = $sheet->getCell('D57')->getFormattedValue();
    $persentase_terpenuhi = $sheet->getCell('D58')->getFormattedValue();
    $jumlah_akses_jamban = $sheet->getCell('D59')->getFormattedValue();
    $persentase_akses_jamban = $sheet->getCell('D60')->getFormattedValue();
    $jumlah_jamban_sesuai = $sheet->getCell('D61')->getFormattedValue();
    $persentase_jamban_sesuai = $sheet->getCell('D62')->getFormattedValue();
    $saluran_pembuangan_air = $sheet->getCell('D63')->getFormattedValue();
    $jumlah_sarana_sesuai = $sheet->getCell('D64')->getFormattedValue();
    $persentase_sarana_sesuai = $sheet->getCell('D65')->getFormattedValue();
    $jumlah_sampah = $sheet->getCell('D66')->getFormattedValue();
    $persentase_sampah = $sheet->getCell('D67')->getFormattedValue();
    $jumlah_sarana_baik = $sheet->getCell('D68')->getFormattedValue();
    $persentase_sarana_baik = $sheet->getCell('D69')->getFormattedValue();
    $jumlah_proteksi_kebakaran = $sheet->getCell('D70')->getFormattedValue();
    $persentase_proteksi_kebakaran = $sheet->getCell('D71')->getFormattedValue();
    $jumlah_sarana_proteksi_kebakaran = $sheet->getCell('D72')->getFormattedValue();
    $persentase_sarana_proteksi_kebakaran = $sheet->getCell('D73')->getFormattedValue();

    $rekapRTModel = new RekapRTModel();
    $updateData = [
      'jumlah_keteraturan' => $jumlah_keteraturan,
      'persentase_keteraturan' => $persentase_keteraturan,
      'luas_permukiman' => $luas_permukiman,
      'jumlah_bangunan' => $jumlah_bangunan,
      'tingkat_kepadatan' => $tingkat_kepadatan,
      'luas_area_padat' => $luas_area_padat,
      'jumlah_bangunan_7m' => $jumlah_bangunan_7m,
      'persentase_bangunan_7m' => $persentase_bangunan_7m,
      'jumlah_bangunan_sesuai' => $jumlah_bangunan_sesuai,
      'persentase_bangunan_sesuai' => $persentase_bangunan_sesuai,
      'panjang_total_jalan' => $panjang_total_jalan,
      'panjang_jalan_lingkungan' => $panjang_jalan_lingkungan,
      'panjang_jalan_diperkeras' => $panjang_jalan_diperkeras,
      'panjangan_kebutuhan_jalan_baru' => $panjangan_kebutuhan_jalan_baru,
      'persentase_jalan_baru' => $persentase_jalan_baru,
      'panjang_jalan_ideal' => $panjang_jalan_ideal,
      'jangkauan_jaringan_jalan' => $jangkauan_jaringan_jalan,
      'panjang_jalan_15_tidak_rusak' => $panjang_jalan_15_tidak_rusak,
      'panjang_jalan_15_tanah' => $panjang_jalan_15_tanah,
      'panjang_jalan_kurang_tidak_rusak' => $panjang_jalan_kurang_tidak_rusak,
      'panjang_jalan_kurang_tanah' => $panjang_jalan_kurang_tanah,
      'panjang_jalan_15_samping' => $panjang_jalan_15_samping,
      'panjang_jalan_kurang_samping' => $panjang_jalan_kurang_samping,
      'total_jalan_tidak_rusak' => $total_jalan_tidak_rusak,
      'jalan_sesuai_teknis' => $jalan_sesuai_teknis,
      'luas_area_tidak_banjir' => $luas_area_tidak_banjir,
      'persentase_tidak_banjir' => $persentase_tidak_banjir,
      'panjang_drainase' => $panjang_drainase,
      'kebutuhan_darinase' => $kebutuhan_darinase,
      'persentase_kebutuhan_drainase' => $persentase_kebutuhan_drainase,
      'panjang_drainase_ideal' => $panjang_drainase_ideal,
      'panjang_drainase_bersih' => $panjang_drainase_bersih,
      'persentase_drainase_bersih' => $persentase_drainase_bersih,
      'panjang_drainase_baik' => $panjang_drainase_baik,
      'persentase_drainase_baik' => $persentase_drainase_baik,
      'jumlah_air_minum' => $jumlah_air_minum,
      'persentase_air_minum' => $persentase_air_minum,
      'jumlah_terpenuhi' => $jumlah_terpenuhi,
      'persentase_terpenuhi' => $persentase_terpenuhi,
      'jumlah_akses_jamban' => $jumlah_akses_jamban,
      'persentase_akses_jamban' => $persentase_akses_jamban,
      'jumlah_jamban_sesuai' => $jumlah_jamban_sesuai,
      'persentase_jamban_sesuai' => $persentase_jamban_sesuai,
      'saluran_pembuangan_air' => $saluran_pembuangan_air,
      'jumlah_sarana_sesuai' => $jumlah_sarana_sesuai,
      'persentase_sarana_sesuai' => $persentase_sarana_sesuai,
      'jumlah_sampah' => $jumlah_sampah,
      'persentase_sampah' => $persentase_sampah,
      'jumlah_sarana_baik' => $jumlah_sarana_baik,
      'persentase_sarana_baik' => $persentase_sarana_baik,
      'jumlah_proteksi_kebakaran' => $jumlah_proteksi_kebakaran,
      'persentase_proteksi_kebakaran' => $persentase_proteksi_kebakaran,
      'jumlah_sarana_proteksi_kebakaran' => $jumlah_sarana_proteksi_kebakaran,
      'persentase_sarana_proteksi_kebakaran' => $persentase_sarana_proteksi_kebakaran,
    ];

    // If no rows were updated, perform an insert
    if ($rekapRTModel->where('id_rt', $idRT)->first()) {
      $rekapRTModel->where('id_rt', $idRT)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_rt' => $idRT,
        'jumlah_keteraturan' => $jumlah_keteraturan,
        'persentase_keteraturan' => $persentase_keteraturan,
        'luas_permukiman' => $luas_permukiman,
        'jumlah_bangunan' => $jumlah_bangunan,
        'tingkat_kepadatan' => $tingkat_kepadatan,
        'luas_area_padat' => $luas_area_padat,
        'jumlah_bangunan_7m' => $jumlah_bangunan_7m,
        'persentase_bangunan_7m' => $persentase_bangunan_7m,
        'jumlah_bangunan_sesuai' => $jumlah_bangunan_sesuai,
        'persentase_bangunan_sesuai' => $persentase_bangunan_sesuai,
        'panjang_total_jalan' => $panjang_total_jalan,
        'panjang_jalan_lingkungan' => $panjang_jalan_lingkungan,
        'panjang_jalan_diperkeras' => $panjang_jalan_diperkeras,
        'panjangan_kebutuhan_jalan_baru' => $panjangan_kebutuhan_jalan_baru,
        'persentase_jalan_baru' => $persentase_jalan_baru,
        'panjang_jalan_ideal' => $panjang_jalan_ideal,
        'jangkauan_jaringan_jalan' => $jangkauan_jaringan_jalan,
        'panjang_jalan_15_tidak_rusak' => $panjang_jalan_15_tidak_rusak,
        'panjang_jalan_15_tanah' => $panjang_jalan_15_tanah,
        'panjang_jalan_kurang_tidak_rusak' => $panjang_jalan_kurang_tidak_rusak,
        'panjang_jalan_kurang_tanah' => $panjang_jalan_kurang_tanah,
        'panjang_jalan_15_samping' => $panjang_jalan_15_samping,
        'panjang_jalan_kurang_samping' => $panjang_jalan_kurang_samping,
        'total_jalan_tidak_rusak' => $total_jalan_tidak_rusak,
        'jalan_sesuai_teknis' => $jalan_sesuai_teknis,
        'luas_area_tidak_banjir' => $luas_area_tidak_banjir,
        'persentase_tidak_banjir' => $persentase_tidak_banjir,
        'panjang_drainase' => $panjang_drainase,
        'kebutuhan_darinase' => $kebutuhan_darinase,
        'persentase_kebutuhan_drainase' => $persentase_kebutuhan_drainase,
        'panjang_drainase_ideal' => $panjang_drainase_ideal,
        'panjang_drainase_bersih' => $panjang_drainase_bersih,
        'persentase_drainase_bersih' => $persentase_drainase_bersih,
        'panjang_drainase_baik' => $panjang_drainase_baik,
        'persentase_drainase_baik' => $persentase_drainase_baik,
        'jumlah_air_minum' => $jumlah_air_minum,
        'persentase_air_minum' => $persentase_air_minum,
        'jumlah_terpenuhi' => $jumlah_terpenuhi,
        'persentase_terpenuhi' => $persentase_terpenuhi,
        'jumlah_akses_jamban' => $jumlah_akses_jamban,
        'persentase_akses_jamban' => $persentase_akses_jamban,
        'jumlah_jamban_sesuai' => $jumlah_jamban_sesuai,
        'persentase_jamban_sesuai' => $persentase_jamban_sesuai,
        'saluran_pembuangan_air' => $saluran_pembuangan_air,
        'jumlah_sarana_sesuai' => $jumlah_sarana_sesuai,
        'persentase_sarana_sesuai' => $persentase_sarana_sesuai,
        'jumlah_sampah' => $jumlah_sampah,
        'persentase_sampah' => $persentase_sampah,
        'jumlah_sarana_baik' => $jumlah_sarana_baik,
        'persentase_sarana_baik' => $persentase_sarana_baik,
        'jumlah_proteksi_kebakaran' => $jumlah_proteksi_kebakaran,
        'persentase_proteksi_kebakaran' => $persentase_proteksi_kebakaran,
        'jumlah_sarana_proteksi_kebakaran' => $jumlah_sarana_proteksi_kebakaran,
        'persentase_sarana_proteksi_kebakaran' => $persentase_sarana_proteksi_kebakaran,
      ];

      $rekapRTModel->insert($insertData);
    }
  }

  private function insertRekapRTNonData($sheet, $idRT)
  {

    $jumlah_imb = $sheet->getCell('D76')->getFormattedValue();
    $persentase_imb = $sheet->getCell('D77')->getFormattedValue();
    $jumlah_shm = $sheet->getCell('D78')->getFormattedValue();
    $persentase_shm = $sheet->getCell('D79')->getFormattedValue();
    $kepadatan_penduduk = $sheet->getCell('D80')->getFormattedValue();
    $jumlah_penduduk = $sheet->getCell('D81')->getFormattedValue();
    $luas_rt = $sheet->getCell('D82')->getFormattedValue();
    $pertanian = $sheet->getCell('D83')->getFormattedValue();
    $perikanan = $sheet->getCell('D84')->getFormattedValue();
    $pertambangan = $sheet->getCell('D85')->getFormattedValue();
    $industri = $sheet->getCell('D86')->getFormattedValue();
    $kontruksi = $sheet->getCell('D87')->getFormattedValue();
    $perdagangan = $sheet->getCell('D88')->getFormattedValue();
    $pns = $sheet->getCell('D89')->getFormattedValue();
    $listrik_450 = $sheet->getCell('D90')->getFormattedValue();
    $listrik_900 = $sheet->getCell('D91')->getFormattedValue();
    $listrik_1300 = $sheet->getCell('D92')->getFormattedValue();
    $listrik_2200 = $sheet->getCell('D93')->getFormattedValue();
    $menumpang = $sheet->getCell('D94')->getFormattedValue();
    $rs = $sheet->getCell('D95')->getFormattedValue();
    $dokter = $sheet->getCell('D96')->getFormattedValue();
    $puskesmas = $sheet->getCell('D97')->getFormattedValue();
    $dukun = $sheet->getCell('D98')->getFormattedValue();
    $bidan = $sheet->getCell('D99')->getFormattedValue();
    $tidak_pernah = $sheet->getCell('D100')->getFormattedValue();
    $dalam_kelurahan = $sheet->getCell('D101')->getFormattedValue();
    $luar_kecamatan = $sheet->getCell('D102')->getFormattedValue();
    $kota_lain = $sheet->getCell('D103')->getFormattedValue();
    $tidak_ada_sekolah = $sheet->getCell('D104')->getFormattedValue();
    $tidak_ada_anggota = $sheet->getCell('D105')->getFormattedValue();
    $strategis = $sheet->getCell('D106')->getFormattedValue();
    $tidak_strategis = $sheet->getCell('D107')->getFormattedValue();
    $potensial = $sheet->getCell('D108')->getFormattedValue();
    $tidak_potensial = $sheet->getCell('D109')->getFormattedValue();

    $rekapRTNonModel = new RekapRTNonModel();
    $updateData = [
      'jumlah_imb' => $jumlah_imb,
      'persentase_imb' => $persentase_imb,
      'jumlah_shm' => $jumlah_shm,
      'persentase_shm' => $persentase_shm,
      'kepadatan_penduduk' => $kepadatan_penduduk,
      'jumlah_penduduk' => $jumlah_penduduk,
      'luas_rt' => $luas_rt,
      'pertanian' => $pertanian,
      'perikanan' => $perikanan,
      'pertambangan' => $pertambangan,
      'industri' => $industri,
      'kontruksi' => $kontruksi,
      'perdagangan' => $perdagangan,
      'pns' => $pns,
      'listrik_450' => $listrik_450,
      'listrik_900' => $listrik_900,
      'listrik_1300' => $listrik_1300,
      'listrik_2200' => $listrik_2200,
      'menumpang' => $menumpang,
      'rs' => $rs,
      'dokter' => $dokter,
      'puskesmas' => $puskesmas,
      'dukun' => $dukun,
      'bidan' => $bidan,
      'tidak_pernah' => $tidak_pernah,
      'dalam_kelurahan' => $dalam_kelurahan,
      'luar_kecamatan' => $luar_kecamatan,
      'kota_lain' => $kota_lain,
      'tidak_ada_sekolah' => $tidak_ada_sekolah,
      'tidak_ada_anggota' => $tidak_ada_anggota,
      'strategis' => $strategis,
      'tidak_strategis' => $tidak_strategis,
      'potensial' => $potensial,
      'tidak_potensial' => $tidak_potensial,
    ];

    // If no rows were updated, perform an insert
    if ($rekapRTNonModel->where('id_rt', $idRT)->first()) {
      $rekapRTNonModel->where('id_rt', $idRT)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_rt' => $idRT,
        'jumlah_imb' => $jumlah_imb,
        'persentase_imb' => $persentase_imb,
        'jumlah_shm' => $jumlah_shm,
        'persentase_shm' => $persentase_shm,
        'kepadatan_penduduk' => $kepadatan_penduduk,
        'jumlah_penduduk' => $jumlah_penduduk,
        'luas_rt' => $luas_rt,
        'pertanian' => $pertanian,
        'perikanan' => $perikanan,
        'pertambangan' => $pertambangan,
        'industri' => $industri,
        'kontruksi' => $kontruksi,
        'perdagangan' => $perdagangan,
        'pns' => $pns,
        'listrik_450' => $listrik_450,
        'listrik_900' => $listrik_900,
        'listrik_1300' => $listrik_1300,
        'listrik_2200' => $listrik_2200,
        'menumpang' => $menumpang,
        'rs' => $rs,
        'dokter' => $dokter,
        'puskesmas' => $puskesmas,
        'dukun' => $dukun,
        'bidan' => $bidan,
        'tidak_pernah' => $tidak_pernah,
        'dalam_kelurahan' => $dalam_kelurahan,
        'luar_kecamatan' => $luar_kecamatan,
        'kota_lain' => $kota_lain,
        'tidak_ada_sekolah' => $tidak_ada_sekolah,
        'tidak_ada_anggota' => $tidak_ada_anggota,
        'strategis' => $strategis,
        'tidak_strategis' => $tidak_strategis,
        'potensial' => $potensial,
        'tidak_potensial' => $tidak_potensial,
      ];

      $rekapRTNonModel->insert($insertData);
    }
  }

  private function insertKekumuhanAwal($sheet, $idRT)
  {
    $ketidakteraturan_bangunan = $sheet->getCell('F14')->getFormattedValue();
    $persentase_ketidakteraturan_bangunan = $sheet->getCell('E14')->getFormattedValue();
    $kepadatan_penduduk = $sheet->getCell('F15')->getFormattedValue();
    $persentase_kepadatan_penduduk = $sheet->getCell('E15')->getFormattedValue();
    $ketidaksesuaian_persyaratan = $sheet->getCell('F16')->getFormattedValue();
    $persentase_ketidaksesuaian_persyaratan = $sheet->getCell('E16')->getFormattedValue();
    $rata_kondisi_gedung = $sheet->getCell('E17')->getFormattedValue();
    $cakupan_jalan = $sheet->getCell('F18')->getFormattedValue();
    $persentase_cakupan_jalan = $sheet->getCell('E18')->getFormattedValue();
    $kualitas_jalan = $sheet->getCell('F19')->getFormattedValue();
    $persentase_kualitas_jalan = $sheet->getCell('E19')->getFormattedValue();
    $rata_jalan = $sheet->getCell('E20')->getFormattedValue();
    $akses_air_minum = $sheet->getCell('F21')->getFormattedValue();
    $persentase_akses_air_minum = $sheet->getCell('E21')->getFormattedValue();
    $tidak_terpenuhi_air_minum = $sheet->getCell('F22')->getFormattedValue();
    $persentase_tidak_terpenuhi_air_minum = $sheet->getCell('E22')->getFormattedValue();
    $rata_kondisi_air_minum = $sheet->getCell('E23')->getFormattedValue();
    $limpasan_air = $sheet->getCell('F24')->getFormattedValue();
    $persentase_limpasan_air = $sheet->getCell('E24')->getFormattedValue();
    $tidak_drainase = $sheet->getCell('F25')->getFormattedValue();
    $persentase_tidak_drainase = $sheet->getCell('E25')->getFormattedValue();
    $kualitas_drainase = $sheet->getCell('F26')->getFormattedValue();
    $persentase_kualitas_drainase = $sheet->getCell('E26')->getFormattedValue();
    $rata_drainase = $sheet->getCell('E27')->getFormattedValue();
    $air_limbah = $sheet->getCell('F28')->getFormattedValue();
    $persentase_air_limbah = $sheet->getCell('E28')->getFormattedValue();
    $sarana_air_limbah = $sheet->getCell('F29')->getFormattedValue();
    $persentase_sarana_air_limbah = $sheet->getCell('E29')->getFormattedValue();
    $rata_air_limbah = $sheet->getCell('E30')->getFormattedValue();
    $sarana_sampah = $sheet->getCell('F31')->getFormattedValue();
    $persentase_sarana_sampah = $sheet->getCell('E31')->getFormattedValue();
    $pengelolaan_sampah = $sheet->getCell('F32')->getFormattedValue();
    $persentase_pengelolaan_sampah = $sheet->getCell('E32')->getFormattedValue();
    $rata_pengelolaan_sampah = $sheet->getCell('E33')->getFormattedValue();
    $prasarana_kebakaran = $sheet->getCell('F34')->getFormattedValue();
    $persentase_prasarana_kebakaran = $sheet->getCell('E34')->getFormattedValue();
    $sarana_kebakaran = $sheet->getCell('F35')->getFormattedValue();
    $persentase_sarana_kebakaran = $sheet->getCell('E35')->getFormattedValue();
    $rata_kebakaran = $sheet->getCell('E36')->getFormattedValue();

    // Check if the cell is part of a merged range
    $mergeRange = $sheet->getMergeCells();
    if (isset($mergeRange['F37'])) {
      // Cell is part of a merged range

      // Get the top-left cell of the merged range
      $mergedCell = $sheet->getCell(explode(':', $mergeRange['F37'])[0]);

      // Retrieve the value from the top-left cell
      $total_nilai = $mergedCell->getFormattedValue();

      // Now, $mergedValue contains the value from the merged cell
    } else {
      // Cell is not part of a merged range
      $total_nilai = $sheet->getCell('F37')->getFormattedValue();
    }

    // $total_nilai = $sheet->getCell('F38')->getFormattedValue();
    // $tingkat_kekumuhan = $sheet->getCell('F40')->getFormattedValue();

    if (isset($mergeRange['F39'])) {
      // Cell is part of a merged range

      // Get the top-left cell of the merged range
      $mergedCell = $sheet->getCell(explode(':', $mergeRange['F39'])[0]);

      // Retrieve the value from the top-left cell
      $tingkat_kekumuhan = $mergedCell->getFormattedValue();

      // Now, $mergedValue contains the value from the merged cell
    } else {
      // Cell is not part of a merged range
      $tingkat_kekumuhan = $sheet->getCell('F39')->getFormattedValue();
    }

    $kekumuhan_sektoral = $sheet->getCell('F41')->getFormattedValue();
    $penanganan = $sheet->getCell('F42')->getFormattedValue();

    $volume_ketidakteraturan_bangunan = $sheet->getCell('C14')->getFormattedValue();
    $volume_kepadatan_penduduk = $sheet->getCell('C15')->getFormattedValue();
    $volume_ketidaksesuaian_persyaratan = $sheet->getCell('C16')->getFormattedValue();
    $volume_cakupan_jalan = $sheet->getCell('C18')->getFormattedValue();
    $volume_kualitas_jalan = $sheet->getCell('C19')->getFormattedValue();
    $volume_akses_air_minum = $sheet->getCell('C21')->getFormattedValue();
    $volume_tidak_terpenuhi_air_minum = $sheet->getCell('C22')->getFormattedValue();
    $volume_limpasan_air = $sheet->getCell('C24')->getFormattedValue();
    $volume_tidak_drainase = $sheet->getCell('C25')->getFormattedValue();
    $volume_kualitas_drainase = $sheet->getCell('C26')->getFormattedValue();
    $volume_air_limbah = $sheet->getCell('C28')->getFormattedValue();
    $volume_sarana_air_limbah = $sheet->getCell('C29')->getFormattedValue();
    $volume_sarana_sampah = $sheet->getCell('C31')->getFormattedValue();
    $volume_pengelolaan_sampah = $sheet->getCell('C32')->getFormattedValue();
    $volume_prasarana_kebakaran = $sheet->getCell('C34')->getFormattedValue();
    $volume_sarana_kebakaran = $sheet->getCell('C35')->getFormattedValue();

    $kekumuhanAwalModel = new KekumuhanAwalModel();
    $updateData = [
      'ketidakteraturan_bangunan' =>  $ketidakteraturan_bangunan,
      'persentase_ketidakteraturan_bangunan' =>  $persentase_ketidakteraturan_bangunan,
      'kepadatan_penduduk' =>  $kepadatan_penduduk,
      'persentase_kepadatan_penduduk' =>  $persentase_kepadatan_penduduk,
      'ketidaksesuaian_persyaratan' =>  $ketidaksesuaian_persyaratan,
      'persentase_ketidaksesuaian_persyaratan' =>  $persentase_ketidaksesuaian_persyaratan,
      'rata_kondisi_gedung' =>  $rata_kondisi_gedung,
      'cakupan_jalan' =>  $cakupan_jalan,
      'persentase_cakupan_jalan' =>  $persentase_cakupan_jalan,
      'kualitas_jalan' =>  $kualitas_jalan,
      'persentase_kualitas_jalan' =>  $persentase_kualitas_jalan,
      'rata_jalan' =>  $rata_jalan,
      'akses_air_minum' =>  $akses_air_minum,
      'persentase_akses_air_minum' =>  $persentase_akses_air_minum,
      'tidak_terpenuhi_air_minum' =>  $tidak_terpenuhi_air_minum,
      'persentase_tidak_terpenuhi_air_minum' =>  $persentase_tidak_terpenuhi_air_minum,
      'rata_kondisi_air_minum' =>  $rata_kondisi_air_minum,
      'limpasan_air' =>  $limpasan_air,
      'persentase_limpasan_air' =>  $persentase_limpasan_air,
      'tidak_drainase' =>  $tidak_drainase,
      'persentase_tidak_drainase' =>  $persentase_tidak_drainase,
      'kualitas_drainase' =>  $kualitas_drainase,
      'persentase_kualitas_drainase' =>  $persentase_kualitas_drainase,
      'rata_drainase' =>  $rata_drainase,
      'air_limbah' =>  $air_limbah,
      'persentase_air_limbah' =>  $persentase_air_limbah,
      'sarana_air_limbah' =>  $sarana_air_limbah,
      'persentase_sarana_air_limbah' =>  $persentase_sarana_air_limbah,
      'rata_air_limbah' =>  $rata_air_limbah,
      'sarana_sampah' =>  $sarana_sampah,
      'persentase_sarana_sampah' =>  $persentase_sarana_sampah,
      'pengelolaan_sampah' =>  $pengelolaan_sampah,
      'persentase_pengelolaan_sampah' =>  $persentase_pengelolaan_sampah,
      'rata_pengelolaan_sampah' =>  $rata_pengelolaan_sampah,
      'prasarana_kebakaran' =>  $prasarana_kebakaran,
      'persentase_prasarana_kebakaran' =>  $persentase_prasarana_kebakaran,
      'sarana_kebakaran' =>  $sarana_kebakaran,
      'persentase_sarana_kebakaran' =>  $persentase_sarana_kebakaran,
      'rata_kebakaran' =>  $rata_kebakaran,
      'total_nilai' =>  $total_nilai,
      'tingkat_kekumuhan' =>  $tingkat_kekumuhan,
      'kekumuhan_sektoral' =>  $kekumuhan_sektoral,
      'penanganan' =>  $penanganan,
      'volume_ketidakteraturan_bangunan' => $volume_ketidakteraturan_bangunan,
      'volume_kepadatan_penduduk' => $volume_kepadatan_penduduk,
      'volume_ketidaksesuaian_persyaratan' => $volume_ketidaksesuaian_persyaratan,
      'volume_cakupan_jalan' => $volume_cakupan_jalan,
      'volume_kualitas_jalan' => $volume_kualitas_jalan,
      'volume_akses_air_minum' => $volume_akses_air_minum,
      'volume_tidak_terpenuhi_air_minum' => $volume_tidak_terpenuhi_air_minum,
      'volume_limpasan_air' => $volume_limpasan_air,
      'volume_tidak_drainase' => $volume_tidak_drainase,
      'volume_kualitas_drainase' => $volume_kualitas_drainase,
      'volume_air_limbah' => $volume_air_limbah,
      'volume_sarana_air_limbah' => $volume_sarana_air_limbah,
      'volume_sarana_sampah' => $volume_sarana_sampah,
      'volume_pengelolaan_sampah' => $volume_pengelolaan_sampah,
      'volume_prasarana_kebakaran' => $volume_prasarana_kebakaran,
      'volume_sarana_kebakaran' => $volume_sarana_kebakaran,
    ];


    // If no rows were updated, perform an insert
    if ($kekumuhanAwalModel->where('id_rt', $idRT)->first()) {
      $kekumuhanAwalModel->where('id_rt', $idRT)
        ->set($updateData)
        ->update();
    } else {
      $insertData = [
        'id_rt' => $idRT,
        'ketidakteraturan_bangunan' =>  $ketidakteraturan_bangunan,
        'persentase_ketidakteraturan_bangunan' =>  $persentase_ketidakteraturan_bangunan,
        'kepadatan_penduduk' =>  $kepadatan_penduduk,
        'persentase_kepadatan_penduduk' =>  $persentase_kepadatan_penduduk,
        'ketidaksesuaian_persyaratan' =>  $ketidaksesuaian_persyaratan,
        'persentase_ketidaksesuaian_persyaratan' =>  $persentase_ketidaksesuaian_persyaratan,
        'rata_kondisi_gedung' =>  $rata_kondisi_gedung,
        'cakupan_jalan' =>  $cakupan_jalan,
        'persentase_cakupan_jalan' =>  $persentase_cakupan_jalan,
        'kualitas_jalan' =>  $kualitas_jalan,
        'persentase_kualitas_jalan' =>  $persentase_kualitas_jalan,
        'rata_jalan' =>  $rata_jalan,
        'akses_air_minum' =>  $akses_air_minum,
        'persentase_akses_air_minum' =>  $persentase_akses_air_minum,
        'tidak_terpenuhi_air_minum' =>  $tidak_terpenuhi_air_minum,
        'persentase_tidak_terpenuhi_air_minum' =>  $persentase_tidak_terpenuhi_air_minum,
        'rata_kondisi_air_minum' =>  $rata_kondisi_air_minum,
        'limpasan_air' =>  $limpasan_air,
        'persentase_limpasan_air' =>  $persentase_limpasan_air,
        'tidak_drainase' =>  $tidak_drainase,
        'persentase_tidak_drainase' =>  $persentase_tidak_drainase,
        'kualitas_drainase' =>  $kualitas_drainase,
        'persentase_kualitas_drainase' =>  $persentase_kualitas_drainase,
        'rata_drainase' =>  $rata_drainase,
        'air_limbah' =>  $air_limbah,
        'persentase_air_limbah' =>  $persentase_air_limbah,
        'sarana_air_limbah' =>  $sarana_air_limbah,
        'persentase_sarana_air_limbah' =>  $persentase_sarana_air_limbah,
        'rata_air_limbah' =>  $rata_air_limbah,
        'sarana_sampah' =>  $sarana_sampah,
        'persentase_sarana_sampah' =>  $persentase_sarana_sampah,
        'pengelolaan_sampah' =>  $pengelolaan_sampah,
        'persentase_pengelolaan_sampah' =>  $persentase_pengelolaan_sampah,
        'rata_pengelolaan_sampah' =>  $rata_pengelolaan_sampah,
        'prasarana_kebakaran' =>  $prasarana_kebakaran,
        'persentase_prasarana_kebakaran' =>  $persentase_prasarana_kebakaran,
        'sarana_kebakaran' =>  $sarana_kebakaran,
        'persentase_sarana_kebakaran' =>  $persentase_sarana_kebakaran,
        'rata_kebakaran' =>  $rata_kebakaran,
        'total_nilai' =>  $total_nilai,
        'tingkat_kekumuhan' =>  $tingkat_kekumuhan,
        'kekumuhan_sektoral' =>  $kekumuhan_sektoral,
        'penanganan' =>  $penanganan,
        'volume_ketidakteraturan_bangunan' => $volume_ketidakteraturan_bangunan,
        'volume_kepadatan_penduduk' => $volume_kepadatan_penduduk,
        'volume_ketidaksesuaian_persyaratan' => $volume_ketidaksesuaian_persyaratan,
        'volume_cakupan_jalan' => $volume_cakupan_jalan,
        'volume_kualitas_jalan' => $volume_kualitas_jalan,
        'volume_akses_air_minum' => $volume_akses_air_minum,
        'volume_tidak_terpenuhi_air_minum' => $volume_tidak_terpenuhi_air_minum,
        'volume_limpasan_air' => $volume_limpasan_air,
        'volume_tidak_drainase' => $volume_tidak_drainase,
        'volume_kualitas_drainase' => $volume_kualitas_drainase,
        'volume_air_limbah' => $volume_air_limbah,
        'volume_sarana_air_limbah' => $volume_sarana_air_limbah,
        'volume_sarana_sampah' => $volume_sarana_sampah,
        'volume_pengelolaan_sampah' => $volume_pengelolaan_sampah,
        'volume_prasarana_kebakaran' => $volume_prasarana_kebakaran,
        'volume_sarana_kebakaran' => $volume_sarana_kebakaran,
      ];

      $kekumuhanAwalModel->insert($insertData);
    }
  }

  private function isDataRTDuplicate($prov_id, $city_id, $dis_id, $subdis_id, $rt, $rw)
  {
    $dataRTModel = new DataRTModel();

    $existingData = $dataRTModel
      ->where('prov_id', $prov_id)
      ->where('city_id', $city_id)
      ->where('dis_id', $dis_id)
      ->where('subdis_id', $subdis_id)
      ->where('rt', $rt)
      ->where('rw', $rw)
      ->first();

    return $existingData;
  }

  private function isWargaDuplicate($idRT, $no_ktp, $nama_kk)
  {
    $wargaModel = new WargaModel();

    $existingWarga = $wargaModel
      ->where('id_rt', $idRT)
      ->where('no_ktp', $no_ktp)
      ->where('nama_kk', $nama_kk)
      ->first();

    return $existingWarga;
  }

  public function downloadFile($fileName)
  {
    $filePath = ROOTPATH . 'public/uploads/'.$fileName; // Path to the file you want to download

    return $this->response->download($filePath, null);
  }

  public function showPdf($fileName)
  {
    $filePath = ROOTPATH . 'public/uploads/'. $fileName; // Path to the PDF file

    // Check if the file exists
    if (file_exists($filePath)) {
      header('Content-Type: application/pdf');
      readfile($filePath);
      exit; // Terminate script after sending the file
    } else {
      echo 'File not found';
    }
  }

  public function uploadPeta($idRt)
  {
    $data = [
      'idRt' => $idRt
    ];
    return view('upload/upload-peta', $data);
  }

  public function storePeta($idRt)
  {
    $uploadedFiles = $this->request->getFiles();
    $file = $uploadedFiles['files'];

    $originalName = $file->getClientName();

    if (is_file(ROOTPATH . 'public/uploads/' . $originalName)) // Jika file tersebut ada
      unlink(ROOTPATH . 'public/uploads/' . $originalName); // Hapus file tersebut

    $dataRTModel = new DataRTModel();
    $dataRTModel->where('id_rt', $idRt)
    ->set([
      'peta' => $originalName,
    ])
    ->update();

    $file->move(ROOTPATH . 'public/uploads', $originalName);

    session()->setFlashdata('message', 'Upload Berhasil');

    return redirect()->to(base_url('upload/uploadPeta/'.$idRt));
  }
}