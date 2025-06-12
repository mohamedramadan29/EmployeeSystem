<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Models\dashboard\Task;
use App\Models\dashboard\Admin;
use App\Http\Traits\Message_Trait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    use Message_Trait;

    public function index(){
        if(Auth::guard('admin')->user()->account_type == 'employee'){
            $tasks = Task::orderBy('id', 'desc')->where('employe_id', Auth::guard('admin')->user()->id)->get();
        }else{
            $tasks = Task::orderBy('id', 'desc')->get();
        }
        $employees = Admin::where('account_type', 'employee')->get();
        return view('dashboard.tasks.index', compact('tasks', 'employees'));
    }
    public function store(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'client_name' => 'required',
                'client_phone' => 'required',
                'request_number' => 'required',
                'price' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'employe_id' => 'required',
                'description' => 'required',
            ];
            $messages = [
                'client_name.required' => 'الاسم مطلوب',
                'client_phone.required' => 'الرقم مطلوب',
                'request_number.required' => 'رقم الطلب مطلوب',
                'price.required' => 'السعر مطلوب',
                'start_date.required' => 'تاريخ البدء مطلوب',
                'end_date.required' => 'تاريخ الانتهاء مطلوب',
                'employe_id.required' => 'الموظف مطلوب',
                'description.required' => 'الوصف مطلوب',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            $task = Task::create([
                'client_name' => $data['client_name'],
                'client_phone' => $data['client_phone'],
                'request_number' => $data['request_number'],
                'price' => $data['price'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'employe_id' => $data['employe_id'],
                'description' => $data['description'],
                'status' => 'قيد المراجعة',
            ]);
            return $this->success_message('تم إضافة المهمة بنجاح');
        }
        $employees = Admin::where('account_type', 'employee')->get();
        return view('dashboard.tasks.add', compact('employees'));
    }
    public function update(Request $request, $id){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'client_name' => 'required',
                'client_phone' => 'required',
                'request_number' => 'required',
                'price' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'employe_id' => 'required',
                'description' => 'required',
                'status' => 'required',
            ];
            $messages = [
                'client_name.required' => 'الاسم مطلوب',
                'client_phone.required' => 'الرقم مطلوب',
                'request_number.required' => 'رقم الطلب مطلوب',
                'price.required' => 'السعر مطلوب',
                'start_date.required' => 'تاريخ البدء مطلوب',
                'end_date.required' => 'تاريخ الانتهاء مطلوب',
                'employe_id.required' => 'الموظف مطلوب',
                'description.required' => 'الوصف مطلوب',
                'status.required' => 'الحالة مطلوبة',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            $task = Task::find($id);
            $task->client_name = $data['client_name'];
            $task->client_phone = $data['client_phone'];
            $task->request_number = $data['request_number'];
            $task->price = $data['price'];
            $task->start_date = $data['start_date'];
            $task->end_date = $data['end_date'];
            $task->employe_id = $data['employe_id'];
            $task->description = $data['description'];
            $task->status = $data['status'];
            $task->save();
            return $this->success_message('تم تحديث المهمة بنجاح');
        }
        $task = Task::find($id);
        $employees = Admin::where('account_type', 'employee')->get();
        return view('dashboard.tasks.edit', compact('task', 'employees'));
    }
    public function show(Request $request, $id){

        if($request->isMethod('post')){
            $data = $request->all();
            $task = Task::find($id);
            $task->status = $data['status'];
            $task->employee_note = $data['employee_note'];
            $task->save();
            return $this->success_message('تم تحديث المهمة بنجاح');
        }
        $task = Task::with('employee')->find($id);
        return view('dashboard.tasks.show', compact('task'));
    }
    public function delete($id){
        $task = Task::find($id);
        $task->delete();
        return $this->success_message('تم حذف المهمة بنجاح');
    }
}
