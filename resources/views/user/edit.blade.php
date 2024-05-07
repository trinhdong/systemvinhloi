@extends('layouts.app')
@section('title')
    Nhân viên
@endsection
@section('action')
    <div class="col-12">
        <a href="{{ route('user.index') }}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    Chỉnh sửa nhân viên
@endsection
@section('content')

    <form class="row g-3 needs-validation" action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
    <div class="card">
        <div class="card-body">
            <div class="p-4 border rounded">
                    <div class="col-12">
                        <div class="col-md-8 mt-2">
                            <label for="validationName" class="form-label">Tên</label>
                            <input name="name" type="text" class="form-control" id="validationName" value="{{ $user->name }}">
                            <div class="invalid-feedback">Vui lòng nhập tên</div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="validationEmail" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="validationEmail" value="{{ $user->email }}">
                            <div class="invalid-feedback">Vui lòng nhập email</div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label class="form-label">Số điện thoại</label>
                            <input name="phone" type="text" class="form-control" value="{{ $user->phone }}" >
                        </div>
                        <div class="col-md-8 mt-2">
                            <label class="form-label">Ngày vào làm</label>
                            <input autocomplete="off" name="day_of_work" type="text" id="datepicker" class="form-control" value="{{ !empty($user->day_of_work) ? date(FORMAT_DATE_VN, strtotime($user->day_of_work)) : '' }}" >
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="validationPassword" class="form-label">Mật khẩu</label>
                            <div class="input-group">
                                <input name="password" type="password" class="form-control" id="validationPassword">
                                <div class="valid-feedback"></div>
                            </div>
                        </div>
                        @if(Auth::user()->id !== $user->id)
                        <div class="col-md-3 mt-2">
                            <label for="validationRole" class="form-label">Chức vụ</label>
                            <select name="role" class="form-select" id="validationRole">
                                <option selected="" disabled="" value="">Chọn...</option>
                                @foreach(ROLE_TYPE_LIST as $role => $roleName)
                                    <option value="{{ $role }}" @if($user->role == $role) selected @endif>{{ $roleName }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Vui lòng nhập chức vụ</div>
                        </div>
                        @endif
                    </div>
                    <div id="addCustomer" class="table-responsive mt-3 {{$user->role === SALE ? '' : 'd-none'}}">
                        <div class="col-md-3 mt-2">
                            <label for="validationRole" class="form-label">Khách hàng phụ trách</label>
                            <select name="customer_ids[]" class="form-select single-select" multiple>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer['id'] }}" {{in_array($customer['id'], $customerIds) ? 'selected' : ''}}>
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
