<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Admin;
use Illuminate\Http\Request;

class CalcProfitController extends Controller
{
    public function index(){
        $employess = Admin:: where('account_type', 'employee')->get();
        return view('dashboard.calc.index', compact('employess'));
    }
}
