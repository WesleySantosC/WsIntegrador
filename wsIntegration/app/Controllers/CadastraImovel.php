<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ImovelModel;

class CadastraImovel extends BaseController
{
    public function index()
    {
        if ($this->request->getMethod() === 'post') {
            return $this->validateField();
        }
    
        return view('cadastraImovel');
    }
    
    public function validateField()
{
    $data = $this->request->getPost();

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

    $imagePaths = [];
    $files = $this->request->getFiles();

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
        'usuario_id'           => session('usuario')['id'],
        'quantidade_quartos'   => $data['rooms'],
        'quantidade_banheiros' => $data['bathrooms'],
        'valor'                => $data['value'],
        'areaUtil'             => $data['footage'],
        'bairro'               => $data['neighborhood'],
        'estado'               => $data['state'],
        'cidade'               => $data['city'],
        'endereco'             => $data['address'],
        'titulo'               => $data['title'] ?: "Propriedade a venda",
        'descricao'            => $data['description'],
        'garagem'              => $data['garage'],
        //'imagem'               => implode(',', $imagePaths),
        'imagens'               => json_encode($imagePaths),
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
