@extends('layouts.base')
@section('main')


<h1>testaaaas</h1>
<script>
    @if(Session::has('message'))
    <div class="alert alert-info">


        <div class="row">
        <div class="col-sm-4">
            <div class="alert alert-danger" role="alert">
                {{ Session::get('message') }}

            </div>
        </div>
    </div>
    </div>


    @endif
    </script>


@endsection
