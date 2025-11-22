<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\ImovelModel;
use App\Models\GenerateLinkXmlModel;

class RegenerateXml extends BaseCommand
{
    protected $group       = 'XML';
    protected $name        = 'xml:regenerate';
    protected $description = 'Remove todos os XMLs e gera novos baseados nos imóveis.';

    public function run(array $params)
    {
        helper('filesystem');

        $xmlPath = FCPATH . 'xml/';

        echo "Removendo arquivos XML existentes... \n";
        echo "================================ \n";
        
        delete_files($xmlPath); 

        echo "Arquivos removidos! \n";
        echo "================================ \n";

        $linkModel   = new GenerateLinkXmlModel();

        $usuarios = $linkModel->findAll();

        foreach ($usuarios as $user) {
            echo "Gerando XML para usuário " . $user['id_usuario_gerou'] . "\n";
            echo "-------------------------- \n";

            $this->generateXmlForUser($user['id_usuario_gerou']);

            echo "XML Gerado! \n";
        }

        echo "================================ \n";

        echo "Processo Regeneração de XML Finalizado! \n";
    }

    private function generateXmlForUser($userId)
    {
        $imovelModel = new ImovelModel();
        $imoveis     = $imovelModel->generateLinkXml($userId);

        $xml = new \SimpleXMLElement('<imoveis/>');

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
            $imovel->addChild('imagens', $anuncio->imagens);
            $imovel->addChild('garagem', $anuncio->garage);
            $imovel->addChild('titulo', $anuncio->title);
            $imovel->addChild('descricao', $anuncio->description);
            $imovel->addChild('criado_em', $anuncio->created_at);
        }

        $fileName = FCPATH . "xml/user_{$userId}.xml";

        $xml->asXML($fileName);
    }
}
