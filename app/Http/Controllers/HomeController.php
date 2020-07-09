<?php

namespace App\Http\Controllers;

use App\User;
use App\Favourite;
use App\CurrencyCode;
use App\ProofDocument;
use App\Currency\Currency;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('welcome');
    }

    public function welcome()
    {
       return view('welcome');
    }

    /**
     * List favourites list
     *
     * @return $favourites item list
     */
    public function index()
    {
        $currency_codes = CurrencyCode::get()->toArray();
        $lists = [];

        for ($list=0;$list < 10;$list++) {
          $items = Arr::random($currency_codes, 2);
        
          foreach ($items as $index => $item) {
              $lists[$list]['code_' . ($index + 1)] = $item['code'];
              $lists[$list]['id_' . ($index + 1)] = $item['id'];
          }
        }       
        
        return view('home', [
            'currency_codes' => (object) $lists,
        ]);
    }

    /**
     * Update favourites 
     * 
     */
    public function setFavourite(Request $request)
    {
        $request->validate([
            'favourite' => ['required','array','min:5']
        ]);

        foreach ($request->favourite as $fav_item) {
            [$code1, $code2] = explode(':', $fav_item);
            $exits = Favourite::where('user_id', $request->user()->id)
            ->where('currency_code_id_1', $code1 )
            ->where('currency_code_id_2', $code2)
            ->first();

            if (!$exits) {
               $fav = new Favourite;
               $fav->user_id = $request->user()->id;
               $fav->currency_code_id_1 = $code1;
               $fav->currency_code_id_2 = $code2;
               $fav->save();
            }
        }

        return redirect()->route('dashboard');
        
    }

    /**
     * Dashboard Page
     *  
     */
    public function dashboard(Request $request)
    {
        $currency = new Currency();
        $favourites = $request->user()->favourites;
        $favourite_lists = [];
        foreach ($favourites as $key => $favourite) {
            $favourite_lists[$key] = [
                'base' => $favourite->base->code,
                'base_rate' => 1,
                'exchange' => $favourite->to->code,
                'exchange_rate' => $currency->getExchangeRate($favourite->to->code, $favourite->base->code),
            ];
        }

        $currency = new Currency();
        $currency_rates = $currency->getCurrencyList();
        $exchange_date = $currency->getDate();

        return view('dashboard', [
           'favourite_lists' => $favourite_lists,
           'currency_rates' =>  $currency_rates,
           'exchange_date' => $exchange_date
        ]);
    }

    /**
     * Profile Page
     */
    public function profile(Request $request)
    {
        $user = auth()->user();  
        $proof = ProofDocument::latest()->first();     
        return view('profile', [
            'user' => $user,
            'proof' => $proof
        ]);
    }

    /**
     * Update Profile 
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'integer', 'digits:10'],
            'age' => ['required', 'integer', 'between:18,100'],
            'proof' => ['mimes:jpeg,jpg,png,JPG,PNG', 'max:5120'],
            'profile_image' => ['mimes:jpeg,jpg,png,JPG,PNG', 'max:5120'],
            'type' => ['required', 'string'],
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->age = $request->age;
        $user->phone = $request->phone;

        if ($request->hasFile('profile_image')) {
            $profile_image = $request->profile_image;
            $slug = Str::slug($user->name);
            $image_name = $user->id.'-'.$slug.'.'.$profile_image->getClientOriginalExtension();
            $url = Storage::disk('public')->putFileAs("profile_image", $profile_image, $image_name );
            $user->profile_image = $url;            
        }

        if ($request->hasFile('proof')) {
            $proof = $request->proof;
            $slug = Str::slug($user->name . ' proof', '-');
            $image_name = $user->id.'-'.$slug.'.'.$proof->getClientOriginalExtension();
            $url = Storage::disk('public')->putFileAs('proof_docs', $proof, $image_name);

            if($user->proof) {
                $user->proof->type = $request->type;
                $user->proof->doc_url = $url;
                $user->proof->save();
            }
        }

        $user->save();        
       return redirect()->route('profile');
    }

    public function getExchangerate(request $request)
    {
       $request->validate([
           'base' => ['required'],
           'base_value' => ['required'],
           'to' => ['required'],
       ]);

       $base = $request->base;
       $base_value = $request->base_value;
       $to = $request->to;
       $exchange_rate = 0;
       $exchange_date = '';

       $currency = new Currency();
       $exchange_rate =  $currency->getExchangeRate($to, $base);

       return  [
           'exchange_rate' => $base_value * $exchange_rate,           
       ];
    }

    public function showProof(Request $request)
    {
        $user = auth()->user();
        $proof = $user->proof;
        return response()->file( 'storage/' . $proof->doc_url);
    }
}
