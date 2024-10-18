@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('settlements.index')}}" title="Settlements">Settlements</a></li>
@endsection
@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item is-active" href="{{route('settlements.index')}}"> All Settlements</a>
            <a class="tab__item " href="?status=settled">Settled Transfers</a>
            <a class="tab__item " href="{{route('settlements.create')}}">Request New Settlement</a>
        </div>
    </div>
    <div class="bg-white padding-20">
        <div class="t-header-search">
            <form action="" onclick="event.preventDefault();">
                <div class="t-header-searchbox font-size-13">
                    <div type="text" class="text search-input__box ">Search Period</div>
                    <div class="t-header-search-content ">
                        <input type="text" class="text" placeholder="Card Number">
                        <input type="text" class="text" placeholder="ID">
                        <input type="text" class="text" placeholder="Date">
                        <input type="text" class="text" placeholder="Email">
                        <input type="text" class="text margin-bottom-20" placeholder="Full Name">
                        <button class="btn btn-brand">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table__box">
        <table class="table">
            <thead role="rowgroup">
            <tr role="row" class="title-row">
                <th>Settlement ID</th>
                <th>User</th>
                <th>From</th>
                <th>To</th>
                <th>Destination Card Number</th>
                <th>Request Date</th>
                <th>Settlement Date</th>
                <th>Amount (ETB)</th>
                <th>Status</th>
                @can(\Abd\RolePermissions\Models\Permission::PERMISSION_MANAGE_SETTLEMENTS)
                <th>Actions</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            @foreach($settlements as $settlement)
                <tr role="row">
                    <td><a href="">{{$settlement->transaction_id ?? '-'}}</a></td>
                    <td><a href="{{route('users.info',$settlement->user_id)}}">{{$settlement->user->name}}</a></td>
                    <td><a href="">{{$settlement->from ? $settlement->from['name'] : '-'}}</a></td>
                    <td><a href="">{{$settlement->to ? $settlement->to['name'] : '-'}}</a></td>
                    <td><a href="">{{$settlement->to ? $settlement->to['card'] : '-'}}</a></td>
                    <td><a href="">{{$settlement->created_at->diffForHumans()}}</a></td>
                    <td><a href="">{{$settlement->settlet_at ? $settlement->settlet_at->diffForHumans():  "-"}}</a></td>
                    <td><a href="">{{number_format($settlement->amount)}}</a></td>
                    <td><a href="" class="{{$settlement->getStatusCssClass()}}">@lang($settlement->status)</a></td>
                    @can(\Abd\RolePermissions\Models\Permission::PERMISSION_MANAGE_SETTLEMENTS)
                        <td>
                            <a href="{{route('settlements.edit', $settlement->id)}}" class="item-edit "
                               title="Edit"></a>
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
