<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use SimpleXMLElement;
use App\Models\ImovelModel;
use App\Models\GenerateLinkXmlModel;
use App\Models\UserModel;
use DOMDocument;
use Exception;

class GenerateLinkXml extends BaseController
{
    public function index()
    {   
        $objUser = new UserModel();
        $userSession = session('usuario');

        if($userSession) {
            $identity    = 'generate_xml';
            $infoClients = (array) $objUser->getInfoUsers($userSession['id'], $identity);

            return view('generateLinkXml', ['infoClients' => $infoClients]);
        } else {
            return redirect()->to('/login')->with('erro', 'Você precisa estar logado para gerar um XML.');
        }
    }

    public function generate()
    {
        $result   = [];
        $partners = $this->post['partners'];
        
        
        try {

            if(!$partners) {
                throw new Exception("É necessário informar o padrão do XML");
            }

            $userId = session('usuario')['id'];
            $link   = $this->GenerateLink($userId, $partners);

            $result = [
                'status' => 'success',
                'link'   => $link
            ];
        } catch (\Throwable $e) {
            $result['error'] = $e->getMessage();
        }

        return $this->response->setJSON($result);
    }

    public function GenerateLink($userId, $partners)
    {
        $imovelModel = new ImovelModel();
        $imovelModel->resetQuery();
        $imoveis = $imovelModel->generateLinkXml($userId);

        $fileDir = FCPATH . "xml";
        $fileName = $fileDir . "/user_{$userId}.xml";

        if (!is_dir($fileDir)) {
            mkdir($fileDir, 0777, true);
        }

        if (file_exists($fileName)) {
            unlink($fileName);
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        if($partners == 'chaves_na_mao') {
            $root = $dom->createElement('Document');
            $dom->appendChild($root);

            $imoveisXml = $dom->createElement('imoveis');
            $root->appendChild($imoveisXml);

            foreach ($imoveis as $anuncio) {
                $imovel = $dom->createElement('imovel');
                $imoveisXml->appendChild($imovel);

                $imovel->appendChild($dom->createElement('referencia', $anuncio->reference));
                //$imovel->appendChild($dom->createElement('link_cliente', base_url("imovel/{$anuncio->reference}")));

                $titulo = $dom->createElement('titulo');
                $titulo->appendChild($dom->createCDATASection($anuncio->title));
                $imovel->appendChild($titulo);

                $transacao = ($anuncio->sale_type == 'Vende-se') ? 'V' : 'L';
                $imovel->appendChild($dom->createElement('transacao', $transacao));
                //$imovel->appendChild($dom->createElement('transacao2', ''));
                $imovel->appendChild($dom->createElement('finalidade', $anuncio->purpose));
                //$imovel->appendChild($dom->createElement('finalidade2', ''));
                $imovel->appendChild($dom->createElement('destaque', 0));
                $imovel->appendChild($dom->createElement('tipo', $anuncio->nameRealty));
                //$imovel->appendChild($dom->createElement('tipo2', ''));
                $imovel->appendChild($dom->createElement('valor', $anuncio->value));
                //$imovel->appendChild($dom->createElement('valor_locacao', ''));
                $imovel->appendChild($dom->createElement('valor_iptu', $anuncio->iptu));
                $imovel->appendChild($dom->createElement('valor_condominio', $anuncio->condominium ?? ''));
                $imovel->appendChild($dom->createElement('area_total', $anuncio->footage));
                //$imovel->appendChild($dom->createElement('area_util', $anuncio->usable_area ?? ''));
                //$imovel->appendChild($dom->createElement('conservacao', ''));
                $imovel->appendChild($dom->createElement('quartos', $anuncio->rooms));
                $imovel->appendChild($dom->createElement('suites', $anuncio->suites));
                $imovel->appendChild($dom->createElement('garagem', $anuncio->garage));
                $imovel->appendChild($dom->createElement('banheiro', $anuncio->bathrooms));
                //$imovel->appendChild($dom->createElement('closet', $anuncio->closet ?? 0));
                //$imovel->appendChild($dom->createElement('salas', ''));
                //$imovel->appendChild($dom->createElement('despensa', ''));
                //$imovel->appendChild($dom->createElement('bar', ''));
                //$imovel->appendChild($dom->createElement('cozinha', $anuncio->kitchen ?? 1));
                //$imovel->appendChild($dom->createElement('quarto_empregada', ''));
                //$imovel->appendChild($dom->createElement('escritorio', ''));
                //$imovel->appendChild($dom->createElement('area_servico', ''));
                //$imovel->appendChild($dom->createElement('lareira', ''));
                //$imovel->appendChild($dom->createElement('varanda', ''));
                //$imovel->appendChild($dom->createElement('lavanderia', ''));
                //$imovel->appendChild($dom->createElement('aceita_pet', 1));
                $imovel->appendChild($dom->createElement('estado', $anuncio->uf ?? ''));
                $imovel->appendChild($dom->createElement('cidade', $anuncio->city ?? ''));
                $imovel->appendChild($dom->createElement('bairro', $anuncio->neighborhood));
                $imovel->appendChild($dom->createElement('cep', $anuncio->cep));
                $imovel->appendChild($dom->createElement('endereco', $anuncio->address));
                $imovel->appendChild($dom->createElement('numero', $anuncio->number ?? ''));
                $imovel->appendChild($dom->createElement('complemento', $anuncio->complement ?? ''));
                $imovel->appendChild($dom->createElement('esconder_endereco_imovel', $anuncio->hide_address ?? 0));

                $descritivo = $dom->createElement('descritivo');
                $descritivo->appendChild($dom->createCDATASection($anuncio->description));
                $imovel->appendChild($descritivo);

                $fotosNode = $dom->createElement('fotos_imovel');

                $imagens = $anuncio->imagens;

                if (is_string($imagens)) {
                    $imagens = json_decode($imagens, true);
                }

                if (is_array($imagens) && count($imagens) > 0) {
                    foreach ($imagens as $img) {
                        $foto = $dom->createElement('foto');
                        $foto->appendChild($dom->createElement('url', base_url($img)));
                        $foto->appendChild($dom->createElement('data_atualizacao', date('Y-m-d H:i:s')));
                        $fotosNode->appendChild($foto);
                    }
                }

                $imovel->appendChild($fotosNode);

                //$imovel->appendChild($dom->createElement('data_atualizacao', ''));
                //$imovel->appendChild($dom->createElement('latitude', ''));
                //$imovel->appendChild($dom->createElement('longitude', ''));
                //$imovel->appendChild($dom->createElement('video', ''));
                //$imovel->appendChild($dom->createElement('tour_360', ''));

                // Área comum
                //$areaComum = $dom->createElement('area_comum');
                //$areaComum->appendChild($dom->createElement('item', 'Academia'));
                //$areaComum->appendChild($dom->createElement('item', 'Acessibilidade'));
                //$imovel->appendChild($areaComum);

                //$areaPrivativa = $dom->createElement('area_privativa');
                //$areaPrivativa->appendChild($dom->createElement('item', 'Adega'));
                //$areaPrivativa->appendChild($dom->createElement('item', 'Aquecedor'));
                //$imovel->appendChild($areaPrivativa);

                //$imovel->appendChild($dom->createElement('aceita_troca', ''));
                //$imovel->appendChild($dom->createElement('periodo_locacao', ''));
            }
        } else {
            die("Em desenvolvimento!");
        }
        

        $dom->save($fileName);

        $link = base_url("xml/user_{$userId}.xml");
        
        $linkModel = new GenerateLinkXmlModel();
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
