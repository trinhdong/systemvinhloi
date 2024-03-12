@extends('layouts.app')
@section('title')
   Danh sách khu vực
@endsection
@section('css')
    {{-- write css this page--}}
@endsection
@section('breadcrumb')
    {{-- write breadcrumb this page--}}
  Danh sách khu vực
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between m-2 row">
                <div class="col-sm-4 mb-2">
                    <form class="position-relative">
                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i></div>
                        <input class="form-control ps-5 rounded" type="text" placeholder="検索" name="user_name" value="{{ request()->input('user_name') }}">
                    </form>
                </div>
                @if (Auth::user()->is_admin == true || Auth::user()->role == 2)
                    <div class="col-sm-5 col-md-4 col-lg-4 mb-2">
                        <a href="{{route('add-user')}}" type="button" class="btn btn-primary px-5 float-end">{{__('admin.user_add')}}</a>
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table align-middle last-child-right">
                            <thead class="table-secondary">
                            <tr>
                                <th>{{__('admin.code')}}</th>
                                <th>{{__('admin.user_name')}}</th>
                                <th>{{__('admin.user_mail')}}</th>
                                <th>{{__('admin.user_role')}}</th>
                                @if (Auth::user()->is_admin == 1)
                                    <th>{{__('admin.business_location_name')}}</th>
                                @endif
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->user_code}}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3 cursor-pointer">
                                            <div class="">
                                                <p class="mb-0">{{$user->name}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->rolename}}</td>
                                    @if (Auth::user()->is_admin == 1)
                                        <td>{{!empty($user->businessLocation->name) ? $user->businessLocation->name : "本社"}}</td>
                                    @endif
                                    <td>
                                        <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                            <a href="{{route('detail-user',$user->id)}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="詳細"><i class="bi bi-eye-fill"></i></a>
                                            @if (Auth::user()->is_admin == 1 || Auth::user()->role == 2)
                                                <a href="{{route('edit-user',$user->id)}}" class="text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="編集"><i class="bi bi-pencil-fill"></i></a>
                                                <a class="text-danger delete-user" data-bs-toggle="tooltip" data-bs-placement="bottom" title="削除" data-id="{{ $user->id }}"><i class="bi bi-trash-fill"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class=" justify-content-center">
                            {!! $users->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>

    </script>
@endsection



