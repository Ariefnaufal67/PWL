<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $startDate = date('Y-m-d'); // Today's date
        
        // Generate 10 days of discount data
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'tanggal'    => date('Y-m-d', strtotime($startDate . ' +' . $i . ' days')),
                'nominal'    => rand(50000, 500000), // Random discount between 50k-500k
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('diskon')->insertBatch($data);
    }
}