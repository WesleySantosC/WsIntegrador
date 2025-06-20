<?php

namespace App\Models;

use CodeIgniter\Model;

class GenerateLinkXmlModel extends Model
{
    protected $table            = 'link_xml';
    protected $primaryKey       = 'id';
    
    protected $allowedFields = [
        'link',
        'id_usuario_gerou',
        'created_at',
        'update_at'
    ];

    protected $useTimestamps = false;


    public function generateXmlClient($data) {
        $builder = $this->db->table($this->table);    
        $builder->insert($data);
    }

    public function existXml($idUser) {
        $builder = $this->db->table($this->table);
        $builder->select("*");
        $builder->where("id_usuario_gerou", $idUser);

        return $builder->get()->getRow();
    }

}
