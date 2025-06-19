<?php

namespace App\Models;

use CodeIgniter\Model;

class PagamentosModel extends Model
{
    protected $table            = 'pagamentos';
    protected $primaryKey       = 'id';

    protected $allowedFields = ['customer_id', 'billing_type', 'valuePlan', 'created_at'];
}
