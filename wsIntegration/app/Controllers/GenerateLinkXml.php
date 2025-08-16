<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use SimpleXMLElement;
use App\Models\ImovelModel;
use App\Models\GenerateLinkXmlModel;
use App\Models\UserModel;

class GenerateLinkXml extends Controller
{
    public function index()
    {   
        $objUser = new UserModel();
        $userId = session('usuario')['id'];

        $identity = 'generate_xml';

        $infoClients = (array) $objUser->getInfoUsers($userId, $identity);
        return view('generateLinkXml', ['infoClients' => $infoClients]);
    }

    public function generate()
    {
        $result = [];

        try {
            $userId = session('usuario')['id'];
            $link = $this->GenerateLink($userId);

            $result = [
                'status' => 'success',
                'link' => $link
            ];
        } catch (\Throwable $e) {
            $result['error'] = $e->getMessage();
        }

        return $this->response->setJSON($result);
    }

    public function GenerateLink($userId)
    {
        $imovelModel = new ImovelModel();
        $linkModel   = new GenerateLinkXmlModel();
        $imoveis     = $imovelModel->generateLinkXml($userId);

        // Gera o XML sempre
        $xml = new SimpleXMLElement('<imoveis/>');
        foreach ($imoveis as $anuncio) {
            $imovel = $xml->addChild('imovel');
            $imovel->addChild('id', $anuncio->id);
            $imovel->addChild('quartos', $anuncio->quantidade_quartos);
            $imovel->addChild('banheiros', $anuncio->quantidade_banheiros);
            $imovel->addChild('suites', $anuncio->quantidade_suites);
            $imovel->addChild('referencia', $anuncio->referencia);
            $imovel->addChild('valor', $anuncio->valor);
            $imovel->addChild('areraUtil', $anuncio->areaUtil);
            $imovel->addChild('desativado', $anuncio->desativado);
            $imovel->addChild('cep', $anuncio->cep);
            $imovel->addChild('bairro', $anuncio->bairro);
            $imovel->addChild('estado', $anuncio->estado);
            $imovel->addChild('cidade', $anuncio->cidade);
            $imovel->addChild('endereco', $anuncio->endereco);
            $imovel->addChild('garagem', $anuncio->garagem);
            $imovel->addChild('titulo', $anuncio->titulo);
            $imovel->addChild('descricao', $anuncio->descricao);
            $imovel->addChild('criado_em', $anuncio->criado_em);
        }

        $fileName = FCPATH . "xml/user_{$userId}.xml";
        if (!is_dir(FCPATH . 'xml')) {
            mkdir(FCPATH . 'xml', 0777, true);
        }
        $xml->asXML($fileName);

        $link = $this->wwwroot . "xml/user_{$userId}.xml";

        $data = [
            'link' => $link,
            'id_usuario_gerou' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s')
        ];

        $existRealty = $linkModel->existXml($userId);

        if ($existRealty) {
            $linkModel->update($existRealty->id, $data);
        } else {
            $linkModel->generateXmlClient($data);
        }

        return $link;
    }
}
