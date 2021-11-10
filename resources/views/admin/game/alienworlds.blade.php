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
                    <th>Land</th>
                    <th>Total</th>
                    <th>Avg</th>
                    <th>Mines</th>
                    <th>Last Mine</th>
                    <th>Time Left</th>
                    <th>%, CPU</th>
                    <th>Stake CPU, WAX</th>
                    <th>WAX balance</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($earnings as $item)
                    <tr @if ($item['cpu_usage'] > 90)style="background: #fbf1f0"@endif>
                        <td width="40">{{$loop->iteration}}</td>
                        <td>
                            <a href="https://wax.bloks.io/account/{{$item['account']}}" target="_blank">{{$item['account']}}</a>
                        </td>
                        <td>
                            <a href="/admin/game/alienworlds/planet/{{$item['account']}}">< land ></a>
                        </td>
                        <td>{{$item['total']}}</td>
                        <td>{{$item['avg']}}</td>
                        <td>{{$item['count']}}</td>
                        <td>{{$item['last_mine']}}</td>
                        <td>{{$item['time_left']}}</td>
                        <td>{{$item['cpu_usage']}}</td>
                        <td>{{sprintf('%.2f', $item['cpu_staked'])}}</td>
                        <td>{{sprintf('%.2f', $item['wax_balance'])}} @if ($item['refund_cpu']) <span style="color: #a2a2a2;">+{{sprintf('%.2f', $item['refund_cpu'])}} at {{$item['refund_ts']}}</span>@endif</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td><b>Total</b></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><b>{{$total}}</b></td>
                        <td><b>{{sprintf('%.5f', $avg)}}</b></td>
                        <td><b>{{$count}}</b></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><b>{{sprintf('%.2f', $staked)}}</b></td>
                        <td><b>{{sprintf('%.2f', $waxBalance)}} @if ($cpuRefund > 0) <span style="color: #a2a2a2;">+{{sprintf('%.2f', $cpuRefund)}}</span>@endif</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop