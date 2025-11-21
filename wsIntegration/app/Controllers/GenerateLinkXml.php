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
        $userSession = session('usuario');

        if($userSession) {
            $identity = 'generate_xml';
            $infoClients = (array) $objUser->getInfoUsers($userSession['id'], $identity);
            return view('generateLinkXml', ['infoClients' => $infoClients]);
        } else {
            return redirect()->to('/login')->with('erro', 'Você precisa estar logado para gerar um XML.');
        }
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
            $imovel->addChild('quartos', $anuncio->rooms);
            $imovel->addChild('banheiros', $anuncio->bathrooms);
            $imovel->addChild('suites', $anuncio->suites);
            $imovel->addChild('referencia', $anuncio->reference);
            $imovel->addChild('valor', $anuncio->value);
            $imovel->addChild('areraUtil', $anuncio->footage);
            $imovel->addChild('desativado', $anuncio->disabled);
            $imovel->addChild('cep', $anuncio->cep);
            $imovel->addChild('bairro', $anuncio->neighborhood);
            $imovel->addChild('estado', $anuncio->state);
            $imovel->addChild('cidade', $anuncio->city);
            $imovel->addChild('endereco', $anuncio->address);
            $imovel->addChild('garagem', $anuncio->garage);
            $imovel->addChild('titulo', $anuncio->title);
            $imovel->addChild('descricao', $anuncio->description);
            $imovel->addChild('criado_em', $anuncio->created_at);
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
