@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    @if (session()->has('current_user'))
     <div class="col-md-8">
        <div class="alert alert-primary" role="alert">
            <h4>Welcome</h4>
            <p></strong> Account credentials sent to your registered email address ( {{ session()->get('current_user') }} ).
                <a href="/login" class="alert-link"> Click Login</a>
            </p>  
          </div>
     </div>
     @endif 
    </div>
</div>
@endsection
