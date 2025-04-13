<?php

namespace App\Controllers;

use App\Models\UserModel; 


class DataClient extends BaseController
{
    public function index()
    {
        $session = session();

        if (!$session->has('usuario')) {
            return redirect()->to('/login')->with('erro', 'Você precisa estar logado para acessar o Dashboard.');
        }

        $infoClients = $this->getInfoClients();

        if (!$infoClients) {
            $session->destroy();
            return redirect()->to('/login')->with('erro', 'Usuário não encontrado.');
        }

        return view('dataClient', ['infoClients' => $infoClients]);
    }

    private function getInfoClients()
    {
        $session = session();
        $usuarioData = $session->get('usuario');

        if (!isset($usuarioData['id'])) {
            return null;
        }

        $userModel = new UserModel();
        return $userModel->find($usuarioData['id']);
    }
}
