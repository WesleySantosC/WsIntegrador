<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use DateTime;
use App\Models\ContactModel;

class Contact extends BaseController
{
    public function index()
    {
        return view('contact');
    }

    public function registerContact()
    {
        $objContact = new ContactModel();
        $date = (new DateTime())->format('Y-m-d H:i:s');
        $result = [];

        try {
            $data      = $this->post;
            $name      = $data['nome'];
            $email     = $data['email'];
            $phone     = $data['phone'];
            $question  = $data['question'];

            if (!$name || !$email || !$phone || !$question) {
                throw new \Exception("Revise as informações inseridas, por gentileza!");
                
            }

            $name = mb_strtolower($name, 'UTF-8');
            $name = ucwords($name);

            if ($phone) {
                $caracteres_a_remover = ["(", ")", " ", "-"];
                $phone = str_replace($caracteres_a_remover, "", $phone);
            }

            $insertData = [
                'nome' => $name,
                'telefone' => $phone,
                'email' => $email,
                'solicitacao' => $question,
                'criado_em' => $date
            ];

            $objContact->insert($insertData);

            $result = ['status' => 'success'];
        } catch (\Throwable $e) {
            $result['error'] = $e->getMessage();
        }

        return $this->response->setJSON($result);
    }
}
