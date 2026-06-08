<?php

namespace App\Controllers;

use App\Models\FeedbackModel;

class Feedback extends BaseController
{
    protected $feedbackModel;

    public function __construct()
    {
        $this->feedbackModel = new FeedbackModel();
    }

    // Untuk user submit feedback dari halaman ranking
    public function submit()
    {
        if (session()->get('role') != 'user') return redirect()->to(base_url('home'));

        $id_user = session()->get('id_user');
        $nama_alternatif = $this->request->getPost('nama_alternatif_rekomendasi');
        $status = $this->request->getPost('status_feedback');
        $alasan = $this->request->getPost('alasan');

        if (!$nama_alternatif || !$status) {
            return redirect()->to(base_url('smart/ranking'))->with('error', 'Data evaluasi tidak lengkap.');
        }

        $this->feedbackModel->insert([
            'id_user' => $id_user,
            'nama_alternatif_rekomendasi' => $nama_alternatif,
            'status_feedback' => $status,
            'alasan' => $alasan,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('smart/ranking'))->with('success', 'Terima kasih atas partisipasi Anda dalam mengevaluasi hasil sistem!');
    }

    // Untuk admin melihat dashboard feedback
    public function admin()
    {
        if (session()->get('role') != 'admin') return redirect()->to(base_url('home'));

        $db = \Config\Database::connect();
        
        $builder = $db->table('feedback_rekomendasi');
        $builder->select('feedback_rekomendasi.*, users.nama as nama_user');
        $builder->join('users', 'users.id_user = feedback_rekomendasi.id_user');
        $builder->orderBy('feedback_rekomendasi.created_at', 'DESC');
        $feedbacks = $builder->get()->getResultArray();

        $total = count($feedbacks);
        $setuju = 0;
        $tidakSetuju = 0;

        foreach ($feedbacks as $f) {
            if ($f['status_feedback'] == 'Setuju') {
                $setuju++;
            } else {
                $tidakSetuju++;
            }
        }

        $persentase = $total > 0 ? round(($setuju / $total) * 100, 2) : 0;

        $data = [
            'title' => 'Monitoring Evaluasi Sistem | SPK SMART',
            'feedbacks' => $feedbacks,
            'total' => $total,
            'setuju' => $setuju,
            'tidakSetuju' => $tidakSetuju,
            'persentase' => $persentase
        ];

        return view('admin/feedback', $data);
    }
}
