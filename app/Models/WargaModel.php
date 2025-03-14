<?php

namespace App\Models;

use CodeIgniter\Model;

class WargaModel extends Model
{
  /**
   * table name
   */
  protected $table = "warga";

  /**
   * allowed Field
   */
  protected $protectFields = false;
  // protected $allowedFields = '*';
}
