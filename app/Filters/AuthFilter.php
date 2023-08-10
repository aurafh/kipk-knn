<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        if (session()->get('id') != true) {
            return redirect()->to('/');
        }
        // $role = $session->get('role');
        // if ($role != $arguments) {
        //     return redirect()->to('/')->with('error', 'Halaman tidak dalam hak akses anda!');
        // }
        // return true;
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (session()->get('id') == true) {
            return redirect()->to('dashboard');
        }
    }
}
