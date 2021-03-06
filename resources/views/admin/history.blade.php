@extends('layouts.app')

@section('title') Today Sales @stop

@section('left-menu')
    @include('shared.left-menu.index')
@stop

@if (isset($history))
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
                        <th>Sold At</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($history['details'] as $item)
                        <tr>
                            <td width="40">{{ $loop->iteration }}</td>
                            <td width="50">
                                <img src="/img/{{$item->collectionName}}/{{$item->staff}}.png" width="30" alt="{{$item->staff}}" title="{{$item->staff}}" />
                            </td>
                            <td>{{$item->staff}}</td>
                            <td><a href="?account={{$item->account}}">{{$item->account}}</a></td>
                            <td>{{$item->price}}</td>
                            <td>{{\Carbon\Carbon::createFromTimestampMs($item->updatedAt)->format('H:i:s')}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="6"><b>Total:</b> <b>{{$history['amount']}}</b> items for <b>{{$history['wax']}} WAX</b></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <!-- /.box-body -->
        </div>
    @stop
@endif