<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nome', 'email', 'senha'];

    public function getInfoUsers($idUser) {
        
        $builder = $this->db->table($this->table . ' u');
        $builder->select('*');
        $builder->where('u.id', $idUser);
        $query = $builder->get()->getRow();
        return $query;

        // $query = $this->db->query("SELECT * FROM usuarios");
        // return $query->getRow();
        
    }
}