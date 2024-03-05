@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.customer_edit')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.customer_edit')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('edit-customer-post', $customer->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="p-4 rounded">
                            <input type="hidden" name="id_customer" value="{{$customer->id}}">
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
                            <label for="company_name" class="col-sm-2 col-form-label">{{__('admin.customer_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="name" placeholder="" value="{{ $customer->name }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.customer_name_kana')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="name_kana" placeholder="" value="{{ $customer->name_kana }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.customer_code')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="customer_code" placeholder="" value="{{ $customer->customer_code }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.customer_email')}}</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" id="" name="email" placeholder="" value="{{ $customer->email }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.customer_post_code')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="post_code" placeholder="" value="{{ $customer->post_code }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="phone" class="col-sm-2 col-form-label">{{__('admin.customer_adress')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="address" placeholder="" value="{{ $customer->address }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="phone" class="col-sm-2 col-form-label">{{__('admin.address_for_delivery_note')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="address_for_delivery" placeholder="" value="{{ $customer->address_for_delivery }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_phone')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="phone_number" placeholder="" value="{{ $customer->phone_number }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_fax')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="fax" placeholder="" value="{{ $customer->fax }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.person_in_charge_code')}}</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="" name="person_in_charge_code" placeholder="" value="{{ $customer->person_in_charge_code }}">
                                </div>
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_sale_person_name')}}</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="" name="sale_person_name" placeholder="" value="{{ $customer->sale_person_name }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_representative_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="representative_name" placeholder="" value="{{ $customer->representative_name }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_job_code')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="job_code" placeholder="" value="{{ $customer->job_code }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_designated_transfer_bank')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="designated_transfer_bank" placeholder="" value="{{ $customer->designated_transfer_bank }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_collection_date')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control collection_date" id="" name="collection_date" placeholder="" value="{{ $customer->collection_date }}">
                                </div>
                                <label for="email" class="col-sm-1 col-form-label">{{__('admin.customer_due_date')}}</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control due_date" id="" name="due_date" placeholder="" value="{{ $customer->due_date }}">
                                </div>
                                
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_payment_category')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="payment_category" placeholder="" value="{{ $customer->payment_category }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_payment_terms')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="payment_terms" placeholder="" value="{{ $customer->payment_terms }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_bond_payment_date')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control bond_payment_date" id="" name="bond_payment_date" placeholder="" value="{{ $customer->bond_payment_date }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_cash')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="cash" placeholder="" value="{{ $customer->cash }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_check')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="check" placeholder="" value="{{ $customer->check }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_bill')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="bill" placeholder="" value="{{ $customer->bill }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_starting_division')}}</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="starting_division" id="">
                                        @foreach ($getStatus as $key => $value)
                                            <option value="{{$key}}"
                                            @if ($key === $customer->starting_division)
                                                selected
                                            @endif >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_credit_limit')}}</label>
                                <label for="email" class="col-sm-1 col-form-label">{{__('admin.customer_remaining')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="remaining" placeholder="" value="{{ $customer->remaining }}">
                                </div>
                                <label for="email" class="col-sm-1 col-form-label">{{__('admin.customer_sell')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="sell" placeholder="" value="{{ $customer->sell }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_delivery_address_1')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="delivery_address_1" placeholder="" value="{{ $customer->delivery_address_1 }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_delivery_address_2')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="delivery_address_2" placeholder="" value="{{ $customer->delivery_address_2 }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_delivery_address_3')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="delivery_address_3" placeholder="" value="{{ $customer->delivery_address_3 }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_registrant_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="registrant_name" placeholder="" value="{{ $customer->registrant_name }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_invoice_number')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="invoice_number" placeholder="" value="{{ old('invoice_number') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.closing_group')}}</label>
                                <div class="col-sm-8">
                                    <select class="form-select closing_group" name="closing_group" id="closing_group">
                                        <option value="" {{$customer->closing_group == null ? "selected" : ""}}></option>
                                        <option value="5" {{$customer->closing_group == 5 ? "selected" : ""}}>5</option>
                                        <option value="10" {{$customer->closing_group == 10 ? "selected" : ""}}>10</option>
                                        <option value="15" {{$customer->closing_group == 15 ? "selected" : ""}}>15</option>
                                        <option value="20" {{$customer->closing_group == 20 ? "selected" : ""}}>20</option>
                                        <option value="25" {{$customer->closing_group == 25 ? "selected" : ""}}>25</option>
                                        <option value="{{date('t')}}" {{$customer->closing_group == date('t') ? "selected" : ""}}>{{date('t')}}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.collection_cycle')}}</label>
                                <div class="col-sm-3">
                                    <select class="form-select collection_cycle" name="collection_cycle" id="collection_cycle">
                                        @foreach(App\Enums\ECollectionCycle::getArray() as $key => $item)
                                            <option value="{{$key}}" {{$key == $customer->collection_cycle ? 'selected' : ''}}>{{$item}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="" class="col-sm-2 col-form-label text-end">毎月の回収日</label>
                                <div class="col-sm-3">
                                    <select class="form-select monthly_collect_date" name="monthly_collect_date" id="monthly_collect_date">
                                        <option value="" selected disabled></option>
                                        @foreach(App\Enums\ECollectionDate::getArray() as $key => $item)
                                            <option value="{{$key}}" {{$key == $customer->monthly_collect_date ? 'selected' : ''}}>{{$item}}</option>
                                        @endforeach
                                        <option value="6" {{$customer->monthly_collect_date == 6 ? 'selected' : ''}}>{{date('t')}}日</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_file_path')}}</label>
                                <div class="col-sm-8">
                                    <input class="form-control file-custom" type="file" name="file_customer">
                                    @if (!empty($customer->file_name))
                                    <div class="d-flex justify-content-between">
                                        <div class="name-file">{{$customer->file_name}}</div>
                                        <a href="{{$customer->file_path}}" class="text-primary name-file"
                                           data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                           target="_blank"><i
                                                class="bi bi-eye-fill"></i></a>
                                    </div>
                                    @endif
                                    @php
                                        $arr = explode('.',$customer->file_name);
                                        $ext = $arr[count($arr) - 1];
                                        $hidden = true ;
                                        if ($ext=="jpg" || $ext=="jpeg" || $ext=="png"){
                                            $hidden = false;
                                        }
                                    @endphp
                                    <img id="imgPreview" src="{{$customer->file_path}}" style="height: 8rem;{{($hidden==true) ? 'display:none;' : ''}}" >
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div>
                                <a href="{{route('list-customer')}}" type="button" class="btn btn-primary px-5 mx-2">{{__('admin.btn_back')}}</a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary px-5 mx-2">{{__('admin.btn_save')}}</button>
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
        $('.collection_date').bootstrapMaterialDatePicker({
            cancelText: "Abbrechen",
            time: false,
            format: 'YYYY/MM/DD',
            cancelText:"戻る",
            okText:"選択",
            lang: "ja",
        });
        $('.collection_date').on('dateSelected', function(e, date) {
            id = $(this).attr('data-dtp')
        $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
        });

        $('.due_date').bootstrapMaterialDatePicker({
            cancelText: "Abbrechen",
            time: false,
            format: 'YYYY/MM/DD',
            cancelText:"戻る",
            okText:"選択",
            lang: "ja",
        });
        $('.due_date').on('dateSelected', function(e, date) {
            id = $(this).attr('data-dtp')
        $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
        });

        $('.closing_date').bootstrapMaterialDatePicker({
            cancelText: "Abbrechen",
            time: false,
            format: 'YYYY/MM/DD',
            cancelText:"戻る",
            okText:"選択",
            lang: "ja",
        });
        $('.closing_date').on('dateSelected', function(e, date) {
            id = $(this).attr('data-dtp')
            $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
        });
        
        

        $('.bond_payment_date').bootstrapMaterialDatePicker({
            cancelText: "Abbrechen",
            time: false,
            format: 'YYYY/MM/DD',
            cancelText:"戻る",
            okText:"選択",
            lang: "ja",
        });
        $('.bond_payment_date').on('dateSelected', function(e, date) {
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
                    $('#imgOld').css('display','none')
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



