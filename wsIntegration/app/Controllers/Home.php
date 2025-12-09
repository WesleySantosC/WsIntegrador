<?php

namespace App\Controllers;
use App\Models\PlansModel;

class Home extends BaseController
{
    public function index(): string
    {
        $plans = $this->getPlansView();
        
        return view('sobre', ['plans' => $plans]);
    }

    public function getPlansView() {
        $plansModel = new PlansModel();
        
        $plans = $plansModel->getPlans();
    
        return $plans;
    }
}
