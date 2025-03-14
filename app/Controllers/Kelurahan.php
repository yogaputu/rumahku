<?php

namespace App\Controllers;

use App\Models\DataRTModel;
use App\Models\WargaModel;
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

class Kelurahan extends BaseController
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
    return view('kelurahan/kecamatan', $data);
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
    return view('kelurahan/kelurahan', $data);
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
    return view('kelurahan/rt', $data);
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

    $data = [
      'rt' => $rtData,
      'idRT' => $id,
      'petaName' => $rtData['peta'],
    ];

    return view('kelurahan/detail', $data);
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

    return view('kelurahan/detail-lingkungan', $data);
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

    return view('kelurahan/rekap-rt', $data);
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

    return view('kelurahan/kekumuhan-awal', $data);
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

    return view('kelurahan/download-rekap-rt', $data);
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

    return view('kelurahan/download-kekumuhan-awal', $data);
  }

  public function showPdf($fileName)
  {
    $filePath = ROOTPATH . 'public/uploads/' . $fileName; // Path to the PDF file

    // Check if the file exists
    if (file_exists($filePath)) {
      header('Content-Type: application/pdf');
      readfile($filePath);
      exit; // Terminate script after sending the file
    } else {
      echo 'File not found';
    }
  }
}
