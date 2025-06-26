<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ImovelModel;

class DashBoard extends BaseController
{
    public function index()
    {
        $session = session();

        if (!$session->has('usuario')) {
            return redirect()->to('/login')->with('erro', 'Você precisa estar logado para acessar o Dashboard.');
        }

        $infoClients  = $this->getInfoClients();
        $realtyCount  = $this->getRealty();
        $realtyValue  = $this->getRealtyValue();
        $realtyClient = $this->displayPropertiesDashboard();

        if (!$infoClients) {
            return redirect()->to('/login')->with('erro', 'Usuário não encontrado.');
        }

        return view('dashboard', [
            'infoClients'  => $infoClients,
            'realtyCount'  => $realtyCount,
            'realtyValue'  => $realtyValue,
            'realtyClient' => $realtyClient,
        ]);
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

    public function getRealty()
    {
        $session = session();

        $userId = $session->get('usuario')['id'];

        if (!$userId) {
            return null;
        }

        $imovelModel = new ImovelModel();
        $realtyCount = $imovelModel->getRealtyUserId($userId);

        if ($realtyCount) {
            return $realtyCount;
        } else {
            return null;
        }
    }

    public function getRealtyValue()
    {
        $session = session();

        $userId = $session->get('usuario')['id'];

        if (!$userId) {
            return null;
        }

        $imovelModel = new ImovelModel();
        $realtyValue = $imovelModel->getRealtyValue($userId);

        if ($realtyValue) {
            return $realtyValue;
        } else {
            return null;
        }
    }

    public function displayPropertiesDashboard() {

        $session = session();

        $userId = $session->get('usuario')['id'];

        $getRealty = new ImovelModel();

        return $getRealty->getRealtyClient($userId);

    }

public function disableRealty() {
    $result = [];

    try {
        if ($this->verifyAjax) {
            $realty = new ImovelModel();
            $id = $this->request->getPost('id');
            $realty->disableRealty($id);
            $result = ['status' => 'success'];
        }
    } catch (\Throwable $e) {
        $result['error'] = $e->getMessage();
    }

    return $this->response->setJSON($result); // importante!
}

}
