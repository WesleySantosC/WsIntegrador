<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table            = 'contatos';
    protected $primaryKey       = 'id';

    protected $allowedFields    = ['nome', 'telefone', 'email', 'solicitacao', 'criado_em'];

    
}
