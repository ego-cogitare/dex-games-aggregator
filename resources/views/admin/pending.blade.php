@extends('layouts.app')

@section('title') Pending Orders @stop

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
                    <th>Price, WAX</th>
                    <th>Created At</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($data['orders'] as $item)
                    <tr>
                        <td width="40">{{ $loop->iteration }}</td>
                        <td width="50">
                            <img src="/img/{{$item->collectionName}}/{{$item->staff}}.png" width="40" alt="{{$item->staff}}" title="{{$item->staff}}" />
                        </td>
                        <td>{{$item->staff}}</td>
                        <td><a href="?account={{$item->account}}">{{$item->account}}</a></td>
                        <td>{{$item->price}}</td>
                        <td>{{\Carbon\Carbon::createFromTimestampMs($item->createdAt)->format('H:i:s')}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="6"><b>Total:</b> <b>{{$data['amount']}}</b> items for <b>{{$data['wax']}} WAX</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop