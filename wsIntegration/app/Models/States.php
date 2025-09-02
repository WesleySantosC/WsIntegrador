<?php

namespace App\Models;

use CodeIgniter\Model;

class States extends Model
{
    protected $table            = 'states';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['code', 'name'];

    public function getListStates() {
        $builder = $this->db->table($this->table . " s");
        $builder->select("*");

        return $this->getResult($builder);
    }
}
