<?php

namespace App\Models;

use CodeIgniter\Model;

class TiposPagamentosModel extends Model
{
    protected $table            = 'tipos_pagamentos';
    protected $primaryKey       = 'id';

    protected $allowedFields    = ['id', 'nome', 'descricao', 'criado_em'];

}
