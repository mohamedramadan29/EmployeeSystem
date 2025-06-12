<?php

namespace App\Livewire\Dashboard\Tasks;

use Livewire\Component;
use App\Models\dashboard\Task;
use App\Models\dashboard\Admin;

class TaskDataComp extends Component
{

    public $employees,$tasks,$status='all',$employee_id='all',$month='all';

    public function mount()
    {
        $this->employees = Admin::where('account_type', 'employee')->get();
        $this->tasks = Task::orderBy('id', 'desc')->get();
    }
    public function updated()
    {
        $query = Task::orderBy('id', 'desc');
        if ($this->status != 'all') {
            $query->where('status', $this->status);
        }
        if ($this->employee_id != 'all') {
            $query->where('employe_id', $this->employee_id);
        }
        if ($this->month != 'all') {
            $query->whereMonth('start_date', $this->month);
        }
        $this->tasks = $query->get();
    }

    public function render()
    {

        return view('dashboard.tasks.task-data-comp');
    }
}
