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

    protected $useTimestamps = true;


    public function generateXmlClient($data) {
        $builder = $this->db->table($this->table);    
        $builder->insert($data);
    }

}
