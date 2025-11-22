<?php

namespace App\Models;

use CodeIgniter\Model;

class PlansModel extends Model
{
    protected $table            = 'plans';
    protected $primaryKey       = 'id';

    protected $allowedFields = ['id', 
                                'name', 
                                'price', 
                                'duration_days', 
                                'max_properties', 
                                'qtd_anuncio', 
                                'qtd_destaque', 
                                'is_featured', 
                                'created_at'
                            ];

    public function getPlans() {
        $builder = $this->db->table($this->table . " p");
        $builder->select("*");
        $builder->where("p.visible_plan", 1);

        return $builder->get()->getResult();
    }

    public function obtainThePlanChosenByTheCustomer($idUser) {
        $builder = $this->db->table($this->table . " p");
        $builder->select("
                          p.qtd_anuncio,
                          p.qtd_destaque"
                        );
        $builder->join("subscription_types st", "st.id_plan = p.id", "inner");
        $builder->join("usuarios u", "u.asaas_id = st.customer_id_asaas", "inner");
        $builder->where("u.id", $idUser);

        return $this->getRow($builder);
    }
}
