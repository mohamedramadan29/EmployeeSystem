<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Models\dashboard\Admin;
use App\Http\Traits\Message_Trait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    use Message_Trait;

    public function index()
    {
        $employees = Admin::where('account_type','employee')->orderBy('id', 'desc')->get();
        return view('dashboard.employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:admins,email',
                //'phone' => 'required|numeric|unique:admins,phone',
                'password' => 'required|min:6',
                'password_confirmation' => 'required|same:password',
                'job_type' => 'required',
                'start_job_date' => 'required',

            ];
            $messages = [
                'name.required' => 'الاسم مطلوب',
                'email.required' => 'البريد الالكتروني مطلوب',
                'email.email' => 'البريد الالكتروني غير صحيح',
                'email.unique' => 'البريد الالكتروني موجود بالفعل',
                'phone.required' => 'رقم الهاتف مطلوب',
               // 'phone.unique' => 'رقم الهاتف موجود بالفعل',
                'password.required' => 'كلمة المرور مطلوبة',
                'password.min' => 'كلمة المرور يجب ان تكون على الاقل 6 حروف',
                'job_type.required' => 'الوظيفة مطلوبة',
                'start_job_date.required' => 'تاريخ البدء مطلوب',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            $employee = new admin();
            $employee->name = $data['name'];
            $employee->email = $data['email'];
           // $employee->phone = $data['phone'];
            $employee->password = Hash::make($data['password']);
            $employee->job_type = $data['job_type'];
            $employee->start_job_date = $data['start_job_date'];
            $employee->account_type = $data['account_type'];
            $employee->save();

            return $this->success_message(' تم اضافة الموظف  بنجاح');
        }
        return view('dashboard.employees.add');
    }

    public function update(Request $request, $id)
    {
        $employee = admin::find($id);
        if (!$employee) {
            abort(404);
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:admins,email,' . $employee->id,
                //'phone' => 'required|numeric|unique:admins,phone,' . $employee->id,
                'password' => 'nullable|min:6',
                'password_confirmation' => 'nullable|same:password',
                'job_type' => 'required',
                'start_job_date' => 'required',
            ];
            $messages = [
                'name.required' => 'الاسم مطلوب',
                'email.required' => 'البريد الالكتروني مطلوب',
                'email.email' => 'البريد الالكتروني غير صحيح',
                'email.unique' => 'البريد الالكتروني موجود بالفعل',
                'phone.required' => 'رقم الهاتف مطلوب',
                'phone.unique' => 'رقم الهاتف موجود بالفعل',
                'password.min' => 'كلمة المرور يجب ان تكون على الاقل 6 حروف',
                'job_type.required' => 'الوظيفة مطلوبة',
                'start_job_date.required' => 'تاريخ البدء مطلوب',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            $employee->update([
                "name" => $data['name'],
                "email" => $data['email'],
                "password" => $data['password'] ? Hash::make($data['password']) : $employee->password,
                "account_type" => $data['account_type'],
                "job_type" => $data['job_type'],
                "start_job_date" => $data['start_job_date'],
            ]);
            return $this->success_message(' تم تعديل الموظف بنجاح');
        }
        return view('dashboard.employees.edit', compact('employee'));
    }
    public function delete($id)
    {
        $employee = admin::find($id);
        if (!$employee) {
            abort(404);
        }
        $employee->delete();
        return $this->success_message(' تم حذف الموظف بنجاح');
    }
    public function search(Request $request)
    {
        $search = $request->search;
        $employees = Admin::where('account_type', 'employee')->where('name', 'like', "%$search%")->get();
        return view('dashboard.employees.index', compact('employees'));
    }
}
