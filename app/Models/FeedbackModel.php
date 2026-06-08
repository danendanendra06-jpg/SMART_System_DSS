<?php

namespace App\Models;

use CodeIgniter\Model;

class FeedbackModel extends Model
{
    protected $table            = 'feedback_rekomendasi';
    protected $primaryKey       = 'id_feedback';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_user', 'nama_alternatif_rekomendasi', 'status_feedback', 'alasan', 'created_at'
    ];

    // Dates
    protected $useTimestamps = false; // We can set created_at manually if needed, or set true if we add updated_at
}
