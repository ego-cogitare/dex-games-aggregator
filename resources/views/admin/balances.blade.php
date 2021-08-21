@extends('layouts.app')

@section('title') Balances @stop

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
                    <th>Est. USD</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($balances as $item)
                    <tr>
                        <td width="40">{{$loop->iteration}}</td>
                        <td>
                            <a href="?account={{$item['account']}}">{{$item['account']}}</a>
                        </td>
                        <td>
                            <a href="?currency={{$item['currency']}}">{{$item['currency']}}</a>
                        </td>
                        <td>{{$item['amount']}}</td>
                        <td>${{ sprintf('%.2f', $item['estUSD']) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                    <tr>
                        <td colspan="5">
                            <b>Total</b>
                        </td>
                    </tr>
                    @foreach ($total as $currency => $amount)
                        <tr>
                            <td>
                                <a href="?currency={{ $currency }}">{{ $currency }}</a>
                            </td>
                            <td colspan="2">&nbsp;</td>
                            <td>
                                <b>{{ $amount }}</b>
                            </td>
                            <td>
                                <b>${{ sprintf('%.2f', $amount * ($prices[$currency] ?? 0)) }}</b>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop