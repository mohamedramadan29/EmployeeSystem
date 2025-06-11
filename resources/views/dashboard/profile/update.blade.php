@extends('dashboard.layouts.master')
@section('profile-active', 'active')
@section('title', 'تعديل الملف الشخصي')

@section('content')
    <div class="main-content">


        <div id="profile" class="section-content" style="display: block;">
            <div class="card mt-4">
                @if (session()->has('success_message'))
                    <div class="alert alert-success">
                        {{ session()->get('success_message') }}
                    </div>
                @endif
                @if (session()->has('error_message'))
                    <div class="alert alert-danger">
                        {{ session()->get('error_message') }}
                    </div>
                @endif
                <div class="card-header">
                    الملف الشخصي
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- <div class="col-md-4 text-center">
                            <div class="avatar-lg bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                id="profile-avatar" style="width: 100px; height: 100px; font-size: 2.5rem;">س</div>
                            <h5 class="mt-3" id="profile-name">{{ Auth::guard('admin')->user()->name }}</h5>
                            <p class="text-muted" id="profile-position">{{ Auth::guard('admin')->user()->job_type }}</p>
                            <input type="file" id="avatar-upload" accept="image/*" style="display: none;">
                            <button class="btn btn-outline-primary mt-2" id="change-avatar-btn">تغيير الصورة</button>
                        </div> --}}
                        <div class="col-md-12">
                            <form id="profile-form" action="{{ route('update_profile') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الاسم الكامل</label>
                                        <input type="text" class="form-control" name="name" id="profile-fullname" value="{{ Auth::guard('admin')->user()->name }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">البريد الإلكتروني</label>
                                        <input type="email" class="form-control" name="email" id="profile-email"
                                            value="{{ Auth::guard('admin')->user()->email }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم الجوال</label>
                                        <input type="text" class="form-control" name="phone" id="profile-phone" value="{{ Auth::guard('admin')->user()->phone }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ الميلاد</label>
                                        <input type="date" class="form-control" name="birth_date" id="profile-birthdate"
                                            value="{{ Auth::guard('admin')->user()->birth_date }}">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">العنوان</label>
                                        <textarea class="form-control" name="address" id="profile-address" rows="2">{{ Auth::guard('admin')->user()->address }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    تغيير كلمة المرور
                </div>
                <div class="card-body">
                    <form id="password-form" action="{{ route('update_password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">كلمة المرور الحالية</label>
                                <input type="password" class="form-control" id="current-password" name="old_password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" class="form-control" id="new-password" name="new_password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">تأكيد كلمة المرور الجديدة</label>
                                <input type="password" class="form-control" id="confirm-password" name="confirm_password">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">تغيير كلمة المرور</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
