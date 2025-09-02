<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ImovelModel;
use App\Models\UserModel;
use App\Models\PropertyType;
use App\Models\States;
use App\Models\Cities;

class CadastraImovel extends BaseController
{
    public function index()
    {
        $objProperty = new PropertyType();
        $objStates   = new States();
        $objCities   = new Cities();

        if ($this->request->getMethod() === 'post') {
            return $this->validateField();
        }

        $infoClients  = $this->getInfoClients();
        $listProperty = $objProperty->getListProperty();
        $states       = $objStates->getListStates(); 
        $cities       = $objCities->getListCities();

        return view('cadastraImovel', [
            'infoClients'  => $infoClients, 
            'listProperty' => $listProperty, 
            'states'       => $states,
            'cities'       => $cities       
        ]);
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

    public function validateField()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dateInsert = date('Y-m-d H:i:s');
        $data = $this->post;

        if (empty($data['title'] ?? null)) {
            session()->setFlashdata('error', 'O campo título é obrigatório!');
            return redirect()->back()->withInput();
        }

        if (!$data['description']) {
            session()->setFlashdata('error', 'O campo descrição é obrigatório!');
            return redirect()->back()->withInput();
        }

        if (!$data['value']) {
            session()->setFlashdata('error', 'O campo valor é obrigatório!');
            return redirect()->back()->withInput();
        }

        if (!$data['footage']) {
            session()->setFlashdata('error', 'O campo área útil é obrigatório!');
            return redirect()->back()->withInput();
        }

        if (!$data['type_realty']) {
            session()->setFlashdata('error', 'O campo tipo imóvel é obrigatório!');
            return redirect()->back()->withInput();
        }

        $imagePaths = [];
        $files = $this->getFiles;

        if (isset($files['images']) && !empty($files['images'])) {
            foreach ($files['images'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    if (!in_array($file->getClientMimeType(), ['image/jpeg', 'image/png'])) {
                        session()->setFlashdata('error', 'Apenas imagens JPEG ou PNG são permitidas!');
                        return redirect()->back()->withInput();
                    }

                    if ($file->getSize() > 5 * 1024 * 1024) { // 5MB
                        session()->setFlashdata('error', 'As imagens não podem exceder 5MB!');
                        return redirect()->back()->withInput();
                    }

                    $imagePath = 'uploads/' . $file->getName();
                    // Move o arquivo para o diretório desejado
                    $file->move(ROOTPATH . 'public/uploads/', $file->getName());
                    $imagePaths[] = $imagePath;
                }
            }
        }

        $imovelData = [
            'user_id'      => session('usuario')['id'],
            'rooms'        => $data['rooms'] ?? 0,
            'bathrooms'    => $data['bathrooms'] ?? 0,
            'suites'       => $data['suites'] ?? 0,
            'reference'    => $data['reference'] ?? null,
            'value'        => $data['value'],
            'footage'      => $data['footage'],
            'cep'          => $data['cep'] ?? null,
            'neighborhood' => $data['neighborhood'],
            'state'        => $data['state'],
            'city'         => $data['city'],
            'address'      => $data['address'],
            'complement'   => $data['complement'],
            'title'        => $data['title'],
            'description'  => $data['description'],
            'garage'       => $data['garage'] ?? 0,
            'type_realty'  => $data['type_realty'],
            'imagens'      => json_encode($imagePaths),
            'deleted_at'   => 0,
            'disabled'     => 0,
            'sale_type'    => $data['sale_type'],
            'created_at'   => $dateInsert
        ];

        try {
            $imovelModel = new ImovelModel();
            $imovelModel->insert($imovelData);
            session()->setFlashdata('success', 'Imóvel cadastrado com sucesso!');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Erro ao cadastrar imóvel: ' . $e->getMessage());
        }

        return redirect()->to('/dashboard');
    }
}