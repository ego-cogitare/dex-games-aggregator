@extends('layouts.app')

@section('title') Staff @stop

@section('left-menu')
    @include('shared.left-menu.index')
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Account</th>
                    <th>Currency</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($balances as $item)
                    <tr>
                        <td width="40">{{$loop->iteration}}</td>
                        <td><a href="?account={{$item['account']}}">{{$item['account']}}</a></td>
                        <td>{{$item['currency']}}</td>
                        <td>{{$item['amount']}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4"><b>Total:</b></td>
                    </tr>
                    @foreach ($total as $currency => $amount)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td colspan="3"><b>{{$amount}}</b> {{$currency}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop