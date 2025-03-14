<?php

namespace App\Models;

use CodeIgniter\Model;

class DataRTModel extends Model
{
  /**
   * table name
   */
  protected $table = "data_rt";

  /**
   * allowed Field
   */
  protected $protectFields = false;
  // protected $allowedFields = '*';
}
