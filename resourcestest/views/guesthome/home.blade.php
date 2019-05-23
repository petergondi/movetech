@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Guest Dashboard</div>

                <div class="panel-body">
                    Guest Page <a href='{{route('vendorlogin')}}'>vendor login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
