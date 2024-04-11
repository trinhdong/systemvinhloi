@extends('layouts.app')
@section('title')
    Tài khoản ngân hàng
@endsection
@section('action')
    <div class="col-12">
        <a href="{{route('bank_account.index')}}" class="btn btn-sm btn-secondary">Quay lại</a>
    </div>
@endsection
@section('breadcrumb')
    Thêm tài khoản ngân hàng
@endsection
@section('content')
<form class="row g-3 needs-validation" action="{{ route('bank_account.create') }}" method="POST">
    <div class="card">
        <div class="card-body">
            <div class="p-4 border rounded">
                    @csrf
                    <div class="col-12">
                        <div class="col-md-8 mt-2">
                            <label for="validationBankName" class="form-label">Tên ngân hàng</label>
                            <input name="bank_name" type="text" class="form-control" id="validationBankName" value="" >
                            <div class="invalid-feedback">Vui lòng nhập tên ngân hàng</div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="validationBankCode" class="form-label">Số tài khoản ngân hàng</label>
                            <input name="bank_code" type="text" class="form-control" id="validationBankCode" value="" >
                            <div class="invalid-feedback">Vui lòng nhập số tài khoản ngân hàng</div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="validationBankAccountName" class="form-label">Tên chủ tài khoản ngân hàng</label>
                            <input name="bank_account_name" type="text" class="form-control" id="validationBankAccountName" value="" >
                            <div class="invalid-feedback">Vui lòng nhập tên chủ tài khoản ngân hàng</div>
                        </div>
                        <div class="col-md-8 mt-2">
                            <label for="validationBankBranch" class="form-label">Chi nhánh ngân hàng</label>
                            <input name="bank_branch" type="text" class="form-control" id="validationBankBranch" value="" >
                        </div>

                    </div>
            </div>
            <button style="width: 80px;" class="btn btn-success mt-3" type="submit">Lưu</button>
        </div>
    </div>
</form>

@endsection
@section('script')
    <script src="js/bank_account/add.js"></script>
@endsection
