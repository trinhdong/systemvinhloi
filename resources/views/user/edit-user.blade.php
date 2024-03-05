@extends('layouts.app')
@section('title')
    {{-- write css this page--}}
    {{__('admin.user_edit')}}
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
    {{__('admin.user_edit')}}
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('edited-user',$get_user->id) }}" method="post">
                @csrf
                <div class="p-4 rounded">
                    <input type="hidden" name="id_user" value="{{$get_user->id}}">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin: 0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.user_name')}}</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" id="inputEnterYourName" placeholder="{{__('admin.name')}}" value="{{ $get_user->name }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEnterYourName" class="col-sm-2 col-form-label">{{__('admin.user_code')}}</label>
                        <div class="col-sm-8">
                            <input type="text" name="user_code" class="form-control" id="inputEnterYourName" placeholder="{{__('admin.code')}}" value="{{ $get_user->user_code }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPhoneNo2" class="col-sm-2 col-form-label">{{__('admin.user_mail')}}</label>
                        <div class="col-sm-8">
                            <input type="email" name="email" class="form-control" id="inputPhoneNo2" placeholder="{{__('admin.user_mail')}}" value="{{ $get_user->email }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmailAddress2" class="col-sm-2 col-form-label">{{__('admin.user_password')}}</label>
                        <div class="col-sm-8">
                            <input type="password" name="password" class="form-control" id="inputEmailAddress2" placeholder="{{__('admin.user_password')}}" value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputChoosePassword2" class="col-sm-2 col-form-label">{{__('admin.user_role')}}</label>
                        <div class="col-sm-8">
                            @if(Auth::user()->id == $get_user->id && Auth::user()->is_admin == 1)
                                <input type="hidden" name="check_role" value="{{$get_user->role}}">
                            @endif
                            <select class="form-control changestatus" name="role"
                            @if (Illuminate\Support\Facades\Auth::user()->id == $get_user->id)
                                disabled
                            @endif>
                                @foreach ($status['user'] as $key => $item)
                                    <option value="{{ $key }}"
                                        @if ($key === $get_user->role)
                                            selected
                                        @endif>
                                        {{ $item}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 business-id" @if ($get_user->role == 1) style="display: none;" @endif>
                        <label for="inputChoosePassword2" class="col-sm-2 col-form-label">{{__('admin.business_location_name')}}</label>
                        <div class="col-sm-8">
                            @if (Auth::user()->is_admin == 1)
                                <select class="form-control " name="business_location_id">
                                    @foreach ($getBusiness as $key => $item)
                                        <option value="{{$item->id}}"
                                            @if ($item->id === $get_user->business_location_id)
                                                selected
                                            @endif>
                                            {{$item->name}}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control " name="business_location_id" disabled>
                                    @foreach ($getBusiness as $key => $item)
                                        <option value="{{$item->id}}"
                                            @if ($item->id === $get_user->business_location_id)
                                                selected
                                            @endif>
                                            {{$item->name}}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <div>
                <a href="{{ route('list-user') }}" type="button" class="btn btn-primary px-5 mx-2">{{__('admin.btn_back')}}</a>
            </div>
            <div>
                <button type="submit" class="btn btn-primary px-5 mx-2">{{__('admin.btn_save')}}</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $(".changestatus").change(function(){
                value = $(this).val();
                if (value == 1) {
                    $(".business-id").css("display", "none");
                } else {
                    $(".business-id").css("display", "flex");
                }
            });
        });
    </script>
@endsection



