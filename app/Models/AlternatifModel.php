<?php

namespace App\Models;

use CodeIgniter\Model;

class AlternatifModel extends Model
{
    protected $table            = 'alternatif';
    protected $primaryKey       = 'id_alternatif';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_alternatif', 'lokasi'];
}
