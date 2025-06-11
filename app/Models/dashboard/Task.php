<?php

namespace App\Models\dashboard;

use App\Models\dashboard\Admin;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
    public function employee()
    {
        return $this->belongsTo(Admin::class, 'employe_id');
    }
}
