@extends('layouts.app')

@section('title') Earnings @stop

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
                    <th>Total</th>
                    <th>Avg</th>
                    <th>Mines Count</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($earnings as $item)
                    <tr>
                        <td width="40">{{$loop->iteration}}</td>
                        <td>
                            <a href="?account={{$item['account']}}">{{$item['account']}}</a>
                        </td>
                        <td>{{$item['total']}}</td>
                        <td>{{$item['avg']}}</td>
                        <td>{{$item['count']}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td colspan="2"><b>{{$total}}</b></td>
                    <td><b>{{$count}}</b></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop