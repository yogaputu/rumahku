<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    /**
     * table name
     */
    protected $table = "users";

    /**
     * allowed Field
     */
  // protected $allowedFields = [
  //     'id',
  //     'username',
  //     'password'
  // ];
  protected $protectFields = false;
}