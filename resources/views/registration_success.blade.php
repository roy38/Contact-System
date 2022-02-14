@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">{{ __('Message') }}</div>
	                <div class="card-body register-success">
		            	<p>Thank you for registering</p>
		            	<button class="btn btn-primary"><a href="/home">Continue</a></button>
	                </div>
            	</div>

            </div>
        </div>
    </div>
</div>
@endsection