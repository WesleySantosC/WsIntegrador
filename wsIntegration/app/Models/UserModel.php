<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nome', 'email', 'senha'];

    public function getInfoUsers($infoUser, $idenidentity) {
        
        $builder = $this->db->table($this->table . ' u');
        $builder->select('*');

        if($idenidentity == 'generate_xml') {
            $builder->where('u.id', $infoUser);
        } else {
            $builder->where('u.email', $infoUser);
        }

        $query = $builder->get()->getRow();
        return $query;

        // $query = $this->db->query("SELECT * FROM usuarios");
        // return $query->getRow();
    }

    public function insertByArray($data) {        
        $this->insert($data);
    }
}