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
}
