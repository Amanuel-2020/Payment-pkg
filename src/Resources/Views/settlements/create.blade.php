@extends('Dashboard::master')
@section('breadcrumb')
<li><a href="{{route('settlements.index')}}" title="Settlements">Settlements</a></li>
<li><a href="#" title="Request New Settlement">Request New Settlement</a></li>
@endsection
@section('content')
    <form action="{{route('settlements.store')}}" method="post" class="padding-30 bg-white font-size-14">
        @csrf
        <x-input name="name" placeholder="Card Holder's Name" type="text" required />
        <x-input name="card" placeholder="Card Number" type="text" required />
        <x-input name="amount" value="{{auth()->user()->balance}}" placeholder="Amount in Toman" type="text" required />
        <div class="row no-gutters border-2 margin-bottom-15 text-center ">
            <div class="w-50 padding-20 w-50">Withdrawable Balance:‌</div>
            <div class="bg-fafafa padding-20 w-50"> {{number_format(auth()->user()->balance)}} Toman</div>
        </div>
        <div class="row no-gutters border-2 text-center margin-bottom-15">
            <div class="w-50 padding-20">Maximum Deposit Time:‌</div>
            <div class="w-50 bg-fafafa padding-20">3 days</div>
        </div>
        <button type="submit" class="btn btn-brand">Request Settlement</button>
    </form>
@endsection

