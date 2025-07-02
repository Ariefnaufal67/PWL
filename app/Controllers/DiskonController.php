<?php

namespace App\Controllers;

use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $diskonModel;

    public function __construct()
    {
        $this->diskonModel = new DiskonModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Diskon',
            'diskons' => $this->diskonModel->orderBy('tanggal', 'DESC')->findAll()
        ];

        return view('v_diskon', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'tanggal' => 'required|valid_date',
            'nominal' => 'required|integer|greater_than[0]'
        ])) {
            session()->setFlashdata('error', 'Data tidak valid. Periksa kembali input Anda.');
            return redirect()->back()->withInput();
        }

        $tanggal = $this->request->getPost('tanggal');
        $nominal = $this->request->getPost('nominal');

        // Cek apakah sudah ada diskon untuk tanggal tersebut
        $existingDiscount = $this->diskonModel->where('tanggal', $tanggal)->first();
        
        if ($existingDiscount) {
            session()->setFlashdata('error', 'Diskon untuk tanggal ' . date('d/m/Y', strtotime($tanggal)) . ' sudah ada!');
            return redirect()->back()->withInput();
        }

        $data = [
            'tanggal' => $tanggal,
            'nominal' => $nominal
        ];

        if ($this->diskonModel->save($data)) {
            session()->setFlashdata('success', 'Diskon berhasil ditambahkan!');
            
            // Jika diskon yang ditambahkan adalah untuk hari ini, update session
            if ($tanggal == date('Y-m-d')) {
                session()->set([
                    'discount' => $nominal,
                    'discount_date' => date('d/m/Y', strtotime($tanggal)),
                    'discount_id' => $this->diskonModel->getInsertID()
                ]);
            }
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan diskon!');
        }

        return redirect()->to('/diskon');
    }

    public function update($id)
    {
        $diskon = $this->diskonModel->find($id);
        
        if (!$diskon) {
            session()->setFlashdata('error', 'Diskon tidak ditemukan!');
            return redirect()->to('/diskon');
        }

        if (!$this->validate([
            'nominal' => 'required|integer|greater_than[0]'
        ])) {
            session()->setFlashdata('error', 'Nominal diskon tidak valid!');
            return redirect()->back();
        }

        $nominal = $this->request->getPost('nominal');

        $data = [
            'nominal' => $nominal
        ];

        if ($this->diskonModel->update($id, $data)) {
            session()->setFlashdata('success', 'Diskon berhasil diperbarui!');
            
            // Jika diskon yang diupdate adalah untuk hari ini, update session
            if ($diskon['tanggal'] == date('Y-m-d')) {
                session()->set([
                    'discount' => $nominal,
                    'discount_date' => date('d/m/Y', strtotime($diskon['tanggal'])),
                    'discount_id' => $id
                ]);
            }
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui diskon!');
        }

        return redirect()->to('/diskon');
    }

    public function delete($id)
    {
        $diskon = $this->diskonModel->find($id);
        
        if (!$diskon) {
            session()->setFlashdata('error', 'Diskon tidak ditemukan!');
            return redirect()->to('/diskon');
        }

        if ($this->diskonModel->delete($id)) {
            session()->setFlashdata('success', 'Diskon berhasil dihapus!');
            
            // Jika diskon yang dihapus adalah untuk hari ini, hapus dari session
            if ($diskon['tanggal'] == date('Y-m-d')) {
                session()->remove(['discount', 'discount_date', 'discount_id']);
            }
        } else {
            session()->setFlashdata('error', 'Gagal menghapus diskon!');
        }

        return redirect()->to('/diskon');
    }

    /**
     * API method untuk mendapatkan diskon hari ini
     */
    public function getTodayDiscountAPI()
    {
        $todayDiscount = $this->diskonModel->getTodayDiscount();
        
        if ($todayDiscount) {
            return $this->response->setJSON([
                'status' => 'success',
                'data' => [
                    'id' => $todayDiscount['id'],
                    'tanggal' => $todayDiscount['tanggal'],
                    'nominal' => $todayDiscount['nominal'],
                    'formatted_date' => date('d/m/Y', strtotime($todayDiscount['tanggal'])),
                    'formatted_nominal' => number_format($todayDiscount['nominal'], 0, ',', '.')
                ]
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak ada diskon untuk hari ini'
            ]);
        }
    }

    /**
     * API method untuk cek diskon berdasarkan tanggal
     */
    public function checkDiscountAPI($date)
    {
        // Validasi format tanggal
        if (!strtotime($date)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Format tanggal tidak valid'
            ]);
        }

        $discount = $this->diskonModel->getDiscountByDate($date);
        
        if ($discount) {
            return $this->response->setJSON([
                'status' => 'success',
                'data' => [
                    'id' => $discount['id'],
                    'tanggal' => $discount['tanggal'],
                    'nominal' => $discount['nominal'],
                    'formatted_date' => date('d/m/Y', strtotime($discount['tanggal'])),
                    'formatted_nominal' => number_format($discount['nominal'], 0, ',', '.')
                ]
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak ada diskon untuk tanggal ' . date('d/m/Y', strtotime($date))
            ]);
        }
    }

    /**
     * Method untuk check diskon hari ini (untuk internal use)
     */
    public function checkToday()
    {
        $todayDiscount = $this->diskonModel->getTodayDiscount();
        
        if ($todayDiscount) {
            // Update session jika user sudah login
            if (session()->get('logged_in')) {
                session()->set([
                    'discount' => $todayDiscount['nominal'],
                    'discount_date' => date('d/m/Y', strtotime($todayDiscount['tanggal'])),
                    'discount_id' => $todayDiscount['id']
                ]);
                
                session()->setFlashdata('success', 'Diskon hari ini telah diperbarui!');
            }
        } else {
            session()->setFlashdata('info', 'Tidak ada diskon untuk hari ini.');
        }

        return redirect()->back();
    }
}