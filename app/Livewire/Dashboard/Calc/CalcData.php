<?php

namespace App\Livewire\Dashboard\Calc;

use Livewire\Component;

class CalcData extends Component
{
    public $net_profit = 0;
    public $total_income = 0 , $total_salaries = 0 , $other_expenses = 0;
    public function render()
    {
        $total_income = floatval($this->total_income);
        $total_salaries = floatval($this->total_salaries);
        $other_expenses = floatval($this->other_expenses);
        $this->net_profit =  $total_income - $total_salaries - $other_expenses;
        return view('dashboard.calc.calc-data');
    }
}
