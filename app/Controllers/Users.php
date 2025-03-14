<?php

namespace App\Controllers;

use App\Models\DistrictsModel;
use App\Models\SubdistrictsModel;
use App\Models\UnitModel;
use App\Models\UsersModel;

class Users extends BaseController
{
  public function index()
  {
    return view('users/users');
  }

  public function ajax()
  {
    $usersModel = new UsersModel();
    $usersData = $usersModel
      ->select('*, users.id as id')
      ->join('subdistricts', 'users.subdis_id = subdistricts.subdis_id', 'left')
      ->findAll(); // Fetch all records from the model

    foreach ($usersData as &$user) {
      if (!isset($user['subdis_name']) || $user['subdis_name'] === null) {
        $user['subdis_name'] = ''; // Replace null or missing unitName with an empty string
      }
    }

    $data = [
      "data" => $usersData
    ];

    return $this->response->setJSON($data);
  }

  public function create()
  {
    $kecamatanModel = new DistrictsModel();
    $kecamatanData = $kecamatanModel->where('city_id', '192')->findAll();

    $data = [
      'kecamatan' => $kecamatanData
    ];
    return view('users/create', $data);
  }


  public function store()
  {
    //load helper form and URL
    helper(['form', 'url']);

    //define validation
    $validation = $this->validate([
      'username' => [
        'rules'  => 'required|is_unique[users.username]',
        'errors' => [
          'required' => 'Masukkan Username.',
          'is_unique'   => 'Username sudah ada dalam sistem.'
        ]
      ],
      'password' => [
        'rules'  => 'required',
        'errors' => [
          'required' => 'Masukkan Password.'
        ]
      ],
      'dis_id' => [
        'rules'  => 'required',
        'errors' => [
          'required' => 'Masukkan Kecamatan.'
        ]
      ],
    ]);

    if (!$validation) {
      $kecamatanModel = new DistrictsModel();
      $kecamatanData = $kecamatanModel->where('city_id', '192')->findAll();
      //render view with error validation message
      return view('users/create', [
        'kecamatan' => $kecamatanData,
        'validation' => $this->validator
      ]);
    } else {
      //model initialize
      $usersModel = new UsersModel();

      //insert data into database
      $usersModel->insert([
        'username'   => $this->request->getPost('username'),
        'role' => 'user',
        'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'dis_id' => $this->request->getPost('dis_id'),
        'subdis_id'   => $this->request->getPost('subdis_id'),
      ]);

      //flash message
      session()->setFlashdata('message', 'Users Berhasil Ditambahkan');

      return redirect()->to(base_url('users'));
    }
  }

  public function edit($id)
  {
    //model initialize
    $usersModel = new UsersModel();
    $users = $usersModel
      ->find($id);

    $data = array(
      'id' => $users['id'],
      'username' => $users['username'],
    );

    return view('users/edit', $data);
  }

  public function update($id)
  {
    //load helper form and URL
    helper(['form', 'url']);

    //define validation
    $validation = $this->validate([
      'username' => [
        'rules'  => 'required',
        'errors' => [
          'required' => 'Masukkan Username.'
        ]
      ],
      'password' => [
        'rules'  => 'required',
        'errors' => [
          'required' => 'Masukkan Password.'
        ]
      ],
    ]);

    if (!$validation) {
      //model initialize
      $usersModel = new UsersModel();
      $users = $usersModel
        ->find($id);

      $data = array(
        'id' => $users['id'],
        'username' => $users['username'],
        'validation' => $this->validator
      );

      //render view with error validation message
      return view('users/edit', $data);
    } else {
      //model initialize
      $usersModel = new UsersModel();

      //insert data into database
      $usersModel->update($id, [
        'username'   => $this->request->getPost('username'),
        'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
      ]);

      //flash message
      session()->setFlashdata('message', 'Users Berhasil Diupdate');
      return redirect()->to(base_url('users'));
    }
  }

  public function delete($id)
  {
    //model initialize
    $usersModel = new UsersModel();
    $data = $usersModel->find($id);


    if ($data) {
      $usersModel->delete($id);

      //flash message
      session()->setFlashdata('message', 'Users Berhasil Dihapus');

      return redirect()->to(base_url('users'));
    } else {
      //flash message
      session()->setFlashdata('message', 'Users tidak ditemukan');
    }
  }

  public function changePassword()
  {
    $data = [
      'id' => session()->get('userId'),
    ];
    return view('users/change-password', $data);
  }

  public function updatePassword($id)
  {
    $usersModel = new UsersModel();
    $users = $usersModel->find($id);

    if ($users) {
      $usersModel->update($id, [
        'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
      ]);

      //flash message
      session()->setFlashdata('message', 'Users Berhasil Ganti Password');

      return redirect()->to(base_url('users/changePassword'));
    } else {
      //flash message
      session()->setFlashdata('message', 'Users tidak ditemukan');
    }
  }

  public function getDesaByKecamatan()
  {
    $selectedKecamatan = $this->request->getPost('dis_id'); // Retrieve the selected Kecamatan ID

    // Fetch Desa data based on the selected Kecamatan ID from your model
    $desaModel = new SubdistrictsModel(); // Replace with your model
    $desaData = $desaModel->where('dis_id', $selectedKecamatan)->findAll(); // Implement this method in your model

    // Return the data as JSON
    return $this->response->setJSON($desaData);
  }
}
