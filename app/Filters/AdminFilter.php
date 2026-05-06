<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu!');
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            session()->setFlashdata('error', 'Akses ditolak! Hanya admin.');
            return redirect()->to('/user/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}