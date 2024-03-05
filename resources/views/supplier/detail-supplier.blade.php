@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.supplier_detail')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.supplier_detail')}}
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="p-4 rounded">
                    <div class="row mb-3">
                        <label for="company_name" class="col-sm-2 col-form-label">{{__('admin.supplier_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="name" placeholder="" value="{{ $supplier->name }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.supplier_name_kana')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="name_kana" placeholder="" value="{{ $supplier->name_kana }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.supplier_code')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="supplier_code" placeholder="" value="{{ $supplier->supplier_code }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.supplier_email')}}</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" id="" name="email" placeholder="" value="{{ $supplier->email }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_post_code')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="post_code" placeholder="" value="{{ $supplier->post_code }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="phone" class="col-sm-2 col-form-label">{{__('admin.supplier_adress')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="address" placeholder="" value="{{ $supplier->address }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_phone')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="phone_number" placeholder="" value="{{ $supplier->phone_number }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_fax')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="fax" placeholder="" value="{{ $supplier->fax }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_representative_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="representative_name" placeholder="" value="{{ $supplier->representative_name }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_products_handled')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="products_handled" placeholder="" value="{{ $supplier->products_handled }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_account_holder')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="account_holder" placeholder="" value="{{ $supplier->account_holder }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_account_name_kana')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="account_name_kana" placeholder="" value="{{ $supplier->account_name_kana }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_bank_name')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="bank_name" placeholder="" value="{{ $supplier->bank_name }}" readonly>
                                </div>
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_branch_name')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="branch_name" placeholder="" value="{{ $supplier->branch_name }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_account_type')}}</label>
                                <div class="col-sm-3">
                                    @foreach ($getStatusAccountType as $key => $value)
                                        @if ($key == $supplier->account_type)
                                            <input type="text" class="form-control" id="" name="bank_division" placeholder="" value="{{ $value }}" readonly>
                                        @endif
                                    @endforeach
                                </div>
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_account_number')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="account_number" placeholder="" value="{{ $supplier->account_number }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_bank_division')}}</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="" name="bank_division" placeholder="" value="{{ $supplier->bank_division }}" readonly>
                                </div>
                                <label for="email" class="col-sm-1 col-form-label">{{__('admin.supplier_fee_burden')}}</label>
                                <div class="col-sm-2">
                                    @foreach ($getStatusFeeBurden as $key => $value)
                                        @if ($key == $supplier->fee_burden)
                                            <input type="text" class="form-control" id="" name="bank_division" placeholder="" value="{{ $value }}" readonly>
                                        @endif
                                    @endforeach
                                </div>
                                <label for="email" class="col-sm-1 col-form-label">{{__('admin.supplier_date_of_payment')}}</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="" name="date_of_payment" placeholder="" value="{{ $supplier->date_of_payment }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_payment_terms')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="payment_terms" placeholder="" value="{{ $supplier->payment_terms }}" readonly>
                                </div>
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_payment_class')}}</label>
                                <div class="col-sm-3">
                                    @foreach ($getStatusPaymentClass as $key => $value)
                                        @if ($key == $supplier->payment_class)
                                            <input type="text" class="form-control" id="" name="bank_division" placeholder="" value="{{ $value }}" readonly>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_department_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="department_name" placeholder="" value="{{ $supplier->department_name }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_applicant')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="applicant" placeholder="" value="{{ $supplier->applicant }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_invoice_number')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="invoice_number" placeholder="" value="{{ $supplier->invoice_number }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_file_path')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="file_path" placeholder="" value="{{$supplier->file_name}}" readonly>
                                </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-8">
                                    <div id="holder" class="flex-column" style="margin-top:5px;max-height:100px;"></div>
                                    @if (!empty($supplier->file_name))
                                        <div class="d-flex justify-content-between">
                                            <div class="name-file">{{$supplier->file_name}}</div>
                                            <a href="{{$supplier->filePath}}" class="text-primary name-file"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                            target="_blank"><i
                                                    class="bi bi-eye-fill"></i></a>
                                        </div>
                                    @endif
                                    @php
                                        $arr = explode('.',$supplier->file_name);
                                        $ext = $arr[count($arr) - 1];
                                        $hidden = true ;
                                        if ($ext=="jpg" || $ext=="jpeg" || $ext=="png"){
                                            $hidden = false;
                                        }
                                    @endphp
                                    <img id="imgPreview" src="{{$supplier->file_path}}" style="height: 8rem;{{($hidden==true) ? 'display:none;' : ''}}" >
                                </div>

                        </div>
                    </div>
                <div class="d-flex justify-content-end">
                    <div>
                        <a href="{{route('list-supplier')}}" type="button" class="btn btn-primary px-5 mx-2">{{__('admin.btn_back')}}</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')

@endsection



