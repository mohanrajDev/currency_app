@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h3> Welcome {{ auth()->user()->name }}</h3>
    </div>
    <hr/>
    <div class="row justify-content-center">
        <h4> My Favourites</h4>
    </div>
        <div class="row justify-content-center">
        @foreach($favourite_lists as $favourite)
            <div class="col-md-2 text-center">
                <div class="card mb-4">
                    <div class="card-body">
                    <h5 class="card-title">{{ $favourite['base'] }} - {{   $favourite['exchange'] }}</h5>
                    <h5 class="card-title">{{ $favourite['base_rate'] }} - {{   $favourite['exchange_rate'] }}</h5>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <hr/>
    <div class="row justify-content-center">
         <h4>Currency Rate ( {{ $exchange_date }} )</h4>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="spinner-border text-primary" role="status" id="spinner">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-md-2">
            <input type="text" class="form-control" value='1'
            name="base_value" id="base_value"> 
        </div>
        <div class="col-md-2">
            <select class="custom-select" name="base" id="base">
                @foreach ($currency_rates as $key => $currency_rate)                    
                <option value="{{ $key }}">{{ $key }}</option>
                @endforeach
              </select>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-2">
            <input type="text" class="form-control" name="exchange_value" id="exchange_value" readonly>
        </div>
        <div class="col-md-2">
            <select class="custom-select" name="exchange" id="exchange">
                @foreach ($currency_rates as $key => $currency_rate)                    
                <option value="{{ $key }}" @if($key == 'INR') selected @endif>{{ $key }}</option>
                @endforeach
              </select>
        </div>        
    </div>
</div>
@endsection

@push('scripts')
    <script>       
       $( document ).ready(function() {
           var base_el = $('#base');
           var base_value_el = $('#base_value');
           var exchange_el = $('#exchange');
           var exchange_value_el = $('#exchange_value');
           var spinner = $('#spinner');
           spinner.hide();

           var getExchangeRate = function (reverse = false) {
                var data;
                if (reverse) {
                    data = {
                        base: exchange_el.val(), 
                        base_value:  exchange_value_el.val(),
                        to: base_el.val() 
                    }
                } else {
                    data = {
                        base: base_el.val(), 
                        base_value: base_value_el.val(),
                        to: exchange_el.val() 
                    }
                }
                spinner.show();

                $.ajax({
                    method: "GET",
                    url: "/exchangerate",
                    data: data
                })
                .done(function( data ) {
                    spinner.hide();

                    if (reverse) {
                        base_value_el.val(data.exchange_rate);
                    } else {
                        exchange_value_el.val(data.exchange_rate);
                    }
                });
           }

           getExchangeRate();

          base_value_el.on('input', function() {
            if (base_value_el.val()) {                
             getExchangeRate();
            }
          });

          base_el.on('change', function() {
            getExchangeRate();
          });

          exchange_el.on('change', function() {
            getExchangeRate();
          });

        //   exchange_value_el.on('input', function() {
        //     if (exchange_value_el.val()) {                
        //      getExchangeRate(true);
        //     }
        //   });
          
        });
    </script>
@endpush