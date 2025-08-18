<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ApiXml extends BaseController
{
    public function showXmlForTheThirdPlataform($userId = null)
    {
        $filePath = FCPATH . "xml/user_{$userId}.xml";

        if (!file_exists($filePath)) {
            return $this->response
                ->setStatusCode(404)
                ->setBody("XML não encontrado para este usuário.");
        }

        return $this->response
            ->setContentType('application/xml')
            ->setBody(file_get_contents($filePath));
    }
}
