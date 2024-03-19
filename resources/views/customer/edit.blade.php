@extends('layouts.app')
@section('title')
    Khách hàng
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('customer.index')}}" class="btn btn-sm btn-primary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    Chỉnh sửa khách hàng
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="p-4 border rounded">
                <form class="row g-3 needs-validation" action="{{ route('customer.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                            <div class="input-group has-validation">
                                <input name="phone" type="text" class="form-control" id="validationPhone" value="{{ $customer->phone }}">
                            </div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="validationAddress" class="form-label">Địa chỉ</label>
                            <div class="input-group has-validation">
                                <input name="address" type="text" class="form-control" id="validationAddress" value="{{ $customer->address }}">
                                <div class="invalid-feedback"></div>
                            </div>
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
                    </div>
                    @include('customer.editDiscount', compact('products', 'categories', 'customer', 'categoryIds', 'productPrice'), ['discounts' => $customer->discount])
                    <div class="col-2">
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/customer/add.js"></script>
    <script src="js/customer/edit.js"></script>
@endsection
