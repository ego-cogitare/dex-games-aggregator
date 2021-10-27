@extends('layouts.app')

@section('title') Account Land @stop

@section('left-menu')
    @include('shared.left-menu.index')
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <tr>
                    <td width="100"><b>Account</b></td>
                    <td>{{$account}}</td>
                </tr>
                <tr>
                    <td width="100"><b>Planet</b></td>
                    <td>{{$landInfo['planet']}}</td>
                </tr>
                <tr>
                    <td width="100"><b>Land</b></td>
                    <td>{{$landInfo['name']}}, <b>{{$landInfo['x']}}:{{$landInfo['y']}}</b></td>
                </tr>
                <tr>
                    <td><b>Land ID</b></td>
                    <td>{{$landId}}</td>
                </tr>
                <tr>
                    <td width="100"><b>Comission</b></td>
                    <td>{{sprintf('%.2f', $landInfo['commission'] / 100)}}%</td>
                </tr>
                <tr>
                    <td><b>Ease</b></td>
                    <td>{{sprintf('%.1f', $landInfo['ease'] / 10)}}</td>
                </tr>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop