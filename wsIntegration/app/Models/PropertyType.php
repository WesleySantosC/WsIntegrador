<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyType extends Model
{
    protected $table            = 'property_types';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['name'];

    public function getListProperty() {
        $builder = $this->db->table($this->table . " pt");
        $builder->select("*");

        return $this->getResult($builder);
    }
}
