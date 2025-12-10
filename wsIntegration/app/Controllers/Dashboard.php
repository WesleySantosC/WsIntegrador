<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ImovelModel;
use App\Models\PlansModel;

class DashBoard extends BaseController
{
    public function index()
    {
        $session = session();

        if (!$session->has('usuario')) {
            return redirect()->to('/login')->with('erro', 'Você precisa estar logado para acessar o Dashboard.');
        }

        $infoClients         = $this->getInfoClients();
        $realtyCount         = $this->getRealty();
        $realtyValue         = $this->getRealtyValue();
        $realtyClient        = $this->displayPropertiesDashboard();
        $realtyDisabled      = $this->viewRealtyDisable();
        $realtyCountDisabled = $this->getRealtyDisable();
        $planUsedClient      = $this->getPlanUsedClient();

        if (!$infoClients) {
            return redirect()->to('/login')->with('erro', 'Usuário não encontrado.');
        }

        // Filtra imagens existentes para o dashboard
        $realtyClient   = $this->sanitizeImages($realtyClient);
        $realtyDisabled = $this->sanitizeImages($realtyDisabled);

        return view('dashboard', [
            'infoClients'         => $infoClients,
            'realtyCount'         => $realtyCount,
            'realtyValue'         => $realtyValue,
            'realtyClient'        => $realtyClient,
            'realtyDisabled'      => $realtyDisabled,
            'realtyCountDisabled' => $realtyCountDisabled,
            'planUsedClient'      => $planUsedClient
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
        $userId = $session->get('usuario')['id'] ?? null;

        if (!$userId) {
            return null;
        }

        $imovelModel = new ImovelModel();
        return $imovelModel->getRealtyUserId($userId) ?: null;
    }

    public function getRealtyDisable() {
        $session = session();
        $userId = $session->get('usuario')['id'] ?? null;

        if (!$userId) {
            return null;
        }

        $imovelModel = new ImovelModel();
        return $imovelModel->getRealtyDisableUserId($userId);
    }

    public function getRealtyValue()
    {
        $session = session();
        $userId = $session->get('usuario')['id'] ?? null;

        if (!$userId) {
            return null;
        }

        $imovelModel = new ImovelModel();
        return $imovelModel->getRealtyValue($userId) ?: null;
    }

    public function displayPropertiesDashboard()
    {
        $session = session();
        $userId = $session->get('usuario')['id'] ?? null;

        if (!$userId) return [];

        $getRealty = new ImovelModel();
        return $getRealty->getRealtyClient($userId) ?: [];
    }

    public function viewRealtyDisable()
    {
        $session = session();
        $userId = $session->get('usuario')['id'] ?? null;

        if (!$userId) return [];

        $getRealty = new ImovelModel();
        return $getRealty->listRealtyDisabledByClientId($userId) ?: [];
    }

    public function disableRealty()
    {
        $result = [];

        try {
            if ($this->verifyAjax) {
                $realty = new ImovelModel();
                $id = $this->post['id'];
                if ($id) {
                    $realty->disableRealty($id);
                }

                $result = ['status' => 'success'];
            }
        } catch (\Throwable $e) {
            $result['error'] = $e->getMessage();
        }

        return $this->response->setJSON($result);
    }

    public function activeRealty()
    {
        $result = [];

        try {
            $objRealty = new ImovelModel();
            $realtyActiveId = $this->post["id"] ?? null;

            if ($realtyActiveId) {
                $objRealty->activeRealty($realtyActiveId);
                $result = ["status" => "success"];
            }
        } catch (\Throwable $e) {
            $result['error'] = $e->getMessage();
        }

        return $this->response->setJSON($result);
    }

    public function highlightsProperty() {
        $result = [];

        try {
            $objRealty = new ImovelModel();
            $realtyActiveId = $this->post["id"] ?? null;

            if($realtyActiveId) {
                $objRealty->highlightsPropertyById($realtyActiveId);
                $result = ["status" => "success"];
            }

        } catch(\Throwable $e) {
            $result['error'] = $e->getMessage();
        } finally {
            return $this->response->setJSON($result);
        }
    }

    public function removeHighlightsProperty() {
        $result = [];

        try {
            $objRealty = new ImovelModel();
            $realtyActiveId = $this->post["id"] ?? null;

            if($realtyActiveId) {
                $objRealty->removeHighlightsPropertyById($realtyActiveId);
                $result = ["status" => "success"];
            }

        } catch(\Throwable $e) {
            $result['error'] = $e->getMessage();
        } finally {
            return $this->response->setJSON($result);
        }
    }

    /**
     * Filtra as imagens de cada imóvel, removendo caminhos que não existem
     */
    private function sanitizeImages($properties)
    {
        if (empty($properties)) return [];

        foreach ($properties as &$property) {
            $imgs = json_decode($property->imagens, true);
            if (is_array($imgs)) {
                $imgs = array_filter($imgs, function ($img) {
                    return file_exists(ROOTPATH . 'public/' . $img);
                });
                $property->imagens = json_encode(array_values($imgs));
            }
        }
        return $properties;
    }

    public function sessionClient() {
        $session = session();
        $userId = $session->get('usuario')['id'] ?? null;

        if (!$userId) {
            return redirect()->to('/login')->with('erro', 'Você precisa estar logado para acessar o Dashboard.');
        }

        return $userId;
    }

    public function getPlanUsedClient() {
        $plansModel = new PlansModel();
        $idUser     = $this->sessionClient();

        $planChoose = $plansModel->obtainThePlanChosenByTheCustomer($idUser);

        if(!$planChoose) {
            return "Este cliente não possui um plano!";
        }

        return $planChoose;
    }
}
