<?php

namespace App\Models;

use CodeIgniter\Model;

class PlansModel extends Model
{
    protected $table            = 'plans';
    protected $primaryKey       = 'id';

    protected $allowedFields = ['id', 'name', 'price', 'duration_days', 'max_properties', 'qtd_anuncio', 'qtd_destaque', 'is_featured', 'created_at'];

    public function getPlans() {
        $builder = $this->db->table($this->table);
        $builder->select("*");

        return $builder->get()->getResult();
    }
}
