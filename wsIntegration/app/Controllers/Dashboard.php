<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class DashBoard extends BaseController
{
    public function index()
    {
        $session = session();

        if (!$session->has('usuario')) {
            return redirect()->to('/login')->with('erro', 'Você precisa estar logado para acessar o Dashboard.');
        }

        $infoClients = $this->getInfoClients();


        if (!$infoClients) {
            return redirect()->to('/login')->with('erro', 'Usuário não encontrado.');
        }

        return view('dashboard', ['infoClients' => $infoClients]);
    }

    private function getInfoClients()
    {
        $session = session();
        $userId = $session->get('usuario');

        if (!$userId) {
            return null;
        }
        
        $userModel = new UserModel();

        return $userModel->find($userId);
    }
}
