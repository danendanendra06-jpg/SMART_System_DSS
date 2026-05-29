<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPenilaianModel extends Model
{
    protected $table            = 'detail_penilaian';
    protected $primaryKey       = 'id_detail';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_penilaian', 'id_kriteria', 'nilai'
    ];
}
