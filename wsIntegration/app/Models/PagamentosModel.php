<?php

namespace App\Models;

use CodeIgniter\Model;

class PagamentosModel extends Model
{
    protected $table            = 'pagamentos';
    protected $primaryKey       = 'id';

    protected $allowedFields = [
                                'id', 
                                'subscription_id', 
                                'payment_id', 
                                'value', 
                                'billing_type', 
                                'status',
                                'due_date',
                                'confirmed_at',
                                'created_at'
                            ];
}
