<?php

namespace App\Models;

use CodeIgniter\Model;

class Cities extends Model
{
    protected $table            = 'cities';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['state_id', 'name'];

    public function getListCities() {
        $builder = $this->db->table($this->table . " c");
        $builder->select("*");

        return $this->getResult($builder);
    }

}
