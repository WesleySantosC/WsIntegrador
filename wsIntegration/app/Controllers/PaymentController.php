<?php

namespace App\Controllers;

use App\Models\PlansModel;
use App\Models\PagamentosModel;
use App\Models\TiposPagamentosModel;
use App\Models\UserModel;
use App\Models\SubscriptionTypes;

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

        return view('payment', ['plan' => $plan, 'payments' => $payments]);
    }

    public function returnStatus()
    {
        try {
            $this->createClientAsaas();
            return $this->response->setJSON(['status' => 'success']);
        } catch (\Throwable $e) {
            log_message('error', 'PaymentController::returnStatus error: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function createClientAsaas()
    {
        $post = $this->request->getPost();

        $planId = $post["plano_id"] ?? null;
        $value  = $post["valor"] ?? null;
        $nameCustomer = $post["nome"] ?? null;
        $emailCustomer  = $post["email"] ?? null;
        $phoneCustomer = $post["telefone"] ?? null;
        $cpfCnpj = $post["cpfCnpj"] ?? null;
        $cep = $post["cep"] ?? null;
        $typePayment = $post["tipo_pagamento"] ?? null; 

        if (!$planId || !$value || !$nameCustomer || !$emailCustomer || !$phoneCustomer || !$cpfCnpj || !$cep || !$typePayment) {
            throw new \Exception("Está faltando alguma informação! Por gentileza revise os dados");
        }

        $payload = [
            "name"        => $nameCustomer,
            "cpfCnpj"     => $cpfCnpj,
            "email"       => $emailCustomer,
            "mobilePhone" => $phoneCustomer,
            "postalCode"  => $cep,
            "id_plan"     => $planId
        ];

        $this->requestCreateClientAsaas($payload, $typePayment, $value);
    }

    /**
     * @param object $infoClient  Objeto retornado do Asaas (cliente) — já decodificado (stdClass)
     * @param string $typePayment valor vindo do front (ex: 'cartao credito','boleto','pix')
     * @param float  $planValue
     * @param int    $id_plan
     */
    public function createMonthly($infoClient, $typePayment, $planValue, $id_plan)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $userModel = new UserModel();
        $subModel = new SubscriptionTypes();

        $customerAsaasId = $infoClient->id ?? null;
        if (!$customerAsaasId) {
            throw new \Exception("Cliente inválido recebido do Asaas.");
        }

        $exists = $userModel->where('email', $infoClient->email)->first();
        if ($exists) {
            throw new \Exception("Já existe usuário com este e-mail.");
        }

        $userData = [
            'nome'     => $infoClient->name ?? null,
            'email'    => $infoClient->email ?? null,
            'asaas_id' => $customerAsaasId,
            'cpf_cnpj' => $infoClient->cpfCnpj ?? null,
            'telefone' => $infoClient->mobilePhone ?? null,
            'cidade'   => $infoClient->cityName ?? null,
            'estado'   => $infoClient->state ?? null,
            'endereco' => $infoClient->address ?? null,
            'cep'      => $infoClient->postalCode ?? null
        ];

        $userModel->insert($userData);
        $localUserId = $userModel->getInsertID();

        $normalized = strtolower($typePayment);
        if (strpos($normalized, 'cartao') !== false || strpos($normalized, 'credito') !== false) {
            $billingType = 'CREDIT_CARD';
        } elseif (strpos($normalized, 'boleto') !== false) {
            $billingType = 'BOLETO';
        } else {
            $billingType = 'BOLETO';
        }

        $nextDueDate = $this->nextDueDate(date('Y-m-d'));

        $dto = new CreateLeanPaymentDTO(
            $customerAsaasId,
            $billingType,
            (string)$planValue,
            $nextDueDate
        );

        $subscriptionResponse = $this->requestCreateMonthly($dto);
        log_message('info', "Create subscription response: " . $subscriptionResponse);

        $subscriptionData = json_decode($subscriptionResponse);
        if (!$subscriptionData || !isset($subscriptionData->id)) {
            // registra o erro e aborta
            throw new \Exception("Erro ao criar assinatura no Asaas: " . $subscriptionResponse);
        }

        $subscriptionId = $subscriptionData->id;

        $subInsert = [
            'customer_id_asaas' => $customerAsaasId,
            'subscription_id'   => $subscriptionId,
            'id_plan'           => $id_plan,
            'value'             => $planValue,
            'billing_type'      => $billingType,
            'status'            => $subscriptionData->status ?? 'PENDING',
            'next_due_date'     => $subscriptionData->nextDueDate ?? $nextDueDate,
            'last_payment_date' => null
        ];

        $subModel->insert($subInsert);
        $subLocalId = $subModel->getInsertID();

        return $this->response->setJSON([
            'status' => 'ok',
            'subscription_local_id' => $subLocalId,
            'subscription_id' => $subscriptionId,
            'next_due_date' => $subInsert['next_due_date']
        ]);
    }

    /**
     * @param array $infoClient payload para criar cliente no Asaas
     * @param string $typePayment
     * @param float $planValue
     */
    public function requestCreateClientAsaas($infoClient, $typePayment, $planValue)
    {
        helper('curl');

        $url = "https://api-sandbox.asaas.com/v3/customers";
        $method = "POST";

        $response = curlRequest($url, $method, $infoClient);

        if (!$response) {
            throw new \Exception("Erro ao criar cliente no Asaas.");
        }

        $client = json_decode($response);
        if (!isset($client->id)) {
            throw new \Exception("Erro na criação do cliente: " . $response);
        }

        return $this->createMonthly($client, $typePayment, $planValue, $infoClient['id_plan'] ?? null);
    }

    /**
     * @param CreateLeanPaymentDTO $infoClient
     * @return string
     */
    public function requestCreateMonthly(CreateLeanPaymentDTO $infoClient)
    {
        helper('curl');

        $url     = "https://api-sandbox.asaas.com/v3/subscriptions";
        $method  = "POST";

        $payload = [
            "customer"    => $infoClient->customer,
            "billingType" => $infoClient->billingType,
            "value"       => $infoClient->value,
            "cycle"       => "MONTHLY",
            "nextDueDate" => $infoClient->dueDate
        ];

        $response = curlRequest($url, $method, $payload);

        log_message("info", "ASSINATURA RESPONSE: " . $response);

        return $response;
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
