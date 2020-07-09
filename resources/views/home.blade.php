@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Please Select 5 Favourites</div>
                <div class="card-body">                    
                    <form method="POST" action="{{ route('favourite') }}">
                        @csrf                     
                        <div class="form-group">
                            @foreach($currency_codes as $index => $currency) 
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" 
                                    class="custom-control-input" 
                                    id="codes_{{ $index }}"
                                    name="favourite[]" 
                                    value="{{ $currency['id_1'] }}:{{ $currency['id_2'] }}"
                                >
                                <label class="custom-control-label" for="codes_{{ $index }}">
                                    {{ $currency['code_1'] }} - {{  $currency['code_2'] }}
                                </label>
                            </div>
                            @endforeach
                            @error('favourite')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   Next
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
