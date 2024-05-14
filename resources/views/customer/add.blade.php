@extends('layouts.app')
@section('title')
    Khách hàng
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('customer.index')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    Thêm khách hàng
@endsection
@section('content')

<form class="row g-3 needs-validation" action="{{ route('customer.create') }}" method="POST">
    @csrf
    <div class="card">
    <div class="card-body">
        <div class="p-4 border rounded">
                <div class="col-12">
                    <div class="col-md-8 mt-2">
                        <label for="validationName" class="form-label">Tên</label>
                        <input name="customer_name" type="text" class="form-control" id="validationName" value="{{ old('customer_name') }}">
                        <div class="invalid-feedback">Vui lòng nhập tên</div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label for="validationEmail" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" id="validationEmail" value="{{ old('customer_name') }}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label for="validationPhone" class="form-label">Số điện thoại</label>
                        <input name="phone" type="text" class="form-control" id="validationPhone" value="{{ old('phone') }}">
                        <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label for="validationAddress" class="form-label">Địa chỉ</label>
                        <input name="address" type="text" class="form-control" id="validationAddress" value="{{ old('address') }}">
                        <div class="invalid-feedback">Vui lòng nhập địa chỉ</div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label class="form-label">Tên công ty</label>
                        <input name="company" type="text" class="form-control" value="{{ old('company') }}">
                    </div>
                    <div class="col-md-8 mt-2">
                        <label class="form-label">Địa chỉ công ty</label>
                        <input name="company_address" type="text" class="form-control" value="{{ old('company_address') }}">
                    </div>
                    <div class="col-md-8 mt-2">
                        <label class="form-label">Mã số thuế</label>
                        <input name="tax_code" type="text" class="form-control" value="{{ old('tax_code') }}">
                    </div>
                    <div class="col-md-3 mt-2">
                        <label for="validationRole" class="form-label">Khu vực</label>
                        <select name="area_id" class="form-select" id="validationRole">
                            <option selected="" disabled="" value="">Chọn...</option>
                            @foreach($areas as $areaCode => $areaName)
                                <option value="{{ $areaCode }}">{{ $areaName }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Vui lòng chọn khu vực</div>
                    </div>
                </div>
                @include('customer.addDiscount', compact('categories'))
        </div>
        <button style="width: 80px;" class="btn btn-success mt-3" type="submit">Lưu</button>
    </div>
</div>
</form>

@endsection
@section('script')
    <script src="js/customer/add.js"></script>
@endsection
