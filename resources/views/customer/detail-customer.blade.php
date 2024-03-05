@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.customer_detail')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.customer_detail')}}
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="p-4 rounded">
                    <div class="row mb-3">
                        <label for="company_name" class="col-sm-2 col-form-label">{{__('admin.customer_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="name" placeholder="" value="{{$customer->name}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.customer_name_kana')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="name_kana" placeholder="" value="{{$customer->name_kana}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.customer_code')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="customer_code" placeholder="" value="{{$customer->customer_code}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.customer_email')}}</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" id="" name="email" placeholder="" value="{{$customer->email}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="code" class="col-sm-2 col-form-label">{{__('admin.customer_post_code')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="post_code" placeholder="" value="{{$customer->post_code}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="phone" class="col-sm-2 col-form-label">{{__('admin.customer_adress')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="address" placeholder="" value="{{$customer->address}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="phone" class="col-sm-2 col-form-label">{{__('admin.address_for_delivery_note')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="address_for_delivery" placeholder="" value="{{ $customer->address_for_delivery }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_phone')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="phone_number" placeholder="" value="{{$customer->phone_number}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_fax')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="fax" placeholder="" value="{{$customer->fax}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.person_in_charge_code')}}</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="" name="person_in_charge_code" placeholder="" value="{{$customer->person_in_charge_code}}" readonly>
                                </div>
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_sale_person_name')}}</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="" name="sale_person_name" placeholder="" value="{{$customer->sale_person_name}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_representative_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="representative_name" placeholder="" value="{{$customer->representative_name}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_job_code')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="job_code" placeholder="" value="{{$customer->job_code}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_designated_transfer_bank')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="designated_transfer_bank" placeholder="" value="{{$customer->designated_transfer_bank}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_collection_date')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="collection_date" placeholder="" value="{{$customer->collection_date}}" readonly>
                                </div>
                                <label for="email" class="col-sm-1 col-form-label">{{__('admin.customer_due_date')}}</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="" name="due_date" placeholder="" value="{{$customer->due_date}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_payment_category')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="payment_category" placeholder="" value="{{$customer->payment_category}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_payment_terms')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="payment_terms" placeholder="" value="{{$customer->payment_terms}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_bond_payment_date')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="bond_payment_date" placeholder="" value="{{$customer->bond_payment_date}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_cash')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="cash" placeholder="" value="{{$customer->cash}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_check')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="check" placeholder="" value="{{$customer->check}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_bill')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="bill" placeholder="" value="{{$customer->bill}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_starting_division')}}</label>
                                <div class="col-sm-8">
                                    @foreach ($getStatus as $key => $value)
                                        @if ($key == $customer->starting_division)
                                            <input type="text" class="form-control" id="" name="bill" placeholder="" value="{{$value}}" readonly>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_credit_limit')}}</label>
                                <label for="email" class="col-sm-1 col-form-label">{{__('admin.customer_remaining')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="remaining" placeholder="" value="{{$customer->remaining}}" readonly>
                                </div>
                                <label for="email" class="col-sm-1 col-form-label">{{__('admin.customer_sell')}}</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="" name="sell" placeholder="" value="{{$customer->sell}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_delivery_address_1')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="delivery_address_1" placeholder="" value="{{$customer->delivery_address_1}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_delivery_address_2')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="delivery_address_2" placeholder="" value="{{$customer->delivery_address_2}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_delivery_address_3')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="delivery_address_3" placeholder="" value="{{$customer->delivery_address_3}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_registrant_name')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="registrant_name" placeholder="" value="{{$customer->registrant_name}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_invoice_number')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="" name="invoice_number" placeholder="" value="{{$customer->invoice_number}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.closing_group')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" readonly class="form-control" value="{{$customer->closing_group}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.collection_cycle')}}</label>
                                <div class="col-sm-3">
                                    @php
                                        $collection_cycle = App\Enums\ECollectionCycle::getArray();
                                    @endphp
                                    <input type="text" class="form-control" readonly value="{{$customer->collection_cycle ? $collection_cycle[$customer->collection_cycle] : ''}}">
                                </div>
                                <label for="" class="col-sm-2 col-form-label text-end">毎月の回収日</label>
                                <div class="col-sm-3">
                                    @php
                                        $collection_date = App\Enums\ECollectionDate::getArray();
                                    @endphp
                                    @if($customer->monthly_collect_date != 6)
                                        <input type="text" class="form-control" readonly value="{{$customer->monthly_collect_date ? $collection_date[$customer->monthly_collect_date] : ''}}">
                                    @else 
                                        <input  type="text" class="form-control" readonly value="{{date('t')}}日">
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">{{__('admin.customer_file_path')}}</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" class="form-control" id="" name="file_path" placeholder="" value="{{$customer->file_name}}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-8">
                                    <div id="holder" class="flex-column" style="margin-top:5px;max-height:100px;"></div>
                                    @if (!empty($customer->file_name))
                                    <div class="d-flex justify-content-between">
                                        <div class="name-file">{{$customer->file_name}}</div>
                                        <a href="{{$customer->filePath}}" class="text-primary name-file"
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
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')

@endsection



