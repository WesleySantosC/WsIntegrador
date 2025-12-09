<?php

namespace App\Models;

use CodeIgniter\Model;

class PagamentosModel extends Model
{
    protected $table            = 'pagamentos';
    protected $primaryKey       = 'id';

    protected $allowedFields = [
                                'subscription_id', 
                                'payment_id', 
                                'value', 
                                'billing_type', 
                                'status',
                                'due_date',
                                'invoice_url',
                                'confirmed_at',
                                'created_at'
                            ];

    public function getMonthlyFeeByIdClientAsaas($IdClientAsaas) {
        $builder = $this->db->table($this->table . " p");
        $builder->select("*, p.status as payment_status");
        $builder->join("subscription_types st", "st.subscription_id = p.subscription_id", "inner");
        $builder->join("usuarios u", "u.asaas_id = st.customer_id_asaas", "inner");
        $builder->join("plans plan", "plan.id = st.id_plan", "inner");
        $builder->where("u.asaas_id", $IdClientAsaas);

        return $this->getResult($builder);
    }

}
