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
                    <th>Img</th>
                    <th>Name</th>
                    <th>Account</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop