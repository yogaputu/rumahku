<?php

namespace App\Controllers;

use App\Models\DataRTModel;
use App\Models\WargaModel;

class Home extends BaseController
{
  public function index()
  {
    $rtModel = new DataRTModel();
    $rtData = $rtModel
      ->select('provinces.prov_name, cities.city_name, districts.dis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->groupBy('provinces.prov_name, cities.city_name, districts.dis_name')
      ->findAll(); // Fetch all records from the model

    $wargaModel = new WargaModel();
    $wargaData = $wargaModel
      ->select('warga.id_warga')
      ->join('data_rt', 'warga.id_rt = data_rt.id_rt')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->findAll();

    $rtData1 = $rtModel
      ->select('provinces.prov_name, cities.city_name, districts.dis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->findAll(); // Fetch all records from the model

    $countWargaKecamatan = $wargaModel
      ->select('count(warga.id_warga) as warga, districts.dis_name')
      ->join('data_rt', 'warga.id_rt = data_rt.id_rt')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->groupBy('districts.dis_name')
      ->findAll(); // Fetch all records from the model

    $countRtKecamatan =
      $rtModel
      ->select('count(data_rt.id_rt) as rt, districts.dis_name')
      ->join('provinces', 'data_rt.prov_id = provinces.prov_id')
      ->join('cities', 'data_rt.city_id = cities.city_id')
      ->join('districts', 'data_rt.dis_id = districts.dis_id')
      ->groupBy('districts.dis_name')
      ->findAll(); // Fetch all records from the model

    $countKecamatan = count($rtData);
    $countWarga = count($wargaData);
    $countRt = count($rtData1);

    $data = [
      'jumlahKecamatan' => $countKecamatan,
      'jumlahWarga' => $countWarga,
      'jumlahRt' => $countRt,
      'kecamatan' => $countWargaKecamatan,
      'rt' => $countRtKecamatan,
    ];

    return view('home', $data);
  }
}
