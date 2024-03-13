@extends('layouts.app')
@section('title')
    Nhân viên
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('user.index')}}" class="btn btn-sm btn-primary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    Thêm nhân viên
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="p-4 border rounded">
            <form class="row g-3 needs-validation" action="{{ route('user.create') }}" method="POST">
                @csrf
                <div class="col-12">
                    <div class="col-md-8 mt-2">
                        <label for="validationName" class="form-label">Tên</label>
                        <input name="name" type="text" class="form-control" id="validationName" value="" required="">
                        <div class="valid-feedback"></div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label for="validationEmail" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" id="validationEmail" value="" required="">
                        <div class="valid-feedback"></div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label for="validationPassword" class="form-label">Mật khẩu</label>
                        <div class="input-group has-validation">
                            <input name="password" type="password" class="form-control" id="validationPassword" required="">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="validationRole" class="form-label">Chức vụ</label>
                        <select name="role" class="form-select" id="validationRole" required="">
                            <option selected="" disabled="" value="">Chọn...</option>
                            @foreach(ROLE_TYPE_LIST as $role => $roleName)
                                @if(Auth::user()->role !== $role)
                                    <option value="{{ $role }}">{{ $roleName }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="d-grid">
                    <button class="btn btn-primary" type="submit">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
