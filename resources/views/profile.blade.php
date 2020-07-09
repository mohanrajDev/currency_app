@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">
            <div class="card-header">{{ __('Update Profile') }}</div>
            <div class="card-body">
               <form method="POST" action="{{ route('update_profile') }}"
                  enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="form-group col-md-6">
                        <label for="name" class="col-md-12 col-form-label">{{ __('Name') }}</label>
                        <div class="col-md-12">
                           <input id="name" type="text" 
                           class="form-control @error('name') is-invalid @enderror" name="name" 
                           value="{{ old('name') ?? $user->name  }}"                           
                           required autocomplete="name" autofocus>
                           @error('name')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                     <div class="form-group  col-md-6">
                        <label for="email" class="col-md-12 col-form-label">{{ __('E-Mail Address') }}</label>
                        <div class="col-md-12">
                           <input id="email" type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           readonly
                           value="{{ old('email')  ?? $user->email }}" 
                           required autocomplete="email">
                           @error('email')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="form-group col-md-6">
                        <label for="phone" class="col-md-12 col-form-label">Phone Number</label>
                        <div class="col-md-12">
                           <input id="phone" type="phone" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           name="phone" value="{{ old('phone') ?? $user->phone }}" 
                           required autocomplete="phone">
                           @error('phone')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="age" class="col-md-12 col-form-label">Age</label>
                        <div class="col-md-12">
                           <input id="age" type="age" 
                           class="form-control @error('age') is-invalid @enderror" 
                           name="age" value="{{ old('age') ?? $user->age }}" 
                           required autocomplete="age">
                           @error('age')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="form-group col-md-6">
                        <label for="age_proof" class="col-md-12 col-form-label">
                           Age Proof
                           <a href="/view-proof" target="_blank"> Click to Open {{ $proof->type }}</a>
                        </label>
                        <div class="col-md-12">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" 
                                 id="age_proof"
                                 name="proof">
                                <label class="custom-file-label" 
                                for="age_proof">Update file...</label>
                                <div class="text-danger">
                                    @error('proof')
                                    <strong>{{ $message }}</strong>
                                    @enderror
                                </div>
                              </div>
                        </div>
                     </div>
                     <div class="form-group col-md-6">
                        <label for="proof" class="col-md-12 col-form-label">Age Proof Type</label>
                         <div class="col-md-12">
                            <select class="custom-select" name="type" required>
                                <option selected>Select Proof Type</option>
                                <option 
                                    value="passport" 
                                    @if ($proof->type == 'Passport') selected @endif>
                                    Passport
                                 </option>
                                <option 
                                 value="voter_id"
                                 @if ($proof->type == 'Voter_Id') selected @endif>
                                 Voter ID
                               </option>
                              </select>
                              <div class="text-danger">
                                @error('type')
                                <strong>{{ $message }}</strong>
                                @enderror
                              </div>
                         </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="form-group col-md-6">
                        <label for="profile_image1" class="col-md-12 col-form-label">
                           Profile Image
                        </label>
                        <div class="col-md-12">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" 
                                 id="profile_image"
                                 name="profile_image">
                                <label class="custom-file-label" 
                                for="profile_image">Select file...</label>
                                <div class="text-danger">
                                    @error('profile_image')
                                    <strong>{{ $message }}</strong>
                                    @enderror
                                </div>
                              </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group row mb-0">
                     <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                        Update
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

@push('scripts')
   <script>
      $(document).ready(function(){
         $(".custom-file-input").on("change", function() {
         var fileName = $(this).val().split("\\").pop();
         $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
         });
      });
   </script>
@endpush