<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        if (!session()->has('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $this->checkAvailableDiscounts();
    }

    private function checkAvailableDiscounts()
    {
        // Get database instance
        $db = \Config\Database::connect();
        
        // Get current date
        $currentDate = date('Y-m-d');
        
        // Query to find active discounts based on current date using 'diskon' table
        $builder = $db->table('diskon');
        $builder->select('id, tanggal, nominal');
        $builder->where('tanggal', $currentDate);
        
        $query = $builder->get();
        $discount = $query->getRowArray();
        
        if ($discount) {
            // Store discount data in session
            session()->set('current_discount', [
                'id' => $discount['id'],
                'tanggal' => $discount['tanggal'],
                'nominal' => $discount['nominal']
            ]);
        } else {
            // Clear discount data if no active discounts
            session()->remove('current_discount');
        }
    }
}