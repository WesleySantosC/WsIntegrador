<?php

/* ALTER TABLE `users`.`imoveis` 
ADD COLUMN `imagens` JSON NULL AFTER `garage`;
 */
namespace App\Models;

use CodeIgniter\Model;

class ImovelModel extends Model
{
    protected $table = 'imoveis';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',           
        'rooms',             
        'bathrooms',         
        'suites',            
        'reference',         
        'value',             
        'footage',           
        'cep',               
        'neighborhood',      
        'state',             
        'city',              
        'address',
        'complement',           
        'title',             
        'description',       
        'imagens',           
        'garage',            
        'type_realty',       
        'deleted_at',        
        'disabled',
        'sale_type',         
        'created_at'
    ];


    public function getRealtyClient($user_id) {
        $builder = $this->db->table($this->table . " i");
        $builder->select("u.id, i.*, i.id as id_imovel, p.*");
        $builder->join("usuarios u", "u.id = i.user_id", "left");
        $builder->join("property_types p", "p.id = i.type_realty");
        $builder->where("u.id", $user_id);
        $builder->where("i.disabled", 0);

        return $builder->get()->getResult();
    }

    public function deleteRealty($realtyId) {
        $builder = $this->db->table($this->table);
        $builder->where('id', $realtyId);
        return $builder->update(['deleted_at' => 1]);
    }

    public function disableRealty($realtyId) {
        $builder = $this->db->table($this->table);
        $builder->where('id', $realtyId);
        return $builder->update(['disabled' => 1]);
    }

    public function listRealtyDisabledByClientId($user_id) {
        $builder = $this->db->table($this->table . " i");
        $builder->select("i.id as id_imovel, i.*, p.*");
        $builder->join("usuarios u", "u.id = i.user_id", "left");
        $builder->join("property_types p", "p.id = i.type_realty");
        $builder->where("i.disabled", 1);
        $builder->where("i.user_id", $user_id);

        return $this->getResult($builder);
    }

    public function activeRealty($realtyId) {
        $builder = $this->db->table($this->table);
        $builder->where('id', $realtyId);
        return $builder->update(['disabled' => 0]);
    }
    
    public function getRealtyUserId($user_id) {
        $builder = $this->db->table($this->table . " i");
        $builder->select('count(*) as total_realty');
        $builder->join("usuarios u", "u.id = i.user_id", "left");
        $builder->where("u.id", $user_id);
        $builder->where("i.disabled", 0);

        /*
            USAR PARA PRINTAR A QUERY:
            $this->printQuery($builder);
            die;
        */

        return $builder->get()->getRow();
    }

    public function getRealtyDisableUserId($user_id) {
        $builder = $this->db->table($this->table . " i");
        $builder->select('count(*) as total_realtyDisabled');
        $builder->join("usuarios u", "u.id = i.user_id", "left");
        $builder->where("u.id", $user_id);
        $builder->where("i.disabled", 1);

        
            //USAR PARA PRINTAR A QUERY:
            //$this->printQuery($builder);
            //die;
        

        return $this->getRow($builder);
    }

    public function getRealtyValue($user_id) {
        $builder = $this->db->table($this->table . " i");
        $builder->select('sum(i.value) as total_value');
        $builder->join("usuarios u", "u.id = i.user_id", "left");
        $builder->where("u.id", $user_id);
        $builder->where("i.disabled", 0);

        return $builder->get()->getRow();
    }

    public function generateLinkXml($user_id) {
        $builder = $this->db->table($this->table . " i");
        $builder->select("i.*, lm.id_usuario_gerou as usuario_gerou_xml");
        $builder->join("link_xml lm", "lm.id_usuario_gerou = i.user_id", "left");
        $builder->where("i.user_id", $user_id);

        return $builder->get()->getResult();
    }

    public function listInfoAds($idRealty)
    {
        $builder = $this->db->table($this->table . " i");
        $builder->select("*");
        $builder->where("i.id", $idRealty);

        return $this->getRow($builder);
    }

}
