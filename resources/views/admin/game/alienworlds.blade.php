@extends('layouts.app')

@section('title') Earnings @stop

@section('left-menu')
    @include('shared.left-menu.index')
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            <table id="data-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Account</th>
                    <th>Total</th>
                    <th>Avg</th>
                    <th>Mines</th>
                    <th>Last Mine</th>
                    <th>Time Left</th>
                    <th>%, CPU</th>
                    <th>Stake CPU, WAX</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($earnings as $item)
                    <tr @if ($item['cpu_usage'] > 90)style="background: #fbf1f0" class="text-danger"@endif>
                        <td width="40">{{$loop->iteration}}</td>
                        <td>
                            <a href="https://wax.bloks.io/account/{{$item['account']}}" target="_blank">{{$item['account']}}</a>
                        </td>
                        <td>{{$item['total']}}</td>
                        <td>{{$item['avg']}}</td>
                        <td>{{$item['count']}}</td>
                        <td>{{$item['last_mine']}}</td>
                        <td>{{$item['time_left']}}</td>
                        <td>{{$item['cpu_usage']}}</td>
                        <td>{{sprintf('%.2f', $item['cpu_staked'])}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td><b>Total</b></td>
                        <td>&nbsp;</td>
                        <td><b>{{$total}}</b></td>
                        <td><b>{{sprintf('%.6f', $avg)}}</b></td>
                        <td><b>{{$count}}</b></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><b>{{$staked}}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop