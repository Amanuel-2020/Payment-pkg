@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{route('purchases.index')}}" title="My Purchases">My Purchases</a></li>
@endsection
@section('content')
    <div class="table__box">
        <table class="table">
            <thead>
            <tr class="title-row">
                <th><font style="vertical-align: inherit;">Course Title</font></th>
                <th><font style="vertical-align: inherit;">Payment Date</font></th>
                <th><font style="vertical-align: inherit;">Amount Paid</font></th>
                <th><font style="vertical-align: inherit;">Payment Status</font></th>
            </tr>
            </thead>
            <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td><font style="vertical-align: inherit;"><a href="{{$payment->paymentable->path()}}" target="_blank">{{$payment->paymentable->title}}</a></font></td>
                    <td><font style="vertical-align: inherit;">{{createJalalianFromCarbon($payment->created_at)}}</font></td>
                    <td><font style="vertical-align: inherit;">{{number_format($payment->amount)}} Toman</font></td>
                    <td class="{{ $payment->status == \Abd\Payment\Models\Payment::STATUS_SUCCESS ? 'text-success' : 'text-error'}}"><font style="vertical-align: inherit;">@lang($payment->status)</font></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$payments->render()}}
    </div>
@endsection
