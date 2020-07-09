<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\ProofDocument;
use Illuminate\Support\Str;
use App\Traits\RegistersUsers;
use App\Notifications\SendPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'integer', 'unique:users', 'digits:10'],
            'age' => ['required', 'integer', 'between:18,100'],
            'proof' => ['required', 'mimes:jpeg,jpg,png,JPG,PNG', 'max:5120'],
            'type' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $password = Str::random(8);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'age' => $data['age'],
            'password' => Hash::make($password),
        ]);

        if($data['proof']){            
            $proof = $data['proof'];
            $slug = Str::slug($user->name . ' proof', '-');
            $image_name = $user->id.'-'.$slug.'.'.$proof->getClientOriginalExtension();
            $url = Storage::disk('public')->putFileAs('proof_docs', $proof, $image_name);

            $proof = new ProofDocument;
            $proof->user_id = $user->id;
            $proof->doc_url = $url;
            $proof->type = $data['type'];
            $proof->save();
        }

        $user->notify(new SendPassword($password));
        session()->forget('current_user');
        session()->put('current_user', $data['email']);
        return $user;
    }
}
