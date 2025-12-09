<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PagamentosModel;
use App\Models\PlansModel;

class MonthlyFee extends BaseController
{
    public function index()
    {
        $payments       = new PagamentosModel();
        $planUsedClient = new PlansModel(); 
        $user           = $this->getSession();

        if (!$user) {
            return redirect()->to('/login')->with('erro', 'Você precisa estar logado para verificar suas mensalidades!');
        }

        $infoClients      = $this->getInfoClients($user);
        $monthlyFeeClient = $payments->getMonthlyFeeByIdClientAsaas($user['asaas_id']);

        return view('monthlyFee', ['infoClients' => $infoClients, 'monthlyFeeClient' => $monthlyFeeClient]);
    }

    public function getSession()
    {
        $session = session();

        if (!$session->has('usuario')) {
            return false;
        }

        return $session->get('usuario');
    }

    private function getInfoClients($session)
    {
        $UserSession = $session;

        $userModel   = new UserModel();

        return $userModel->find($UserSession);
    }
}