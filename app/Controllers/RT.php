<?php

namespace App\Controllers;

use App\Models\DataRTModel;
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

class Rt extends BaseController
{
  public function index()
  {
    $rtModel = new DataRTModel();
    $rtData = $rtModel
      ->select('data_rt.*, provinces.prov_name, cities.city_name, districts.dis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->groupBy('provinces.prov_name, cities.city_name, districts.dis_name')
      ->findAll(); // Fetch all records from the model

    $data = [
      'rt' => $rtData
    ];
    return view('rt/kecamatan', $data);
  }

  public function detailKecamatan($id)
  {
    $rtModel = new DataRTModel();
    $rtData = $rtModel
      ->select('data_rt.*, provinces.prov_name, cities.city_name, districts.dis_name, subdistricts.subdis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->join('subdistricts', 'data_rt.subdis_id = subdistricts.subdis_id')
      ->where('data_rt.dis_id', $id)
      ->groupBy('provinces.prov_name, cities.city_name, districts.dis_name, subdistricts.subdis_name')
      ->findAll(); // Fetch all records from the model

    $data = [
      'rt' => $rtData
    ];
    return view('rt/kelurahan', $data);
  }

  public function detailKelurahan($dis_id, $subdis_id)
  {
    $rtModel = new DataRTModel();
    $rtData = $rtModel
      ->select('data_rt.*, provinces.prov_name, cities.city_name, districts.dis_name, subdistricts.subdis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->join('subdistricts', 'data_rt.subdis_id = subdistricts.subdis_id')
      ->where('data_rt.dis_id', $dis_id)
      ->where('data_rt.subdis_id', $subdis_id)
      ->findAll(); // Fetch all records from the model

    $data = [
      'rt' => $rtData
    ];
    return view('rt/rt', $data);
  }

  public function detail($id)
  {
    //model initialize
    $rtModel = new DataRTModel();
    $rtData = $rtModel
      ->select('data_rt.*, provinces.prov_name, cities.city_name, districts.dis_name, subdistricts.subdis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->join(
        'subdistricts',
        'data_rt.subdis_id = subdistricts.subdis_id'
      )
      ->where('id_rt', $id)
      ->first();

    $wargaModel = new WargaModel();
    $wargaData = $wargaModel->where('id_rt', $id)->findAll();

    $data = [
      'rt' => $rtData,
      'warga' => $wargaData,
      'idRT' => $id,
      'fileName' => $rtData['file'],
      'petaName' => $rtData['peta'],
      'filePaths' => base_url('uploads/'. $rtData['peta']),
    ];

    return view('rt/detail', $data);
  }

  public function detailWarga($id)
  {
    //model initialize
    $a1Model = new A1Model();
    $a2Model = new A2Model();
    $a3Model = new A3Model();
    $a4Model = new A4Model();
    $a5Model = new A5Model();
    $a61Model = new A61Model();
    $a62Model = new A62Model();
    $a63Model = new A63Model();
    $a1Data = $a1Model->where('id_warga', $id)->first();
    $a2Data = $a2Model->where('id_warga', $id)->first();
    $a3Data = $a3Model->where('id_warga', $id)->first();
    $a4Data = $a4Model->where('id_warga', $id)->first();
    $a5Data = $a5Model->where('id_warga', $id)->first();
    $a61Data = $a61Model->where('id_warga', $id)->first();
    $a62Data = $a62Model->where('id_warga', $id)->first();
    $a63Data = $a63Model->where('id_warga', $id)->first();

    $wargaModel = new WargaModel();
    $wargaData = $wargaModel->where('id_warga', $id)->first();

    $data = [
      'warga' => $wargaData,
      'a1Data' => $a1Data,
      'a2Data' => $a2Data,
      'a3Data' => $a3Data,
      'a4Data' => $a4Data,
      'a5Data' => $a5Data,
      'a61Data' => $a61Data,
      'a62Data' => $a62Data,
      'a63Data' => $a63Data,
    ];

    return view('rt/detail-warga', $data);
  }

  public function detailLingkungan($id)
  {
    //model initialize
    $b1Model = new B1Model();
    $b2Model = new B2Model();
    $b3Model = new B3Model();
    $b4Model = new B4Model();
    $b5Model = new B5Model();
    $b6Model = new B6Model();
    $b7Model = new B7Model();
    $b8Model = new B8Model();
    $b1Data = $b1Model->where('id_rt', $id)->first();
    $b2Data = $b2Model->where('id_rt', $id)->first();
    $b3Data = $b3Model->where('id_rt', $id)->first();
    $b4Data = $b4Model->where('id_rt', $id)->first();
    $b5Data = $b5Model->where('id_rt', $id)->first();
    $b6Data = $b6Model->where('id_rt', $id)->first();
    $b7Data = $b7Model->where('id_rt', $id)->first();
    $b8Data = $b8Model->where('id_rt', $id)->first();

    $rtModel = new DataRTModel();
    $rtData = $rtModel
      ->select('data_rt.*, provinces.prov_name, cities.city_name, districts.dis_name, subdistricts.subdis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->join(
        'subdistricts',
        'data_rt.subdis_id = subdistricts.subdis_id'
      )
      ->where('id_rt', $id)
      ->first();

    $data = [
      'b1Data' => $b1Data,
      'b2Data' => $b2Data,
      'b3Data' => $b3Data,
      'b4Data' => $b4Data,
      'b5Data' => $b5Data,
      'b6Data' => $b6Data,
      'b7Data' => $b7Data,
      'b8Data' => $b8Data,
      'rt' => $rtData,
    ];

    return view('rt/detail-lingkungan', $data);
  }

  public function rekapRt($id)
  {
    //model initialize
    $rekapRTModel = new RekapRTModel();
    $rekapRTNonModel = new RekapRTNonModel();
    $rekapRTData = $rekapRTModel->where('id_rt', $id)->first();
    $rekapRTNonData = $rekapRTNonModel->where('id_rt', $id)->first();

    $rtModel = new DataRTModel();
    $rtData = $rtModel
      ->select('data_rt.*, provinces.prov_name, cities.city_name, districts.dis_name, subdistricts.subdis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->join(
        'subdistricts',
        'data_rt.subdis_id = subdistricts.subdis_id'
      )
      ->where('id_rt', $id)
      ->first();

    $data = [
      'rekapRTData' => $rekapRTData,
      'rekapRTNonData' => $rekapRTNonData,
      'rt' => $rtData,
      'idRT' => $id,
    ];

    return view('rt/rekap-rt', $data);
  }

  public function kekumuhanAwal($id)
  {
    //model initialize
    $kekumuhanAwalModel = new KekumuhanAwalModel();
    $kekumuhanAwalData = $kekumuhanAwalModel->where('id_rt', $id)->first();

    $rtModel = new DataRTModel();
    $rtData = $rtModel
      ->select('data_rt.*, provinces.prov_name, cities.city_name, districts.dis_name, subdistricts.subdis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->join(
        'subdistricts',
        'data_rt.subdis_id = subdistricts.subdis_id'
      )
      ->where('id_rt', $id)
      ->first();

    $data = [
      'kekumuhanAwalData' => $kekumuhanAwalData,
      'rt' => $rtData,
      'idRT' => $id,
    ];

    return view('rt/kekumuhan-awal', $data);
  }

  public function downloadRekapRt($id)
  {
    //model initialize
    $rekapRTModel = new RekapRTModel();
    $rekapRTNonModel = new RekapRTNonModel();
    $rekapRTData = $rekapRTModel->where('id_rt', $id)->first();
    $rekapRTNonData = $rekapRTNonModel->where('id_rt', $id)->first();

    $rtModel = new DataRTModel();
    $rtData = $rtModel
      ->select('data_rt.*, provinces.prov_name, cities.city_name, districts.dis_name, subdistricts.subdis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->join(
        'subdistricts',
        'data_rt.subdis_id = subdistricts.subdis_id'
      )
      ->where('id_rt', $id)
      ->first();

    $data = [
      'rekapRTData' => $rekapRTData,
      'rekapRTNonData' => $rekapRTNonData,
      'rt' => $rtData,
      'idRT' => $id,
    ];

    return view('rt/download-rekap-rt', $data);
  }

  public function downloadKekumuhanAwal($id)
  {
    //model initialize
    $kekumuhanAwalModel = new KekumuhanAwalModel();
    $kekumuhanAwalData = $kekumuhanAwalModel->where('id_rt', $id)->first();

    $rtModel = new DataRTModel();
    $rtData = $rtModel
      ->select('data_rt.*, provinces.prov_name, cities.city_name, districts.dis_name, subdistricts.subdis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->join(
        'subdistricts',
        'data_rt.subdis_id = subdistricts.subdis_id'
      )
      ->where('id_rt', $id)
      ->first();

    $data = [
      'kekumuhanAwalData' => $kekumuhanAwalData,
      'rt' => $rtData,
      'idRT' => $id,
    ];

    return view('rt/download-kekumuhan-awal', $data);
  }

  public function deleteRt($id)
  {
    //model initialize
    $dataRTModel = new DataRTModel();
    $data = $dataRTModel->where('id_rt',$id)->first();
    $b1Model = new B1Model();
    $b2Model = new B2Model();
    $b3Model = new B3Model();
    $b4Model = new B4Model();
    $b5Model = new B5Model();
    $b6Model = new B6Model();
    $b7Model = new B7Model();
    $b8Model = new B8Model();
    $kekumuhanAwalModel = new KekumuhanAwalModel();
    $rekapRTModel = new RekapRTModel();
    $rekapRTNonModel = new RekapRTNonModel();
    $wargaModel = new WargaModel();
    $a1Model = new A1Model();
    $a2Model = new A2Model();
    $a3Model = new A3Model();
    $a4Model = new A4Model();
    $a5Model = new A5Model();
    $a61Model = new A61Model();
    $a62Model = new A62Model();
    $a63Model = new A63Model();

    if ($data) {
      $dataRTModel->where('id_rt', $id)->delete();
      $b1Model->where('id_rt',$id)->delete();
      $b2Model->where('id_rt',$id)->delete();
      $b3Model->where('id_rt',$id)->delete();
      $b4Model->where('id_rt',$id)->delete();
      $b5Model->where('id_rt',$id)->delete();
      $b6Model->where('id_rt',$id)->delete();
      $b7Model->where('id_rt',$id)->delete();
      $b8Model->where('id_rt',$id)->delete();
      $kekumuhanAwalModel->where('id_rt',$id)->delete();
      $rekapRTModel->where('id_rt',$id)->delete();
      $rekapRTNonModel->where('id_rt',$id)->delete();
      $wargaData = $wargaModel->where('id_rt',$id)->findAll();

      foreach ($wargaData as $key => $warga) {
        $a1Model->where('id_warga',$warga['id_warga'])->delete();
        $a2Model->where('id_warga',$warga['id_warga'])->delete();
        $a3Model->where('id_warga',$warga['id_warga'])->delete();
        $a4Model->where('id_warga',$warga['id_warga'])->delete();
        $a5Model->where('id_warga',$warga['id_warga'])->delete();
        $a61Model->where('id_warga',$warga['id_warga'])->delete();
        $a62Model->where('id_warga',$warga['id_warga'])->delete();
        $a63Model->where('id_warga',$warga['id_warga'])->delete();
      }

      $wargaModel->where('id_rt', $id)->delete();

      //flash message
      session()->setFlashdata('message', 'Rt Berhasil Dihapus');

      return redirect()->to(base_url('rt'));
    } else {
      //flash message
      session()->setFlashdata('message', 'Users tidak ditemukan');
    }
  }
}
