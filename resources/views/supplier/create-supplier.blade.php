@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.supplier_add')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.supplier_add')}}
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('create-supplier-post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-4 rounded">
                        <div class="row mb-3">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul style="margin: 0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <label for="company_name" class="col-sm-2 col-form-label">{{__('admin.supplier_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="name" placeholder="" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.supplier_name_kana')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="name_kana" placeholder="" value="{{ old('name_kana') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.supplier_code')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="supplier_code" placeholder="" value="{{ old('supplier_code') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.supplier_email')}}</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" id="" name="email" placeholder="" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_post_code')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="post_code" placeholder="" value="{{ old('post_code') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="phone" class="col-sm-2 col-form-label">{{__('admin.supplier_adress')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="address" placeholder="" value="{{ old('address') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_phone')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="phone_number" placeholder="" value="{{ old('phone_number') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_fax')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="fax" placeholder="" value="{{ old('fax') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_representative_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="representative_name" placeholder="" value="{{ old('representative_name') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_products_handled')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="products_handled" placeholder="" value="{{ old('products_handled') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_account_holder')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="account_holder" placeholder="" value="{{ old('account_holder') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_account_name_kana')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="account_name_kana" placeholder="" value="{{ old('account_name_kana') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_bank_name')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="bank_name" placeholder="" value="{{ old('bank_name') }}">
                                </div>
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_branch_name')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="branch_name" placeholder="" value="{{ old('branch_name') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_account_type')}}</label>
                                <div class="col-sm-3">
                                    <select class="form-select" name="account_type" id="">
                                        @foreach ($getStatusAccountType as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_account_number')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="account_number" placeholder="" value="{{ old('account_number') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_bank_division')}}</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="" name="bank_division" placeholder="" value="{{ old('bank_division') }}">
                                </div>
                                <label for="email" class="col-sm-1 col-form-label">{{__('admin.supplier_fee_burden')}}</label>
                                <div class="col-sm-2">
                                    <select class="form-select" name="fee_burden" id="">
                                        @foreach ($getStatusFeeBurden as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="email" class="col-sm-1 col-form-label">{{__('admin.supplier_date_of_payment')}}</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control expected_date" id="" name="date_of_payment" placeholder="" value="{{ old('date_of_payment') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_payment_terms')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="payment_terms" placeholder="" value="{{ old('payment_terms') }}">
                                </div>
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_payment_class')}}</label>
                                <div class="col-sm-3">
                                    <select class="form-select" name="payment_class" id="">
                                        @foreach ($getStatusPaymentClass as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_department_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="department_name" placeholder="" value="{{ old('department_name') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_applicant')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="applicant" placeholder="" value="{{ old('applicant') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_invoice_number')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="invoice_number" placeholder="" value="{{ old('invoice_number') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.supplier_file_path')}}</label>
                                <div class="col-sm-8">
                                    <input class="form-control file-custom" type="file" name="file_supplier">
                                    <img id="imgPreview" style="display:none; width:200px;">
                                </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div>
                            <a href="{{route('list-supplier')}}" type="button" class="btn btn-primary px-5 mx-2">{{__('admin.btn_back')}}</a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary px-5 mx-2">{{__('admin.btn_create')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')
    <script>
        $('.expected_date').bootstrapMaterialDatePicker({
            cancelText: "Abbrechen",
            time: false,
            format: 'YYYY/MM/DD',
            cancelText:"戻る",
            okText:"選択",
            lang: "ja",
        });
        $('.expected_date').on('dateSelected', function(e, date) {
            id = $(this).attr('data-dtp')
        $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
        });
        $(document).ready(function() {
            $('.file-custom').change(function(){
                fileName  = $(this).val();
                var idxDot = fileName.lastIndexOf(".") + 1;
                var allowedExtensions = /(\.pdf|\.xlsm|\.png|\.jpg|\.jpeg)$/i;
                if (!allowedExtensions.exec(fileName)) {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'bx bx-x-circle',
                        msg: "ファイル形式のアップロードのみを許可: pdf、xlsm、png、jpg、jpeg"
                    });
                    $(this).val('');
                    $('#imgPreview').css('display','none')
                    return ;
                }
                var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
                    $('#imgPreview').css('display','block')
                    var fileName = $(this).val().split("\\").pop();
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                        if (e.target.result.match(/^data:image\//)) {
                            $("#imgPreview").attr("src", e.target.result);
                        }
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                }else{
                    $('#imgPreview').css('display','none')
                }
            })
         });
    </script>
@endsection



