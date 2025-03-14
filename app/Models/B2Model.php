<?php

namespace App\Models;

use CodeIgniter\Model;

class B2Model extends Model
{
  /**
   * table name
   */
  protected $table = "b2";

  /**
   * allowed Field
   */
  protected $protectFields = false;
  // protected $allowedFields = '*';
}
