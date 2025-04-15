<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use SimpleXMLElement;
use App\Models\ImovelModel;
use App\Models\GenerateLinkXmlModel;
class GenerateLinkXml extends BaseController
{
    public function index()
    {
        $userId = session('usuario')['id'];
        $link = $this->GenerateLink($userId);
    
        return view('generateLinkXml', ['link' => $link]);
    }
    

    public function GenerateLink($userId) {
        $imovelModel = new ImovelModel();
        $linkModel   = new GenerateLinkXmlModel();
        $imoveis = $imovelModel->generateLinkXml($userId);
        
        // Criar o XML
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

        $link = base_url("xml/user_{$userId}.xml"); 
        
        $data = [
            'link' => $link,
            'id_usuario_gerou' => $userId,
            'update_at' => date('Y-m-d H:i:s')
        ];
        
        $linkModel->generateXmlClient($data);

        return $link;
    }
}
