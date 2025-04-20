<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PlansModel;

class Plans extends BaseController
{
    public function index()
    {
        $plans = $this->getPlansView();

        return view('plans', ['plans' => $plans]);
    }

    public function getPlansView() {
        $plansModel = new PlansModel();
        
        $plans = $plansModel->getPlans();
    
        return $plans;
    }
}
