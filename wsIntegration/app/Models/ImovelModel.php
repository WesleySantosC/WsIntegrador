<?php

/* ALTER TABLE `users`.`imoveis` 
ADD COLUMN `imagens` JSON NULL AFTER `garagem`;
 */
namespace App\Models;

use CodeIgniter\Model;

class ImovelModel extends Model
{
    protected $table = 'imoveis';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'usuario_id',
        'quantidade_quartos',
        'quantidade_banheiros',
        'quantidade_suites',
        'referencia',
        'valor',
        'areaUtil',
        'cep',
        'bairro',
        'estado',
        'cidade',
        'endereco',
        'titulo',
        'descricao',
        'imagem',
        'imagens',
        'garagem',
        'tipo',
        'tipo_venda'
    ];

    protected $createdField = 'criado_em';

    public function getRealtyClient($user_id) {
        $builder = $this->db->table($this->table . " i");
        $builder->select("u.id, i.*, i.id as id_imovel");
        $builder->join("usuarios u", "u.id = i.usuario_id", "left");
        $builder->where("u.id", $user_id);
        $builder->where("i.desativado", 0);

        return $builder->get()->getResult();
    }

    public function deleteRealty($realtyId) {
        $builder = $this->db->table($this->table);
        $builder->where('id', $realtyId);
        return $builder->update(['deletado' => 1]);
    }

    public function disableRealty($realtyId) {
        $builder = $this->db->table($this->table);
        $builder->where('id', $realtyId);
        return $builder->update(['desativado' => 1]);
    }
    
    public function getRealtyUserId($user_id) {
        $builder = $this->db->table($this->table . " i");
        $builder->select('count(*) as total_imoveis');
        $builder->join("usuarios u", "u.id = i.usuario_id", "left");
        $builder->where("u.id", $user_id);

        return $builder->get()->getRow();
    }

    public function getRealtyValue($user_id) {
        $builder = $this->db->table($this->table . " i");
        $builder->select('sum(i.valor) as total_valor');
        $builder->join("usuarios u", "u.id = i.usuario_id", "left");
        $builder->where("u.id", $user_id);

        return $builder->get()->getRow();
    }

    public function generateLinkXml($user_id) {
        $builder = $this->db->table($this->table . " i");
        $builder->select("i.*, lm.id_usuario_gerou as usuario_gerou_xml");
        $builder->join("link_xml lm", "lm.id_usuario_gerou = i.usuario_id", "left");
        $builder->where("i.usuario_id", $user_id);

        return $builder->get()->getResult();
    }

}
