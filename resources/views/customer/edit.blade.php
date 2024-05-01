@extends('layouts.app')
@section('title')
    Khách hàng
@endsection
@section('css')
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('customer.index')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    Chỉnh sửa khách hàng
@endsection
@section('content')

    <form class="row g-3 needs-validation" action="{{ route('customer.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
    <div class="card">
        <div class="card-body">
            <div class="p-4 border rounded">
                    <div class="col-12">
                        <div class="col-md-8 mt-2">
                            <label for="validationName" class="form-label">Tên</label>
                            <input name="customer_name" type="text" class="form-control" id="validationName" value="{{ $customer->customer_name }}">
                            <div class="invalid-feedback">Vui lòng nhập tên</div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="validationEmail" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="validationEmail" value="{{ $customer->email }}">
                            <div class="valid-feedback"></div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="validationPhone" class="form-label">Số điện thoại</label>
                            <input name="phone" type="text" class="form-control" id="validationPhone" value="{{ $customer->phone }}">
                            <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="validationAddress" class="form-label">Địa chỉ</label>
                            <input name="address" type="text" class="form-control" id="validationAddress" value="{{ $customer->address }}">
                            <div class="invalid-feedback">Vui lòng nhập địa chỉ</div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label class="form-label">Tên công ty</label>
                            <input name="company" type="text" class="form-control" value="{{ $customer->company }}">
                        </div>
                        <div class="col-md-8 mt-2">
                            <label class="form-label">Địa chỉ công ty</label>
                            <input name="company_address" type="text" class="form-control" value="{{ $customer->company_address }}">
                        </div>
                        <div class="col-md-8 mt-2">
                            <label class="form-label">Mã số thuế</label>
                            <input name="tax_code" type="text" class="form-control" value="{{ $customer->tax_code }}">
                        </div>
                        <div class="col-md-3 mt-2">
                            <label for="validationRole" class="form-label">Khu vực</label>
                            <select name="area_id" class="form-select" id="validationRole">
                                <option selected="" disabled="" value="">Chọn...</option>
                                @foreach($areas as $areaId => $areaName)
                                    <option value="{{ $areaId }}" @if($customer->area_id == $areaId) selected @endif>{{ $areaName }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn khu vực</div>
                        </div>
                        @if($isAdmin)
                        <div class="col-md-3 mt-2">
                            <label for="employee_customer" class="form-label">Người phụ trách</label>
                            <select name="user_id" class="form-select" id="user_id">
                                <option selected="" disabled="" value="">Chọn...</option>
                                @foreach($saleList as $key => $item)
                                    <option value="{{ $item['id'] }}" @if(($employeeCustomer['user_id'] ?? null) && $item['id'] == $employeeCustomer['user_id']) selected="selected" @endif>{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    @include('customer.editDiscount', compact('products', 'categories', 'customer', 'categoryIds', 'productPrice'), ['discounts' => $customer->discount])
            </div>
            <button style="width: 80px;" class="btn btn-success mt-3" type="submit">Lưu</button>
        </div>
    </div>
    </form>

@endsection
@section('script')
    <script src="js/customer/add.js"></script>
    <script src="js/customer/edit.js"></script>
@endsection
