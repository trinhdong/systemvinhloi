@extends('layouts.app')
@section('title')
    Nhân viên
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('user.index')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    Thêm nhân viên
@endsection
@section('content')
<form class="row g-3 needs-validation" action="{{ route('user.create') }}" method="POST">
    <div class="card">
        <div class="card-body">
            <div class="p-4 border rounded">
                    @csrf
                    <div class="col-12">
                        <div class="col-md-8 mt-2">
                            <label for="validationName" class="form-label">Tên</label>
                            <input name="name" type="text" class="form-control" id="validationName" value="{{ old('name') }}" >
                            <div class="invalid-feedback">Vui lòng nhập tên</div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="validationEmail" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="validationEmail" value="{{ old('email') }}" >
                            <div class="invalid-feedback">Vui lòng nhập email</div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label class="form-label">Số điện thoại</label>
                            <input name="phone" type="text" class="form-control" value="{{ old('phone') }}" >
                        </div>
                        <div class="col-md-8 mt-2">
                            <label class="form-label">Ngày vào làm</label>
                            <input autocomplete="off" name="day_of_work" type="text" id="datepicker" class="form-control" value="{{ old('day_of_work') }}" >
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="validationPassword" class="form-label">Mật khẩu</label>
                            <div class="input-group has-validation">
                                <input name="password" type="password" class="form-control" id="validationPassword">
                                <button class="btn btn-outline-secondary toggle-password" type="button"><i class="bi bi-eye-slash"></i></button>
                                <div class="invalid-feedback">Vui lòng nhập mật khẩu</div>
                            </div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="password-confirm" class="form-label">Xác nhận mật khẩu</label>
                            <div class="input-group has-validation">
                                <input name="password_confirmation" type="password" class="form-control" id="password-confirm">
                                <button class="btn btn-outline-secondary toggle-password" type="button"><i class="bi bi-eye-slash"></i></button>
                                <div class="invalid-feedback">Vui lòng nhập xác nhận mật khẩu</div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label for="validationRole" class="form-label">Chức vụ</label>
                            <select name="role" class="form-select" id="validationRole" >
                                <option selected="" disabled="" value="">Chọn...</option>
                                @foreach(ROLE_TYPE_LIST as $role => $roleName)
                                    @if(Auth::user()->role !== $role)
                                        <option value="{{ $role }}">{{ $roleName }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn chức vụ</div>
                        </div>
                    </div>

                <div id="addCustomer" class="table-responsive mt-3 d-none">
                    <div class="col-md-3 mt-2">
                        <label for="validationRole" class="form-label">Khách hàng phụ trách</label>
                        <select name="customer_ids[]" class="form-select single-select" multiple>
                            @foreach($customers as $customer)
                                <option value="{{ $customer['id'] }}">
                                    {{$customer['customer_name'] . '-' . $customer['phone']}}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Vui lòng chọn chức vụ</div>
                    </div>
                </div>
            </div>
            <button style="width: 80px;" class="btn btn-success mt-3" type="submit">Lưu</button>
        </div>
    </div>
</form>

@endsection
@section('script')
    <script src="js/user/add.js"></script>
@endsection
