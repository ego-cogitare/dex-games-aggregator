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
                    <th>Img</th>
                    <th>Name</th>
                    <th>Account</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                        $total = 0;
                    @endphp
                    @foreach ($staff as $item)
                        @foreach ($item['staff'] as $name => $amount)
                        <tr>
                            <td width="40">{{$i++}}</td>
                            <td width="50">
{{--                                <img src="/img/{{$item->collectionName}}/{{$name}}.png" width="40" alt="{{$name}}" title="{{$name}}" />--}}
                            </td>
                            <td>{{$name}}</td>
                            <td><a href="?account={{$item['account']}}">{{$item['account']}}</a></td>
                            <td>{{$amount}}</td>
                            @php
                                $total += $amount;
                            @endphp
                        </tr>
                        @endforeach
                    @endforeach
                    <tr>
                        <td colspan="4"><b>Total:</b></td>
                        <td><b>{{$total}}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop