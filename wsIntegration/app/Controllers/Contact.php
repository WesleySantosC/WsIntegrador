<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Contact extends BaseController
{
    public function index()
    {
        return view('contact');
    }

    public function submit()
    {
        $nome = $this->request->getPost('nome');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $question = $this->request->getPost('question');

        return view('contact');
    }
}
