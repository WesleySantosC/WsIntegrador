<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Register extends BaseController
{
    public function index()
    {
        return view('register');
    }

    public function store()
    {
        $request = service('request');

        $nome  = $request->getPost('nome');
        $email = $request->getPost('email');
        $senha = $request->getPost('password');

        if (empty($nome) || empty($email) || empty($senha)) {
            return redirect()->to('/register')->with('erro', 'Todos os campos são obrigatórios.');
        }

        $model = new UserModel();

        if ($model->where('email', $email)->first()) {
            return redirect()->to('/register')->with('erro', 'E-mail já cadastrado.');
        }

        $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

        $model->insert([
            'nome'  => $nome,
            'email' => $email,
            'senha' => $hashedPassword,
        ]);

        return redirect()->to('/login')->with('sucesso', 'Cadastro realizado com sucesso! Faça login.');
    }
}
