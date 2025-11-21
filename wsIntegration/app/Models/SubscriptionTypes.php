<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionTypes extends Model
{
    protected $table            = 'subscription_types';
    protected $primaryKey       = 'id';
    
    protected $allowedFields = [
                                'id',
                                'customer_id_asaas',
                                'subscription_id', 
                                'id_plan', 
                                'value', 
                                'billing_type',
                                'status', 
                                'next_due_date', 
                                'last_payment_date', 
                                'created_at', 
    ];


}
