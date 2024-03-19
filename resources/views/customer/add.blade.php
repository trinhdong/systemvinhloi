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
    Thêm khách hàng
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="p-4 border rounded">
            <form class="row g-3 needs-validation" action="{{ route('customer.create') }}" method="POST">
                @csrf
                <div class="col-12">
                    <div class="col-md-8 mt-2">
                        <label for="validationName" class="form-label">Tên</label>
                        <input name="customer_name" type="text" class="form-control" id="validationName" value="">
                        <div class="invalid-feedback">Vui lòng nhập tên</div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label for="validationEmail" class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" id="validationEmail" value="">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label for="validationPhone" class="form-label">Số điện thoại</label>
                        <div class="input-group has-validation">
                            <input name="phone" type="text" class="form-control" id="validationPhone">
                        </div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <label for="validationAddress" class="form-label">Địa chỉ</label>
                        <div class="input-group has-validation">
                            <input name="address" type="text" class="form-control" id="validationAddress">
                        </div>
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
@section('script')
    <script src="js/customer/add.js"></script>
@endsection
