<?php

namespace App\Models;

use CodeIgniter\Model;

class CityModel extends Model
{
  /**
   * table name
   */
  protected $table = "cities";

  /**
   * allowed Field
   */
  protected $protectFields = false;
  // protected $allowedFields = '*';
}
