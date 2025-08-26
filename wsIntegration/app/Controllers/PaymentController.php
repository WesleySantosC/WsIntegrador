<?php

namespace App\Controllers;

use App\Models\PlansModel;
use App\Models\PagamentosModel;
use App\Models\TiposPagamentosModel;
use App\Models\UserModel;

class CreateLeanPaymentDTO {
    public string $customer;
    public string $billingType;
    public string $value;
    public string $dueDate;

    public function __construct($customerId, $billingType, $value, $dueDate) {
        $this->customer = $customerId;
        $this->billingType = $billingType;
        $this->value = $value;
        $this->dueDate = $dueDate;
    }
    
}

class PaymentController extends BaseController
{

    public function choose($id)
    {
        $plansModel = new PlansModel();
        $typePayments = new TiposPagamentosModel();
        $plan = $plansModel->find($id);
        $payments = $typePayments->findAll(); 
        
        if (!$plan) {
            return "Plano não encontrado.";
        }
        
        return view('payment', ['plan' => $plan,  'payments' => $payments]);
    }

    public function returnStatus() {
        // TO DO: ENTENDER O PORQUE NÃO ESTA INSERINDO OS CLIENTES NO ASAAS...
        $result = [];

        try {
            $this->createClientAsaas();
            $result = ['status' => 'success'];
        } catch (\Throwable $e) {
            $result['error'] = $e->getMessage();
        }

        return $this->response->setJSON($result);
    }

    public function createClientAsaas()
    {
        $getInfo = $this->post;

        $planId = $getInfo["plano_id"];
        $value  =  $getInfo["valor"];
        $nameCustomer = $getInfo["nome"];
        $emailCustomer  = $getInfo["email"];
        $phoneCustomer = $getInfo["telefone"];
        $cpfCnpj = $getInfo["cpfCnpj"];
        $cep = $getInfo["cep"];
        $typePayment = $getInfo["tipo_pagamento"];

        if (!$planId || !$value || !$nameCustomer || !$emailCustomer || !$phoneCustomer || !$cpfCnpj || !$cep || !$typePayment) {
            return "Está faltando alguma informação! Por gentileza revise os dados";
        }

        $data = [
            "name" => $nameCustomer,
            "cpfCnpj" => $cpfCnpj,
            "email" => $emailCustomer,
            "mobilePhone" => $phoneCustomer,
            "postalCode" => $cep
        ];

        $this->requestCreateClientAsaas($data, $typePayment, $value);
    }

    public function createMonthly($infoClient, $typePayment, $planValue) {

        $user = new UserModel();
        $infoClient = json_decode($infoClient);
        $idCustomer = $infoClient->id;
        $idenidentity = 'payment';
        $withEmail = $user->getInfoUsers($infoClient->email, $idenidentity);

        if($withEmail) {
            throw new \Exception("Já possui um usuário utilizando este e-mail!");  
        } else {
            $dataInsert = [
                'nome'     => $infoClient->name,
                'email'    => $infoClient->email,
                'asaas_id' => $idCustomer
            ];

            $user->insertByArray($dataInsert);
        }

        $dates = date('Y-m-d'); 
        $date = $this->nextDueDate($dates);

        if($typePayment == 'cartao credito') {
            $typePayment = 'CREDIT_CARD';
        } else {
            $typePayment = 'PIX';
        }

        $data = [
            "customer_id"  => $idCustomer,
            "billing_type" => $typePayment,
            "valuePlan"    => $planValue,
            "created_at"   => $date
        ];

        $leanPayment = new CreateLeanPaymentDTO(
            $idCustomer, 
            $typePayment, 
            $planValue, 
            $date
        );

        $this->requestCreateMonthly($leanPayment);
        $paymentModel = new PagamentosModel();
        $paymentModel->insert($data);
    }

    public function requestCreateClientAsaas($infoClient, $typePayment, $planValue)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api-sandbox.asaas.com/v3/customers",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($infoClient),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                'access_token: $aact_hmlg_000MzkwODA2MWY2OGM3MWRlMDU2NWM3MzJlNzZmNGZhZGY6OjhiMjI0NDNmLTYwOTEtNDJjNy04MGNiLTE2M2ZlNWZmNmY5ZDo6JGFhY2hfM2QxMTE5MGQtMWUzMS00YTE4LThmNzgtZTg1MTY5YTRhN2Ix',
                'User-Agent: WsIntegracoes/1.0'
            ],
        ]);

        $response = curl_exec($curl);
        
        $err = curl_error($curl);
        
        curl_close($curl);

        if ($err) {
            return "cURL Error #: " . $err;
        }

        if($response) {
            $this->createMonthly($response, $typePayment, $planValue);
        }
    }

    public function requestCreateMonthly(CreateLeanPaymentDTO $infoClient) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api-sandbox.asaas.com/v3/lean/payments",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($infoClient),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                'access_token: $aact_hmlg_000MzkwODA2MWY2OGM3MWRlMDU2NWM3MzJlNzZmNGZhZGY6OjhiMjI0NDNmLTYwOTEtNDJjNy04MGNiLTE2M2ZlNWZmNmY5ZDo6JGFhY2hfM2QxMTE5MGQtMWUzMS00YTE4LThmNzgtZTg1MTY5YTRhN2Ix',
                'User-Agent: WsIntegracoes/1.0'

            ],
        ]);

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #: " . $err;
        }
    }

    function nextDueDate($dateEntry) {
        $daysRule = [5, 10, 15, 20, 25, 28];

        $date = new \DateTime($dateEntry);
        $day = (int)$date->format('d');
        $month = (int)$date->format('m');
        $year = (int)$date->format('Y');

        foreach ($daysRule as $dayRule) {
            if ($day <= $dayRule) {
                return \DateTime::createFromFormat('Y-n-j', "$year-$month-$dayRule")->format('Y-m-d');
            }
        }

        $month++;
        if ($month > 12) {
            $month = 1;
            $year++;
        }

        $dayFormatted = sprintf('%02d', $daysRule[0]);
        $monthFormatted = sprintf('%02d', $month);
        return \DateTime::createFromFormat('Y-m-d', "$year-$monthFormatted-$dayFormatted")->format('Y-m-d');
    }

}
