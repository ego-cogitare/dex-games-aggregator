@extends('layouts.app')

@section('title') Atomichub @stop

@section('left-menu')
    @include('shared.left-menu.index')
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            AtomicHub account will be opened in another browser.
        </div>
    </div>
@stop