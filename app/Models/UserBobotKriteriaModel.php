<?php

namespace App\Models;

use CodeIgniter\Model;

class UserBobotKriteriaModel extends Model
{
    protected $table            = 'user_bobot_kriteria';
    protected $primaryKey       = 'id_bobot';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_user', 'id_kriteria', 'bobot'
    ];
}
