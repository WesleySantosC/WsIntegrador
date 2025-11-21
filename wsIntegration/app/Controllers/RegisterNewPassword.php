<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class RegisterNewPassword extends BaseController
{
    public function index()
    {
        return view('RegisterNewPassword');
    }

    public function resultStatus()
    {
        $request        = service('request');
        $email          = $request->getPost('email');
        $novaSenha      = $request->getPost('nova_senha');
        $confirmarSenha = $request->getPost('confirmar_senha');

        try {
            if ($novaSenha !== $confirmarSenha) {
                throw new \Exception("As senhas não coincidem.");
            }

            $userModel = new UserModel();
            $resultado = $userModel->redefinirSenhaPorEmail($email, $novaSenha);

            if ($resultado !== "Senha redefinida com sucesso!") {
                throw new \Exception($resultado);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => $resultado
            ]);

        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
