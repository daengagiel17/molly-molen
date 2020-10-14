<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try
        {
            $socialUser = Socialite::driver($provider)->user();
        } 
        catch (\Exception $e) 
        {
            return redirect()->route('login')->with('error', 'Sorry something wrong in server');
        }

        $user = User::where(['email' => $socialUser->getEmail()])->first();

        if(!$user)
        {
            return redirect()->route('login')->with('error', 'You are not registered');
        }
        
        auth()->login($user);

        return redirect()->route('dashboard');
    }

    public function loginOtp(Request $request)
    {
        $url = 'https://www.accountkit.com/v1.0/basic/dialog/sms_login/';
        $data = array(
            'app_id' => '2577374435619935',
            'redirect' => 'http://localhost:8000/callback-otp',
            'state' => $request->_token,
            'fbAppEventsEnabled' => 'true',
        );
        $data = http_build_query($data);

        return redirect()->to($url."?".$data);
    }

    public function callbackOtp(Request $request)
    {	
        if($request->status == "NOT_AUTHENTICATED" || $request == null){
            // Mengembalikan ke halaman login
            return redirect()->route($state);
        }elseif($request->status == "PARTIALLY_AUTHENTICATED"){            
            // URL to get access token by code and app_id fb
            $url = "https://graph.accountkit.com/v1.0/access_token?grant_type=authorization_code&code=".$request['code']."&access_token=AA|2577374435619935|4a1d14d47b18151afef0e44ded6305d7";
            // Get data access token by url
            $get = json_decode(file_get_contents($url),true);
            // URL to get data phone by access token
            $verify_url = "https://graph.accountkit.com/v1.0/me/?access_token=".$get['access_token'];            
            // get data by verivy url
            $data = json_decode(file_get_contents($verify_url),true);

            // Cek data['phone']['number'] jika terdaftar ke pesan/home jika tidak maka isi data diri
            $user = User::where('nomor_hp', $data['phone']['number'])->first();

            if(is_null($user)){
                return redirect()->route('login')->with('error', 'You are not registered');
            }                            
        }
        auth()->login($user);

        return redirect()->route('dashboard');

    }
 
}
