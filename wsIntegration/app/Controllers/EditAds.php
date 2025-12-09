<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ImovelModel;
use App\Models\PropertyType;
use App\Models\States;
use App\Models\Cities;

class EditAds extends BaseController
{
    public function edit($idRealty = null)
    {
        $session = session();

        if (!$session->has('usuario')) {
            return redirect()->to('/login')->with('erro', 'Você precisa estar logado para editar seu anúncio.');
        }

        $objRealty    = new ImovelModel();
        $objCities    = new Cities();
        $objStates    = new States();
        $objProperty  = new PropertyType();
        $infoClients  = $this->getInfoClients();
        $infoRealty   = $objRealty->listInfoAds($idRealty);
        $cities       = $objCities->getListCities();
        $states       = $objStates->getListStates();
        $listProperty = $objProperty->getListProperty();
        $infoRealty   = $this->sanitizeImages($infoRealty, true);

        return view('EditAds', [
            'infoClients'  => $infoClients,
            'cities'       => $cities,
            'states'       => $states,
            'listProperty' => $listProperty,
            'infoRealty'   => $infoRealty
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
        $user = $userModel->find($usuarioData['id']);

        return $user ? (array) $user : null;
    }

public function editAds()
{
    $result = [];

    try {
        $postData = $this->post;
        $files = $this->getFiles;

        if (empty($postData['id'])) {
            throw new \Exception("ID do imóvel não informado.");
        }

        $id = $postData['id'];
        unset($postData['id']);

        $rawToDelete = $postData['images_to_delete'] ?? '[]';
        $imagesToDelete = json_decode($rawToDelete, true);
        if (!is_array($imagesToDelete)) {
            $imagesToDelete = [];
        }

        $imagesToDelete = array_map(fn($p) => ltrim(trim($p), '/'), $imagesToDelete);
        $value          = $postData['value'];
        $iptu           = $postData['iptu'];
        $condominium    = $postData['condominium'];

        $value       = $this->cleanMoney($value);
        $iptu        = $this->cleanMoney($iptu);
        $condominium = $this->cleanMoney($condominium);

        $hideAddress = isset($postData['hide_address']) ? 1 : 0;

        $updateData = [
            'user_id'       => session('usuario')['id'],
            'rooms'         => $postData['rooms'] ?? 0,
            'bathrooms'     => $postData['bathrooms'] ?? 0,
            'suites'        => $postData['suites'] ?? 0,
            'reference'     => $postData['reference'] ?? null,
            'value'         => $value,
            'footage'       => $postData['footage'] ?? null,
            'cep'           => $postData['cep'] ?? '',
            'neighborhood'  => $postData['neighborhood'] ?? null,
            'state'         => $postData['state'] ?? null,
            'city'          => $postData['city'] ?? null,
            'address'       => $postData['address'] ?? null,
            'complement'    => $postData['complement'] ?? null,
            'title'         => $postData['title'] ?? null,
            'description'   => $postData['description'] ?? null,
            'garage'        => $postData['garage'] ?? 0,
            'type_realty'   => $postData['type_realty'] ?? null,
            'deleted_at'    => 0,
            'disabled'      => 0,
            'sale_type'     => $postData['sale_type'] ?? null,
            'condominium'   => $condominium,
            'iptu'          => $iptu,
            'purpose'       => $postData['purpose'],
            'hide_address'  => $hideAddress,
            'uf'            => $postData['uf']
        ];

        $imovelModel = new ImovelModel();
        $old = $imovelModel->find($id);

        $oldImgs = [];
        if (!empty($old['imagens'])) {
            $decoded = json_decode($old['imagens'], true);
            if (is_array($decoded)) {
                $oldImgs = $decoded;
            }
        }

        $oldImgs = array_map(fn($p) => ltrim(trim($p), '/'), $oldImgs);

        foreach ($imagesToDelete as $img) {
            $fullPath = ROOTPATH . 'public/' . $img;
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        $oldImgs = array_values(array_filter($oldImgs, fn($i) => !in_array($i, $imagesToDelete)));

        $newUploads = [];
        if (isset($files['images']) && !empty($files['images'])) {
            foreach ($files['images'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {

                    if (!in_array($file->getClientMimeType(), ['image/jpeg', 'image/png'])) {
                        throw new \Exception("Somente JPEG e PNG são permitidos.");
                    }

                    if ($file->getSize() > 5 * 1024 * 1024) {
                        throw new \Exception("Cada imagem deve ter no máximo 5MB.");
                    }

                    $newName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', $file->getName());
                    $file->move(ROOTPATH . 'public/uploads/', $newName);
                    $newUploads[] = 'uploads/' . $newName;
                }
            }
        }

        $finalImgs = array_merge($oldImgs, $newUploads);

        if (!empty($finalImgs)) {
            $updateData['imagens'] = json_encode(array_values($finalImgs));
        } else {
            $updateData['imagens'] = null;
        }

        $imovelModel->update($id, $updateData);

        $result = ['status' => 'success'];
    } catch (\Throwable $e) {
        $result = ['error' => $e->getMessage()];
    }

    return $this->jsonResponse($result);
}

    /**
     * Sanitiza imagens do imóvel.
     * @param mixed $properties Array ou objeto único
     * @param bool $returnObject Se true, retorna objeto único para view
     */
    private function sanitizeImages($properties, $returnObject = false)
    {
        if (empty($properties)) return $returnObject ? (object)[] : [];

        // Se for array de resultados ou objeto único
        $singleObject = false;
        if (!is_array($properties) || isset($properties->id)) {
            $properties = [$properties];
            $singleObject = true;
        }

        foreach ($properties as &$property) {
            // Converte para array temporário para manipular imagens
            if (is_object($property)) {
                $propertyArr = (array) $property;
            } else {
                $propertyArr = $property;
            }

            $imgs = !empty($propertyArr['imagens']) ? json_decode($propertyArr['imagens'], true) : [];
            if (is_array($imgs)) {
                $imgs = array_filter($imgs, fn($img) => file_exists(ROOTPATH . 'public/' . $img));
                $propertyArr['imagens'] = array_values($imgs);
            }

            // Converte de volta para objeto se necessário
            $property = (object) $propertyArr;
        }

        // Retorna objeto único se solicitado
        if ($singleObject && $returnObject) {
            return $properties[0];
        }

        return $properties;
    }

    function cleanMoney($value)
    {
        if (!$value) return 0;

        $value = str_replace(['R$', ' '], '', $value);

        $value = str_replace('.', '', $value);

        $value = str_replace(',', '.', $value);

        return floatval($value);
    }
}
