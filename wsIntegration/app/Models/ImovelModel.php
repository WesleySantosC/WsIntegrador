<?php

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
        'garagem'
    ];

    protected $createdField = 'criado_em';

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

}
