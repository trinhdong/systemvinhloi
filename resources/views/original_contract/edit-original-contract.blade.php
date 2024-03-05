@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.original_contract_detail')}}
@endsection
@section('css')
    {{-- write css this page--}}
    <style>
        .text-grey{
            color:rgb(122, 120, 120)
        }
        .width-col-258{
            width:258px;
        }
        .width-col-50{
            width:50px;
        }
        .width-col-66{
            width:66px;
        }
        .width-col-90{
            width:90px;
        }
        .padding-input{
            padding:6px 2px;
        }
        .btn-close-col-left{
            color:black;

        }
        .btn-close-col-left:hover{
            color:rgb(121, 121, 121);
        }
        .tab-memo li{
            width: 25%;
        }
    </style>
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.original_contract_detail')}}
@endsection
@section('content')

    <div class="flex-container justify-content-center">
        <div class="col-left mt-5">
            <div class="text-end pb-2" style="color:black">
                <a class="btn-preview-save btn btn-primary text-white mb-1" ><h5 class="m-0">保存</h5></a>
                <a class="btn-preview btn btn-primary text-white mb-1"><h5 class="m-0">プレビュー表示</h5></a>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="p-3 rounded">
                        <div class="row g-3 form-all">
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-7">
                                <div class="row mt-3 d-flex align-items-center">
                                    <label class="form-label col-5 mb-0">{{__('admin.contract_status')}}</label>
                                    <div class="col-7">
                                        <select class="form-select status">
                                            @foreach ($status as $key => $status_original_contract)
                                                <option value="{{$key}}" {{$key==$original_contract->status ? "selected" : "" }}>{{$status_original_contract}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label">{{__('admin.original_contract_order_number')}}</label>
                                <input type="text" class="form-control order_number" name="order_number" value="{{$original_contract->order_number}}" >
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">{{__('admin.contract_order_date')}}</label>
                                <input type="text" class="form-control order_date" name="order_date" value="{{date('Y/m/d', strtotime($original_contract->order_date))}}" >
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">{{__('admin.contract_place_of_import')}}</label>
                                <select class="form-select place_of_import" name="place_of_import">
                                    <option value="" disabled="disabled" selected></option>
                                    @foreach (App\Enums\ELocationContract::getArray() as $id => $location)
                                        <option value="{{$id}}" {{$original_contract->place_of_import == $location ? 'selected' : ''}}>{{$location}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">{{__('admin.contract_created_date')}}</label>
                                <input type="text" class="form-control created_date" name="" value="{{date('Y/m/d', strtotime($original_contract->created_date))}}" >
                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">{{__('admin.contract_slit_number')}}</label>
                                <input type="text" class="form-control slip_number" name="" value="{{$original_contract->slip_number}}" min="1">
                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">{{__('admin.contract_person_in_charge')}}</label>
                                <select class="form-select person_in_charge" name="person_in_charge" id="" >
                                    <option value="" selected disabled>{{__('admin.please_choose')}}</option>
                                    @foreach($list_user as $user)
                                        <option value="{{$user->id}}" {{$original_contract->person_in_charge == $user->id ? 'selected' : ''}}>{{$user->user_code.' - '.$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">{{__('admin.contract_order_code')}}</label>
                                <input type="text" class="form-control order_code" name="" value="{{$original_contract->order_code}}" >
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">{{__('admin.contract_supplier_id')}}</label>
                                <select class="form-select supplier_id" id="supplier_id" name="supplier_id" style="width:100%;">
                                    @if($original_contract->supplier == null)
                                        <option value="" selected disabled></option>
                                    @endif
                                    @foreach ($list_supplier as $supplier)
                                            <option value="{{$supplier->id}}" {{$original_contract->supplier_id == $supplier->id ? 'selected' : ''}}>{{$supplier->supplier_code.' '.$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">{{__('admin.contract_customer_id')}}</label>
                                <select class="form-control customer_id" id="customer_id" name="customer_id" style="width:100%;">
                                    @if($original_contract->Customer == null)
                                        <option value="" selected disabled></option>
                                    @endif
                                    @foreach ($list_customer as $customer)
                                        <option value="{{$customer->id}}" {{$original_contract->customer_id == $customer->id ? 'selected' : ''}}>{{$customer->customer_code.' '.$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-7">
                                <label class="form-label">{{__('admin.contract_delivery_destination')}}</label>
                                <input type="text" class="form-control delivery_destination" name="delivery_destination" value="{{$original_contract->delivery_destination}}" >
                            </div>
                            <div class="col-sm-5">
                                <label class="form-label">{{__('admin.contract_delivery_phone')}}</label>
                                <input type="text" class="form-control delivery_phone_number" name="delivery_phone_number" value="{{$original_contract->delivery_phone_number}}" >
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label">{{__('admin.contract_delivery_address')}}</label>
                                <select name="delivery_address" class="form-control delivery_address">
                                    @if($original_contract->Customer)
                                        <option selected>{{$original_contract->delivery_address}}</option>
                                        <option {{$original_contract->Customer->delivery_address_1==$original_contract->delivery_address?'selected':''}}>{{$original_contract->Customer->delivery_address_1}}</option>
                                        <option {{$original_contract->Customer->delivery_address_2==$original_contract->delivery_address?'selected':''}}>{{$original_contract->Customer->delivery_address_2}}</option>
                                        <option {{$original_contract->Customer->delivery_address_3==$original_contract->delivery_address?'selected':''}}>{{$original_contract->Customer->delivery_address_3}}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <label for="" class="h5">{{__('admin.contract_detail')}} </label> <span class="badge bg-secondary">{{__('admin.contract_big_item')}}</span>
                            </div>
                            <div class="col-sm-12 table-responsive text-nowrap" >
                                <div class="form-input-original-contract" style="min-width:95%;">
                                    <div class="fw-bold d-flex font-strong border-bottom border-top py-1" style="width:100%;">
                                        <div class="px-1 py-2 text-center" style="min-width:258px;width:100%;">{{__('admin.product_code_name')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;">{{__('admin.product_color')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;">取引寸</div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;">{{__('admin.product_inverse')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;">{{__('admin.product_symbol')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;">{{__('admin.product_quantity')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;">{{__('admin.product_unit')}}</div>

                                        <div class="px-1 text-center" style="min-width:200px;width:100%;">
                                            <span>{{__('admin.product_purchage')}}</span>
                                            <div class="d-flex">
                                                <div class="px-1 fw-normal" style="min-width:90px;width:100%;">{{__('admin.product_hanging_rate')}}</div>
                                                <div class="px-1 fw-normal" style="min-width:110px;width:100%;">{{__('admin.product_price')}}</div>
                                            </div>
                                        </div>
                                        <div class="px-1 text-center" style="min-width:200px;width:100%;">
                                            <span>{{__('admin.product_earnings')}}</span>
                                            <div class="d-flex">
                                                <div class="px-1 fw-normal" style="min-width:90px;width:100%;">{{__('admin.product_hanging_rate')}}</div>
                                                <div class="px-1 fw-normal" style="min-width:110px;width:100%;">{{__('admin.product_price')}}</div>
                                            </div>
                                        </div>

                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;">上代</div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;">{{__('admin.product_tax')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;">{{__('admin.product_deadline')}}</div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;"></div>
                                        <div class="px-1 py-2 text-center" style="min-width:66px;width:100%;"></div>
                                    </div>
                                    @foreach($original_contract->originalContractDetail as $key => $item)
                                    <div class="d-flex border-bottom form-memo" data-id="{{$item->id}}">
                                        <div class="px-1 py-2 text-center" style="min-width:258px;;width:100%;">
                                            <div class="input-group">
                                                <input type="text" class="form-control padding-input product_code" value="{{$item->product_code}}" style="min-width:50px;">
                                                <input type="text" class="form-control padding-input product_name" id="product_name_{{$item->id}}" value="{{$item->product_name}}" style="min-width:200px;">
                                            </div>
                                        </div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;"><input class="form-control padding-input color" type="text" value="{{$item->color}}"></div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;">
                                            <button style="min-width:100%" class="btn btn-primary border trade-size-modal-btn" type="button" data-id="{{$item->id}}">
                                                詳細
                                            </button>
                                            <div class="modal fade" id="trade-size-modal-{{$item->id}}" tabindex="-1" aria-labelledby="trade-size-modal-{{$item->id}}" aria-hidden="true" >
                                                <div class="modal-dialog modal-dialog-centered ">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-1"><label class="form-label">取引寸</label></div>
                                                                <div class="col-12">
                                                                    <input type="text" class="form-control padding-input mb-2 trade_size_1" style="min-width:200px;" value="{{$item->trade_size_1}}">
                                                                    <input type="text" class="form-control padding-input trade_size_2" style="min-width:200px;" value="{{$item->trade_size_2}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#trade-size-modal-{{$item->id}}">{{__('admin.btn_back')}}</button>
                                                            <button type="button" class="btn btn-primary save-change-trade" data-bs-toggle="modal" data-bs-target="#trade-size-modal-{{$item->id}}">{{__('admin.btn_create')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;"><input class="form-control padding-input reciprocal_number" type="number" min="1" value="{{$item->reciprocal_number}}"></div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;"><input class="form-control padding-input standard" type="text" value="{{$item->standard}}"></div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;"><input class="form-control padding-input quantity" type="number" min="1" value="{{number_format($item->quantity,2)}}"></div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;"><input class="form-control padding-input unit" type="text" value="{{$item->unit}}"></div>

                                        <div class="px-1 py-2 text-center" style="min-width:90px;width:100%;"><input class="form-control padding-input buy_in_discount_rate" type="number" value="{{$item->buy_in_discount_rate}}"></div>
                                        <div class="px-1 py-2 text-center" style="min-width:110px;width:100%;"><input class="form-control padding-input buy_price" type="number" value="{{$item->buy_price}}"></div>

                                        <div class="px-1 py-2 text-center" style="min-width:90px;width:100%;"><input class="form-control padding-input sales_discount_rate" type="number" value="{{$item->sales_discount_rate}}"></div>
                                        <div class="px-1 py-2 text-center" style="min-width:110px;width:100%;"><input class="form-control padding-input price" type="number" value="{{$item->price}}"></div>

                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;"><input class="form-control padding-input consignment" type="text" value="{{$item->consignment}}"></div>
                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;"><input class="form-control padding-input tax" type="number" min value="{{$item->tax}}"></div>
                                        <div class="px-1 py-2 text-center" style="min-width:110px;width:100%;"><input class="form-control padding-input delivery_term_{{$item->id}}" type="text" value="{{($item->delivery_term == null) ? "" : date('Y/m/d', strtotime($item->delivery_term))}}"></div>

                                        <div class="px-1 py-2 text-center" style="min-width:76px;width:100%;">
                                            <a type="button" class="btn btn-modal-description" data-id="{{$item->id}}" >
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </div>
                                        @if ($key > 0)
                                            <div class="px-1 py-2 text-center" style="min-width:66px;width:100%;">
                                                <a  class="btn delete-line p-2">
                                                    <i class="bi bi-trash-fill text-danger m-0"></i>
                                                </a>
                                            </div>
                                        @else
                                            <div class="px-1 py-2 text-center" style="min-width:66px;width:100%;"></div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 d-flex flex-row-reverse mt-2">
                                <a class="btn btn-secondary add-line mx-2">{{__('admin.contract_add_line')}}</a>
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label">{{__('admin.product_serial_number')}}</label>
                                <input type="text" class="form-control serial_number" value="{{$original_contract->serial_number}}">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">{{__('admin.product_creditor')}}</label>
                                <input type="text" class="form-control created_person" value="{{$original_contract->created_person}}">
                            </div>

                            <div class="col-sm-12">
                                <label class="form-label">{{__('admin.contract_memo')}}</label>
                                <textarea type="text" placeholder="" name="note" class="form-control note">{{$original_contract->note}}</textarea>
                            </div>
                            <div class="col-sm-12 text-center">
                                <button onclick="history.back()" class="btn btn-secondary">{{__('admin.btn_back')}}</button>
                                <button class="btn btn-primary save-memo-all">{{__('admin.btn_save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-right position-relative" hidden>
            <ul class="nav nav-tabs nav-primary d-flex justify-content-center tab-memo" role="tablist">
                <li class="nav-item" role="presentation" >
                    <a class="nav-link active" data-bs-toggle="tab" href="#quotation" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_quotation')}}</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#order" role="tab" aria-selected="false" tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_order')}}</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#purchase" role="tab" aria-selected="false" tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_purchase')}}</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#copy" role="tab" aria-selected="false" tabindex="-1">
                        <div class="d-flex align-items-center">
                            <div class="tab-title">{{__('admin.contract_copy')}}</div>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="card" style="">
                <div class="card-body">
                    <div class="p-2 rounded">
                        <div class="tab-content py-3" style="color:black;">
                            <div class="tab-pane fade active show" id="quotation" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <label class="h3 fw-bold">{{__('admin.contract_quotation')}}</label>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-2 p-1 border border-end-0">{{__('admin.contract_order_date')}}</div>
                                            <div class="col-4 p-1 border border-end-0"><span class="order_date_paper">{{date('Y/m/d', strtotime($original_contract->order_date))}}</span></div>
                                            <div class="col-3 p-1 border border-end-0">{{__('admin.contract_place_of_import')}}</div>
                                            <div class="col-3 p-1 border place_of_import_paper">{{$original_contract->place_of_import}}</div>

                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_supplier_id')}}</div>
                                            @php
                                                $supplier_name = '' ;
                                                foreach($list_supplier as $item){
                                                    if($item->id == $original_contract->supplier_id){
                                                        $supplier_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div class="col-8 p-1 border border-top-0 supplier_id_paper">{{$supplier_name}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                            @php
                                                $customer_name = '' ;
                                                foreach($list_customer as $item){
                                                    if($item->id == $original_contract->customer_id){
                                                        $customer_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div class="col-8 p-1 border border-top-0 customer_id_paper">{{$customer_name}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_destination')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_destination_paper">{{$original_contract->delivery_destination}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_address')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_address_paper">{{$original_contract->delivery_address}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_phone')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_phone_number_paper">{{$original_contract->delivery_phone_number}}</div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                            <div class="col-7 text-end created_date_paper">{{date('Y/m/d', strtotime($original_contract->created_date))}}</div>

                                            <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                            <div class="col-7 text-end slip_number_paper">{{$original_contract->slip_number}}</div>

                                            <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                            <div class="col-7 text-end person_in_charge_paper">{{$original_contract->person_in_charge}}</div>

                                            <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                            <div class="col-7 text-end order_code_paper">{{$original_contract->order_code}}</div>

                                            <div class="col-12" style="font-size:12px">株式会社ヤマプラス</div>
                                            <div class="col-12" style="font-size:12px">本社 東京都港区白金台2-25-1</div>
                                            <div class="col-12" style="font-size:12px">TEL 第１営業部 (03)3443-3355</div>
                                            <div class="col-12" style="font-size:12px">TEL 第２営業部 (03)3443-3371</div>
                                        </div>
                                    </div>
                                    <div class="mask-total col-12 mt-3 ">
                                        <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span class="total_tax"></span><span class="fw-bold">円</span></label>
                                        <span>（{{__('admin.preview_internal_consumption_tax')}}<span class="tax"></span>円）</span>
                                    </div>
                                    <div class="col-12 p-0 mb-4 paper_memo" style="font-size:10px">
                                        <div class="fw-bold d-flex font-small font-strong header-table border-bottom border-top py-1" style="background-color:rgb(227 227 227 / 69%);">
                                            <div class="px-1 py-2 text-center" style="width:180px;">{{__('admin.product_code_name')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_color')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_inverse')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_symbol')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_quantity')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_unit')}}</div>

                                            <div class="px-1 text-center" style="width:140px">
                                                <span>{{__('admin.product_earnings')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:90px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_previous_generation')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_tax')}} </div>
                                            <div class="px-1 py-2 text-center" style="width:100px">{{__('admin.product_deadline')}}</div>
                                        </div>
                                        @if (count($original_contract->originalContractDetail) == 0)
                                            <div class="d-flex justify-content-center border-bottom detail_memo_empty">
                                                <div class="px-1 py-2 text-center" style="width:651px">{{__('message.data_not_found')}}</div>
                                            </div>
                                        @else
                                            @foreach ($original_contract->originalContractDetail as $key => $item)
                                                <div class="d-flex border-bottom detail_memo align-items-center" data-id='{{$item->id}}'>
                                                    <div class="px-1 py-2 text-center product_cover" style="width:180px;">
                                                        <div class="product_code text-grey">{{$item->product_code}}</div>
                                                        <span class="product_name">{{$item->product_name}}</span>
                                                        <div class="description_paper text-grey">{{$item->note}}</div>
                                                    </div>
                                                    <div class="px-1 py-2 text-center color" style="width:33px">{{$item->color}}</div>
                                                    <div class="px-1 py-2 text-center reciprocal_number" style="width:33px">{{$item->reciprocal_number}}</div>
                                                    <div class="px-1 py-2 text-center standard" style="width:33px">{{$item->standard}}</div>
                                                    <div class="px-1 py-2 text-center quantity" style="width:33px">{{$item->quantity}}</div>
                                                    <div class="px-1 py-2 text-center unit" style="width:33px">{{$item->unit}}</div>

                                                    <div class="px-1 py-2 text-center sales_discount_rate" style="width:50px">{{number_format($item->sales_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center price" style="width:90px">{{isset($item->price) ? number_format($item->price) : "" }}</div>

                                                    <div class="px-1 py-2 text-center consignment" style="width:33px">{{number_format($item->consignment)}}</div>
                                                    <div class="px-1 py-2 text-center" style="width:33px"><span class="tax">{{$item->tax}}</span>%</div>
                                                    <div class="px-1 py-2 text-center delivery_term" style="width:100px">{{($item->delivery_term == null) ? "" : date('Y/m/d', strtotime($item->delivery_term))}}</div>
                                                    <div class="d-none product_code">{{$item->product_code}}</div>
                                                    <div class="d-none trade_size_1">{{$item->trade_size_1}}</div>
                                                    <div class="d-none trade_size_2">{{$item->trade_size_2}}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-2">
                                            <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                            <div class="col-7 text-end serial_number_paper">{{$original_contract->serial_number}}</div>

                                            <div class="col-5">{{__('admin.product_creditor')}}</div>
                                            <div class="col-7 text-end created_person_paper">{{$original_contract->created_person}}</div>

                                            <div class="col-5">{{__('admin.contract_memo')}}</div>
                                        </div>
                                        <div class="text-grey">
                                            <span class="note_paper">{{$original_contract->note}}</span>
                                        </div>
                                    </div>
                                    <div class="col-6 mask-total">
                                        <div class="row">
                                            <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                            <div class="col-6 text-end"><span class="total"></span>　円</div>

                                            <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                            <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                            <div class="col-6">{{__('admin.preview_total')}}</div>
                                            <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                            <div class="tax_percent col-12">
                                                <div class="row">
                                                    <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                            class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                    <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                    <div class="col-6"></div>
                                                    <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="order" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <label class="h3 fw-bold">{{__('admin.contract_order')}}</label>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-2 p-1 border border-end-0">{{__('admin.contract_order_date')}}</div>
                                            <div class="col-4 p-1 border border-end-0"><span class="order_date_paper">{{date('Y/m/d', strtotime($original_contract->order_date))}}</span></div>
                                            <div class="col-3 p-1 border border-end-0">{{__('admin.contract_place_of_import')}}</div>
                                            <div class="col-3 p-1 border place_of_import_paper">{{$original_contract->place_of_import}}</div>

                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_supplier_id')}}</div>
                                            @php
                                                $supplier_name = '' ;
                                                foreach($list_supplier as $item){
                                                    if($item->id == $original_contract->supplier_id){
                                                        $supplier_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div class="col-8 p-1 border border-top-0 supplier_id_paper">{{$supplier_name}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                            @php
                                                $customer_name = '' ;
                                                foreach($list_customer as $item){
                                                    if($item->id == $original_contract->customer_id){
                                                        $customer_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div class="col-8 p-1 border border-top-0 customer_id_paper">{{$customer_name}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_destination')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_destination_paper">{{$original_contract->delivery_destination}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_address')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_address_paper">{{$original_contract->delivery_address}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_phone')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_phone_number_paper">{{$original_contract->delivery_phone_number}}</div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                            <div class="col-7 text-end created_date_paper">{{date('Y/m/d', strtotime($original_contract->created_date))}}</div>

                                            <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                            <div class="col-7 text-end slip_number_paper">{{$original_contract->slip_number}}</div>

                                            <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                            <div class="col-7 text-end person_in_charge_paper">{{$original_contract->person_in_charge}}</div>

                                            <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                            <div class="col-7 text-end order_code_paper">{{$original_contract->order_code}}</div>

                                            <div class="col-12" style="font-size:12px">株式会社ヤマプラス</div>
                                            <div class="col-12" style="font-size:12px">本社 東京都港区白金台2-25-1</div>
                                            <div class="col-12" style="font-size:12px">TEL 第１営業部 (03)3443-3355</div>
                                            <div class="col-12" style="font-size:12px">TEL 第２営業部 (03)3443-3371</div>
                                        </div>
                                    </div>
                                    <div class="mask-total col-12 mt-3 ">
                                        <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span class="total_tax"></span><span class="fw-bold">円</span></label>
                                        <span>（{{__('admin.preview_internal_consumption_tax')}}<span class="tax"></span>円）</span>
                                    </div>
                                    <div class="col-12 p-0 mb-4 paper_memo_2" style="font-size:10px">
                                        <div class="fw-bold justify-content-center d-flex font-small font-strong header-table border-bottom border-top py-1" style="background-color:rgb(227 227 227 / 69%);">
                                            <div class="px-1 py-2 text-center text-wrap" style="width:120px;">{{__('admin.product_code_name')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_color')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_inverse')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_symbol')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_quantity')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_unit')}}</div>

                                            <div class="px-1 text-center" style="width:80px">
                                                <span>{{__('admin.product_purchage')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:29px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 text-center" style="width:80px">
                                                <span>{{__('admin.product_earnings')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:29px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_previous_generation')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_tax')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:90px">{{__('admin.product_deadline')}}</div>
                                        </div>
                                        @if (count($original_contract->originalContractDetail) == 0)
                                            <div class="d-flex justify-content-center border-bottom detail_memo_empty">
                                                <div class="px-1 py-2 text-center" style="width:651px">{{__('message.data_not_found')}}</div>
                                            </div>
                                        @else
                                            @foreach ($original_contract->originalContractDetail as $key => $item)
                                                <div class="d-flex justify-content-center align-items-center border-bottom detail_memo" data-id="{{$item->id}}">
                                                    <div class="px-1 py-2 text-center text-wrap product_cover" style="width:120px;">
                                                        <div class="product_code text-grey">{{$item->product_code}}</div>
                                                        <span class="product_name">{{$item->product_name}}</span>
                                                        <div class="description_paper text-grey">{{$item->note}}</div>
                                                    </div>
                                                    <div class="px-1 py-2 text-center color" style="width:29px">{{$item->color}}</div>
                                                    <div class="px-1 py-2 text-center reciprocal_number" style="width:29px">{{$item->reciprocal_number}}</div>
                                                    <div class="px-1 py-2 text-center standard" style="width:29px">{{$item->standard}}</div>
                                                    <div class="px-1 py-2 text-center quantity" style="width:29px">{{$item->quantity}}</div>
                                                    <div class="px-1 py-2 text-center unit" style="width:29px">{{$item->unit}}</div>

                                                    <div class="px-1 py-2 text-center buy_in_discount_rate" style="width:29px">{{number_format($item->buy_in_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center buy_price" style="width:50px">{{number_format($item->buy_price)}}</div>

                                                    <div class="px-1 py-2 text-center sales_discount_rate" style="width:29px">{{number_format($item->sales_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center price" style="width:50px">{{isset($item->price) ? number_format($item->price) : "" }}</div>

                                                    <div class="px-1 py-2 text-center consignment" style="width:29px">{{number_format($item->consignment)}}</div>
                                                    <div class="px-1 py-2 text-center" style="width:29px"><span class="tax">{{$item->tax}}</span>%</div>
                                                    <div class="px-1 py-2 text-center delivery_term" style="width:90px">{{($item->delivery_term == null) ? "" : date('Y/m/d', strtotime($item->delivery_term))}}</div>
                                                    <div class="d-none trade_size_1">{{$item->trade_size_1}}</div>
                                                    <div class="d-none trade_size_2">{{$item->trade_size_2}}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-2">
                                            <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                            <div class="col-7 text-end serial_number_paper">{{$original_contract->serial_number}}</div>

                                            <div class="col-5">{{__('admin.product_creditor')}}</div>
                                            <div class="col-7 text-end created_person_paper">{{$original_contract->created_person}}</div>

                                            <div class="col-5">{{__('admin.contract_memo')}}</div>
                                        </div>
                                        <div class="text-grey">
                                            <span class="note_paper">{{$original_contract->note}}</span>
                                        </div>
                                    </div>
                                    <div class="col-6 mask-total">
                                        <div class="row">
                                            <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                            <div class="col-6 text-end"><span class="total"></span>　円</div>

                                            <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                            <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                            <div class="col-6">{{__('admin.preview_total')}}</div>
                                            <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                            <div class="tax_percent col-12">
                                                <div class="row">
                                                    <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                            class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                    <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                    <div class="col-6"></div>
                                                    <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="purchase" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <label class="h3 fw-bold">{{__('admin.contract_purchase')}}</label>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-2 p-1 border border-end-0">{{__('admin.contract_order_date')}}</div>
                                            <div class="col-4 p-1 border border-end-0"><span class="order_date_paper">{{date('Y/m/d', strtotime($original_contract->order_date))}}</span></div>
                                            <div class="col-3 p-1 border border-end-0">{{__('admin.contract_place_of_import')}}</div>
                                            <div class="col-3 p-1 border place_of_import_paper">{{$original_contract->place_of_import}}</div>

                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_supplier_id')}}</div>
                                            @php
                                                $supplier_name = '' ;
                                                foreach($list_supplier as $item){
                                                    if($item->id == $original_contract->supplier_id){
                                                        $supplier_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div class="col-8 p-1 border border-top-0 supplier_id_paper">{{$supplier_name}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                            @php
                                                $customer_name = '' ;
                                                foreach($list_customer as $item){
                                                    if($item->id == $original_contract->customer_id){
                                                        $customer_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div class="col-8 p-1 border border-top-0 customer_id_paper">{{$customer_name}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_destination')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_destination_paper">{{$original_contract->delivery_destination}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_address')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_address_paper">{{$original_contract->delivery_address}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_phone')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_phone_number_paper">{{$original_contract->delivery_phone_number}}</div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                            <div class="col-7 text-end created_date_paper">{{date('Y/m/d', strtotime($original_contract->created_date))}}</div>

                                            <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                            <div class="col-7 text-end slip_number_paper">{{$original_contract->slip_number}}</div>

                                            <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                            <div class="col-7 text-end person_in_charge_paper">{{$original_contract->person_in_charge}}</div>

                                            <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                            <div class="col-7 text-end order_code_paper">{{$original_contract->order_code}}</div>

                                            <div class="col-12" style="font-size:12px">株式会社ヤマプラス</div>
                                            <div class="col-12" style="font-size:12px">本社 東京都港区白金台2-25-1</div>
                                            <div class="col-12" style="font-size:12px">TEL 第１営業部 (03)3443-3355</div>
                                            <div class="col-12" style="font-size:12px">TEL 第２営業部 (03)3443-3371</div>
                                        </div>
                                    </div>
                                    <div class="mask-total col-12 mt-3 ">
                                        <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span class="total_tax"></span><span class="fw-bold">円</span></label>
                                        <span>（{{__('admin.preview_internal_consumption_tax')}}<span class="tax"></span>円）</span>
                                    </div>
                                    <div class="col-12 p-0 mb-4 paper_memo" style="font-size:10px">
                                        <div class="fw-bold d-flex font-small font-strong header-table border-bottom border-top py-1" style="background-color:rgb(227 227 227 / 69%);">
                                            <div class="px-1 py-2 text-center" style="width:180px;">{{__('admin.product_code_name')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_color')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_inverse')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_symbol')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_quantity')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_unit')}}</div>

                                            <div class="px-1 text-center" style="width:140px">
                                                <span>{{__('admin.product_earnings')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:90px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_previous_generation')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:33px">{{__('admin.product_tax')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:100px">{{__('admin.product_deadline')}}</div>
                                        </div>
                                        @if (count($original_contract->originalContractDetail) == 0)
                                            <div class="d-flex justify-content-center border-bottom detail_memo_empty">
                                                <div class="px-1 py-2 text-center" style="width:651px">{{__('message.data_not_found')}}</div>
                                            </div>
                                        @else
                                            @foreach ($original_contract->originalContractDetail as $key => $item)
                                                <div class="d-flex border-bottom detail_memo align-items-center" data-id='{{$item->id}}'>
                                                    <div class="px-1 py-2 text-center product_cover" style="width:180px;">
                                                        <div class="product_code text-grey">{{$item->product_code}}</div>
                                                        <span class="product_name">{{$item->product_name}}</span>
                                                        <div class="description_paper text-grey">{{$item->note}}</div>
                                                    </div>
                                                    <div class="px-1 py-2 text-center color" style="width:33px">{{$item->color}}</div>
                                                    <div class="px-1 py-2 text-center reciprocal_number" style="width:33px">{{$item->reciprocal_number}}</div>
                                                    <div class="px-1 py-2 text-center standard" style="width:33px">{{$item->standard}}</div>
                                                    <div class="px-1 py-2 text-center quantity" style="width:33px">{{$item->quantity}}</div>
                                                    <div class="px-1 py-2 text-center unit" style="width:33px">{{$item->unit}}</div>

                                                    <div class="px-1 py-2 text-center sales_discount_rate" style="width:50px">{{number_format($item->sales_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center price" style="width:90px">{{isset($item->price) ? number_format($item->price) : "" }}</div>

                                                    <div class="px-1 py-2 text-center consignment" style="width:33px">{{number_format($item->consignment)}}</div>
                                                    <div class="px-1 py-2 text-center" style="width:33px"><span class="tax">{{$item->tax}}</span>%</div>
                                                    <div class="px-1 py-2 text-center delivery_term" style="width:100px">{{($item->delivery_term == null) ? "" : date('Y/m/d', strtotime($item->delivery_term))}}</div>
                                                    <div class="d-none product_code">{{$item->product_code}}</div>
                                                    <div class="d-none trade_size_1">{{$item->trade_size_1}}</div>
                                                    <div class="d-none trade_size_2">{{$item->trade_size_2}}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-2">
                                            <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                            <div class="col-7 text-end serial_number_paper">{{$original_contract->serial_number}}</div>

                                            <div class="col-5">{{__('admin.product_creditor')}}</div>
                                            <div class="col-7 text-end created_person_paper">{{$original_contract->created_person}}</div>

                                            <div class="col-5">{{__('admin.contract_memo')}}</div>
                                        </div>
                                        <div class="text-grey">
                                            <span class="note_paper">{{$original_contract->note}}</span>
                                        </div>
                                    </div>
                                    <div class="col-6 mask-total">
                                        <div class="row">
                                            <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                            <div class="col-6 text-end"><span class="total"></span>　円</div>

                                            <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                            <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                            <div class="col-6">{{__('admin.preview_total')}}</div>
                                            <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                            <div class="tax_percent col-12">
                                                <div class="row">
                                                    <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                            class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                    <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                    <div class="col-6"></div>
                                                    <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="copy" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <label class="h3 fw-bold">{{__('admin.contract_copy')}}</label>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-2 p-1 border border-end-0">{{__('admin.contract_order_date')}}</div>
                                            <div class="col-4 p-1 border border-end-0"><span class="order_date_paper">{{date('Y/m/d', strtotime($original_contract->order_date))}}</span></div>
                                            <div class="col-3 p-1 border border-end-0">{{__('admin.contract_place_of_import')}}</div>
                                            <div class="col-3 p-1 border place_of_import_paper">{{$original_contract->place_of_import}}</div>

                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_supplier_id')}}</div>
                                            @php
                                                $supplier_name = '' ;
                                                foreach($list_supplier as $item){
                                                    if($item->id == $original_contract->supplier_id){
                                                        $supplier_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div class="col-8 p-1 border border-top-0 supplier_id_paper">{{$supplier_name}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_customer_id')}}</div>
                                            @php
                                                $customer_name = '' ;
                                                foreach($list_customer as $item){
                                                    if($item->id == $original_contract->customer_id){
                                                        $customer_name = $item->name;
                                                    }
                                                }
                                            @endphp
                                            <div class="col-8 p-1 border border-top-0 customer_id_paper">{{$customer_name}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_destination')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_destination_paper">{{$original_contract->delivery_destination}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_address')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_address_paper">{{$original_contract->delivery_address}}</div>
                                            <div class="col-4 p-1 border border-top-0 border-end-0">{{__('admin.contract_delivery_phone')}}</div>
                                            <div class="col-8 p-1 border border-top-0 delivery_phone_number_paper">{{$original_contract->delivery_phone_number}}</div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-5">{{__('admin.contract_created_date')}}</div>
                                            <div class="col-7 text-end created_date_paper">{{date('Y/m/d', strtotime($original_contract->created_date))}}</div>

                                            <div class="col-5">{{__('admin.contract_slit_number')}}</div>
                                            <div class="col-7 text-end slip_number_paper">{{$original_contract->slip_number}}</div>

                                            <div class="col-5">{{__('admin.contract_person_in_charge')}}</div>
                                            <div class="col-7 text-end person_in_charge_paper">{{$original_contract->person_in_charge}}</div>

                                            <div class="col-5">{{__('admin.contract_order_code')}}</div>
                                            <div class="col-7 text-end order_code_paper">{{$original_contract->order_code}}</div>

                                            <div class="col-12" style="font-size:12px">株式会社ヤマプラス</div>
                                            <div class="col-12" style="font-size:12px">本社 東京都港区白金台2-25-1</div>
                                            <div class="col-12" style="font-size:12px">TEL 第１営業部 (03)3443-3355</div>
                                            <div class="col-12" style="font-size:12px">TEL 第２営業部 (03)3443-3371</div>
                                        </div>
                                    </div>
                                    <div class="mask-total col-12 mt-3 ">
                                        <label class="h5"> <span class="fw-bold">{{__('admin.preview_estimated_amount')}}</span> <span class="total_tax"></span><span class="fw-bold">円</span></label>
                                        <span>（{{__('admin.preview_internal_consumption_tax')}}<span class="tax"></span>円）</span>
                                    </div>
                                    <div class="col-12 p-0 mb-4 paper_memo_2" style="font-size:10px">
                                        <div class="fw-bold justify-content-center d-flex font-small font-strong header-table border-bottom border-top py-1" style="background-color:rgb(227 227 227 / 69%);">
                                            <div class="px-1 py-2 text-center text-wrap" style="width:120px;">{{__('admin.product_code_name')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_color')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_inverse')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_symbol')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_quantity')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_unit')}}</div>

                                            <div class="px-1 text-center" style="width:80px">
                                                <span>{{__('admin.product_purchage')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:29px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 text-center" style="width:80px">
                                                <span>{{__('admin.product_earnings')}}</span>
                                                <div class="d-flex">
                                                    <div class="px-1 fw-normal" style="width:29px">{{__('admin.product_hanging_rate')}}</div>
                                                    <div class="px-1 fw-normal" style="width:50px">{{__('admin.product_price')}}</div>
                                                </div>
                                            </div>

                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_previous_generation')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:29px">{{__('admin.product_tax')}}</div>
                                            <div class="px-1 py-2 text-center" style="width:90px">{{__('admin.product_deadline')}}</div>
                                        </div>
                                        @if (count($original_contract->originalContractDetail) == 0)
                                            <div class="d-flex justify-content-center border-bottom detail_memo_empty">
                                                <div class="px-1 py-2 text-center" style="width:651px">{{__('message.data_not_found')}}</div>
                                            </div>
                                        @else
                                            @foreach ($original_contract->originalContractDetail as $key => $item)
                                                <div class="d-flex justify-content-center align-items-center border-bottom detail_memo" data-id="{{$item->id}}">
                                                    <div class="px-1 py-2 text-center text-wrap product_cover" style="width:120px;">
                                                        <div class="product_code text-grey">{{$item->product_code}}</div>
                                                        <span class="product_name">{{$item->product_name}}</span>
                                                        <div class="description_paper text-grey">{{$item->note}}</div>
                                                    </div>
                                                    <div class="px-1 py-2 text-center color" style="width:29px">{{$item->color}}</div>
                                                    <div class="px-1 py-2 text-center reciprocal_number" style="width:29px">{{$item->reciprocal_number}}</div>
                                                    <div class="px-1 py-2 text-center standard" style="width:29px">{{$item->standard}}</div>
                                                    <div class="px-1 py-2 text-center quantity" style="width:29px">{{$item->quantity}}</div>
                                                    <div class="px-1 py-2 text-center unit" style="width:29px">{{$item->unit}}</div>

                                                    <div class="px-1 py-2 text-center buy_in_discount_rate" style="width:29px">{{number_format($item->buy_in_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center buy_price" style="width:50px">{{number_format($item->buy_price)}}</div>

                                                    <div class="px-1 py-2 text-center sales_discount_rate" style="width:29px">{{number_format($item->sales_discount_rate,1)}}</div>
                                                    <div class="px-1 py-2 text-center price" style="width:50px">{{isset($item->price) ? number_format($item->price) : "" }}</div>

                                                    <div class="px-1 py-2 text-center consignment" style="width:29px">{{number_format($item->consignment)}}</div>
                                                    <div class="px-1 py-2 text-center" style="width:29px"><span class="tax">{{$item->tax}}</span>%</div>
                                                    <div class="px-1 py-2 text-center delivery_term" style="width:90px">{{($item->delivery_term == null) ? "" : date('Y/m/d', strtotime($item->delivery_term))}}</div>
                                                    <div class="d-none trade_size_1">{{$item->trade_size_1}}</div>
                                                    <div class="d-none trade_size_2">{{$item->trade_size_2}}</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-2">
                                            <div class="col-5">{{__('admin.product_serial_number')}}</div>
                                            <div class="col-7 text-end serial_number_paper">{{$original_contract->serial_number}}</div>

                                            <div class="col-5">{{__('admin.product_creditor')}}</div>
                                            <div class="col-7 text-end created_person_paper">{{$original_contract->created_person}}</div>

                                            <div class="col-5">{{__('admin.contract_memo')}}</div>
                                        </div>
                                        <div class="text-grey">
                                            <span class="note_paper"></span>
                                        </div>
                                    </div>
                                    <div class="col-6 mask-total">
                                        <div class="row">
                                            <div class="col-6">{{__('admin.preview_subtotal')}}</div>
                                            <div class="col-6 text-end"><span class="total"></span>　円</div>

                                            <div class="col-6">{{__('admin.preview_consumption_tax')}}</div>
                                            <div class="col-6 text-end"><span class="tax"></span>　円</div>

                                            <div class="col-6">{{__('admin.preview_total')}}</div>
                                            <div class="col-6 text-end"><span class="total_tax"></span>　円</div>

                                            <div class="tax_percent col-12">
                                                <div class="row">
                                                    <div class="col-6 text-grey">{{__('admin.preview_items')}} <span
                                                            class="percent_tax"></span>{{__('admin.preview_percent_tax')}}</div>
                                                    <div class="col-6 text-end text-grey"><span class="total"></span>　円</div>

                                                    <div class="col-6"></div>
                                                    <div class="col-6 text-end text-grey"><span class="tax"></span>　円</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">{{__('admin.contract_memo')}}</label>
                            <textarea type="text" class="form-control description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#descriptionModal">{{__('admin.btn_back')}}</button>
                    <button type="button" class="btn btn-primary save-change-desc">{{__('admin.btn_save')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="js/edit-memo-original-contract.js"></script>
    <script>
        $( document ).ready(function() {
            $('.delivery_address').select2({
                tags: true,
                theme: 'bootstrap4',
            });

            $(document).on('change','select.delivery_address',function(){
                address = $('select.delivery_address option:selected').text()
                $('.delivery_address_paper').text(address)
            });

            $(document).on('change','select[name=customer_id]',function() {
                $('.customer_id_paper').text($('select[name=customer_id] option:selected').text())
                console.log( $('.customer_id_paper').text($('select[name=customer_id] option:selected').text()))
                id = $(this).val()
                $.ajax({
                    type: "GET",
                    url: "{{ route('get-list-address-customer') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data['status'] == true) {
                            html_customer = '<option disabled ></option>'
                            if(data['customer'].delivery_address_1 != null){
                                html_customer += '<option>' + data['customer'].delivery_address_1 + '</option>'
                            }
                            if(data['customer'].delivery_address_2 != null){
                                html_customer += '<option>' + data['customer'].delivery_address_2 + '</option>'
                            }
                            if(data['customer'].delivery_address_3 != null){
                                html_customer += '<option>' + data['customer'].delivery_address_3 + '</option>'
                            }
                            textAddress = '東京都港区白金台2-25-1';
                        $('.delivery_address option').each(function(i, obj) {
                            if(obj.text != textAddress){
                                obj.remove();
                            }
                        });
                        if (html_customer == '<option disabled ></option>') {
                            $('select[name=delivery_address]').append('<option disabled value="">{{__('message.data_not_found')}}</option>');
                            } else {
                                $('.delivery_address_paper').text('')
                                $('select[name=delivery_address]').append(html_customer);
                            }
                        } else {
                            btn_save.prop("disabled", false);
                            Lobibox.notify('error', {
                                title: 'エラー',
                                pauseDelayOnHover: true,
                                continueDelayOnInactiveTab: false,
                                position: 'top right',
                                icon: 'bx bx-x-circle',
                                msg: data['message']
                            });
                        }
                    },
                })
            });
            // auto fill price and buy_price
            $(document).on('input','.consignment',function(){
                buy_price = $(this).closest('.form-memo').find('.buy_price');
                buy_in_discount_rate = $(this).closest('.form-memo').find('.buy_in_discount_rate');
                price = $(this).closest('.form-memo').find('.price');
                sales_discount_rate = $(this).closest('.form-memo').find('.sales_discount_rate');
                
                if(buy_in_discount_rate.val() != ""){
                    _buy_price = parseFloat($(this).val()) * parseFloat(buy_in_discount_rate.val()) / 100;
                    buy_price.val(_buy_price);
                }

                if(sales_discount_rate.val() != ""){
                    _price = parseFloat($(this).val()) * parseFloat(sales_discount_rate.val()) / 100;
                    price.val(_price);
                }
            })
            $(document).on('input','.buy_in_discount_rate',function(){
                consignment = $(this).closest('.form-memo').find('.consignment');
                buy_price = $(this).closest('.form-memo').find('.buy_price');

                if(consignment.val() != ""){
                    _buy_price = parseFloat(consignment.val()) * parseFloat($(this).val()) / 100;
                    buy_price.val(_buy_price)
                }
            })
            $(document).on('input','.sales_discount_rate',function(){
                consignment = $(this).closest('.form-memo').find('.consignment');
                price = $(this).closest('.form-memo').find('.price');
                if(consignment.val() != ""){
                    _price = parseFloat(consignment.val()) * parseFloat($(this).val()) / 100;
                    price.val(_price)
                }
            })
           let list_original_contract_detail = {!! $original_contract->originalContractDetail !!}
            $.each(list_original_contract_detail, function (i, item) {
                $('#product_name_'+item.id).autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "/original_contract/list-original-product",
                            data: {
                                search: request.term
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 1,
                    select: function (event, ui) {
                        $('#product_name_'+item.id).val(ui.item.label);
                        return false;
                    }
                });

               $('.delivery_term_'+item.id).bootstrapMaterialDatePicker({
                   cancelText: "Abbrechen",
                   time: false,
                   format: 'YYYY/MM/DD',
                   cancelText:"戻る",
                   okText:"選択",
                   lang: "ja",
               });
               $('.delivery_term_'+item.id).on('dateSelected', function(e, date) {
                id = $(this).attr('data-dtp')
        $("#"+id+" .dtp-btn-ok" ).trigger( "click" );
                });
            });

            $(document).on('click','.trade-size-modal-btn',function(){
                id = $(this).data('id')
                tradeSizeModal = new bootstrap.Modal($('#trade-size-modal-'+id), {});
                tradeSizeModal.show();
            })

            getOriginalTotal();
            $('.save-memo-all').click(function () {

                _update_line = updateLine();
                if(_update_line == false){
                    return false;
                }

                btn_save = $(this);
                btn_save.prop("disabled", true);
                data = getDataMemoOriginalContract()
                data_detail = getDataMemoOriginalContractDetail()
                id = {!! $original_contract->id !!}
                $.ajax({
                    type: "POST",
                    url: "{{ route('edit-original-contract-post') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        data: data,
                        data_detail: data_detail,
                        id : id,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data['status'] == true) {
                            window.location.href = "{{ route('original-contract-list')}}"
                        } else {
                            btn_save.prop("disabled", false);
                            Lobibox.notify('error', {
                                title: 'エラー',
                                pauseDelayOnHover: true,
                                continueDelayOnInactiveTab: false,
                                position: 'top right',
                                icon: 'bx bx-x-circle',
                                msg: data['message']
                            });
                        }
                    },
                    error: function (data) {
                        btn_save.prop("disabled", false);
                        console.log(data.responseJSON.errors);
                        $.each(data.responseJSON.errors, function (key, value) {
                            Lobibox.notify('error', {
                                title: 'エラー',
                                pauseDelayOnHover: true,
                                continueDelayOnInactiveTab: false,
                                position: 'top right',
                                icon: 'bx bx-x-circle',
                                msg: value
                            });
                        });
                    }
                })
            })
            // Event click save preview 
            $('.btn-preview-save').click(function(){
                _update_line = updateLineNotValidate();
                data = getDataMemoContractPreview();
                savePreviewAjax(data);
            })
            // Event click preview 
            $('.btn-preview').click(function(){
                _update_line = updateLineNotValidate();
                if(_update_line == false){
                    return false;
                }
                data = getDataMemoContractPreview();
                //var win = window.open('/original_contract/preview?'+$.param(data), '_blank');
                savePreviewAjax(data);
                var win = window.open('/maker_execution/preview');
                if (win) {
                    win.focus();
                } else {
                    //Browser has blocked it
                    alert('Please allow popups for this website');
                }
            })

            function getDataMemoContractPreview(){
                data_contract = {
                    order_number : $('.form-all input.order_number').val(),
                    order_date : $('.form-all input.order_date').val(),
                    place_of_import : $('.form-all select.place_of_import option:selected').val(),
                    created_date : $('.form-all input.created_date').val(),
                    slip_number : $('.form-all input.slip_number').val(),
                    person_in_charge : $('.form-all select.person_in_charge').val(),
                    order_code : $('.form-all input.order_code').val(),
                    supplier_id : $('.form-all select.supplier_id').val(),
                    customer_id : $('.form-all select.customer_id').val(),
                    delivery_destination : $('.form-all input.delivery_destination').val(),
                    delivery_phone_number : $('.form-all input.delivery_phone_number').val(),
                    delivery_address : $('.form-all select.delivery_address option:selected').text(),
                    serial_number: $('.form-all input.serial_number').val(),
                    created_person: $('.form-all input.created_person').val(),
                    note : $('.form-all textarea.note').val(),
                    status : $('.status').val(),
                    item_contract : [],
                }
                $('#copy .detail_memo').each(function( index ){
                    element = {
                        product_code : $(this).find('.product_code').text(),
                        product_name: $(this).find('.product_name').text(),
                        
                        color: $(this).find('.color').text(),
                        reciprocal_number: $(this).find('.reciprocal_number').text(),
                        standard: $(this).find('.standard').text(),
                        quantity: $(this).find('.quantity').text().replace(/,/g, ''),
                        unit: $(this).find('.unit').text(),

                        buy_in_discount_rate: $(this).find('.buy_in_discount_rate').text().replace(/,/g, ''),
                        buy_price: $(this).find('.buy_price').text().replace(/,/g, ''),
                        sales_discount_rate: $(this).find('.sales_discount_rate').text(),
                        price: $(this).find('.price').text().replace(/,/g, ''),

                        tax: $(this).find('.tax').text(),
                        delivery_term: $(this).find('.delivery_term').text(),
                        consignment: $(this).find('.consignment').text().replace(/,/g, ''),
                        note : $(this).find('.description_paper').text(),
                        trade_size_1 : $(this).find('.trade_size_1').text(),
                        trade_size_2 : $(this).find('.trade_size_2').text(),
                    }
                    data_contract.item_contract.push(element);
                })
                return data_contract;
            }
            $('.place_of_import').change(function(){
                checkType = $(this).find('option:selected').text()
                textAddress = '東京都港区白金台2-25-1';
                if(checkType == '本社'){
                    checkExist = false ;
                    $('.delivery_address option').each(function(i, obj) {
                        if(obj.text == textAddress){
                            checkExist = true ; 
                        }
                    });
                    if(checkExist == false){
                        var newState = new Option(textAddress, textAddress, true, true);
                        $(".delivery_address").append(newState).trigger('change');
                    } else {
                        $("#myMultipleSelect2").val(textAddress).trigger('change');
                    }
                }else {
                    $('.delivery_address option').each(function(i, obj) {
                        if(obj.text == textAddress){
                            obj.remove();
                        }
                    });
                }
            })

            //send ajax save session
            async function savePreviewAjax(data){
                await $.ajax({
                    type: "POST",
                    url: "{{ route('supplier-contract.savePreview') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        data : data,
                    },
                    dataType: 'json',
                    success: function(data) {
                    if (data['status'] == true) {
                            Lobibox.notify('success', {
                                title: '成功',
                                pauseDelayOnHover: true,
                                continueDelayOnInactiveTab: false,
                                position: 'top right',
                                icon: 'bx bx-check-circle',
                                msg: data['message']
                            });
                        } else {
                            //btn_save.prop("disabled", false);
                            Lobibox.notify('error', {
                                title: 'エラー',
                                pauseDelayOnHover: true,
                                continueDelayOnInactiveTab: false,
                                position: 'top right',
                                icon: 'bx bx-x-circle',
                                msg: data['message']
                            });
                        }
                    },
                    error:function(data){
                        btn_save.prop("disabled", false);
                        $.each(data.responseJSON.errors, function( key, value ) {
                            Lobibox.notify('error', {
                                title: 'エラー',
                                pauseDelayOnHover: true,
                                continueDelayOnInactiveTab: false,
                                position: 'top right',
                                icon: 'bx bx-x-circle',
                                msg: value
                            });
                        });
                    }
                })
            }
        });
    </script>
@endsection



