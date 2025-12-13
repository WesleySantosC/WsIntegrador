<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function verifyUsers()
    {
        $request = service('request');

        $email = $request->getPost('email');
        $senha = $request->getPost('password');

        $model = new UserModel();
        $usuario = $model->where('email', $email)->first();

        if (!$usuario) {
            return redirect()->to('/login')->with('erro', 'Usuário não encontrado.');
        }

        if (!password_verify($senha, $usuario['senha'])) {
            return redirect()->to('/login')->with('erro', 'Senha incorreta.');
        }

        session()->set('usuario', $usuario);
        return redirect()->to('/dashboard');
    }

    public function getUserSession()
    {
        $usuario = session()->get('usuario');

        if (!$usuario) {
            return redirect()->to('/login')->with('erro', 'Você precisa estar logado.');
        }

        return $this->jsonResponse($usuario);
    }

    public function logout()
    {
        session()->remove('usuario');
        session()->destroy();  
    
        return redirect()->to('/');
    }
}
