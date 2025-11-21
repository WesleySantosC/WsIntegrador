<?php

namespace App\Controllers;

use App\Models\PagamentosModel;
use App\Models\SubscriptionTypes;

class AsaasWebhook extends BaseController
{
    public function index()
    {
        log_message('info', '[ASAAS WEBHOOK] Sem validação de token ativa.');

        $json = $this->request->getJSON();

        if (!$json) {
            return $this->response->setJSON(['error' => 'Invalid JSON']);
        }

        $event = $json->event ?? null;

        if (!$event) {
            return $this->response->setJSON(['error' => 'No event received']);
        }

        log_message('info', '[ASAAS WEBHOOK RECEIVED] ' . json_encode($json));

        switch ($event) {

            case "PAYMENT_CREATED":
                $this->onPaymentCreated($json->payment);
                break;

            case "PAYMENT_RECEIVED":
            case "PAYMENT_CONFIRMED":
                $this->onPaymentPaid($json->payment);
                break;

            case "PAYMENT_OVERDUE":
                $this->onPaymentOverdue($json->payment);
                break;

            case "SUBSCRIPTION_INACTIVE":
                $this->onSubscriptionInactive($json->subscription);
                break;

            default:
                log_message('warning', "[ASAAS] Evento não tratado: $event");
        }

        return $this->response->setJSON(['success' => true]);
    }

    private function onPaymentCreated($p)
    {
        $model = new PagamentosModel();

        $model->insert([
            "subscription_id" => $p->subscription ?? null,
            "payment_id"      => $p->id,
            "value"           => $p->value,
            "billing_type"    => $p->billingType ?? "UNKNOWN",
            "status"          => $p->status,
            "due_date"        => $p->dueDate ?? null,
            "created_at"      => date("Y-m-d H:i:s")
        ]);

        log_message('info', "[ASAAS] Pagamento criado salvo: {$p->id}");
    }

    private function onPaymentPaid($p)
    {
        $payModel = new PagamentosModel();
        $subModel = new SubscriptionTypes();

        $payModel->where("payment_id", $p->id)
            ->set([
                "status"       => "CONFIRMED",
                "confirmed_at" => date("Y-m-d H:i:s")
            ])
            ->update();

        if (!empty($p->subscription)) {
            $subModel->where("subscription_id", $p->subscription)
                ->set([
                    "status"            => "ACTIVE",
                    "last_payment_date" => $p->dueDate
                ])
                ->update();
        }

        log_message('info', "[ASAAS] Pagamento confirmado atualizado: {$p->id}");
    }

    private function onPaymentOverdue($p)
    {
        $model = new PagamentosModel();

        $model->where("payment_id", $p->id)
            ->set(["status" => "OVERDUE"])
            ->update();

        log_message('info', "[ASAAS] Pagamento atrasado: {$p->id}");
    }

    private function onSubscriptionInactive($s)
    {
        $subModel = new SubscriptionTypes();

        $subModel->where("subscription_id", $s->id)
            ->set(["status" => "CANCELLED"])
            ->update();

        log_message('info', "[ASAAS] Assinatura cancelada: {$s->id}");
    }
}
