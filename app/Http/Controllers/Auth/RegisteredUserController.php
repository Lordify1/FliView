<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Auth\EmailVerificationNotificationController;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'user_type'=>['required'],
            'dob'=>['required','string'],
            'username'=>['required','min:3', 'max:10', 'unique:'.User::class],
        ]);


        $token = bin2hex(random_bytes(16));

        // $token_hash = hash("sha256", $token);

        // $expiry_date = date("Y-m-d H:i:s", time() + 60 * 30);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'dob'=> $request->dob,
            'username'=>$request->username,
            'verification_token' => $token,
        ]);

        event(new Registered($user));


        // try {
            Mail::to($request->email)->send(new EmailVerification($user));
        return response()->json(["success" => true]);
        // } catch (\Exception $e) {
        //     // Email sending failed, delete the user
        //     $user->delete();
        //     return response()->json(['error' => 'Failed to send verification email. User deleted.']);
        // }

        

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME)->with("status","account_created");
    }

    public function new_token()
    {
        return view("auth/verify-email");
    }


    public function the_new_token(Request $request)
    {

        $request->validate([
            "email" => "required|string|email"
        ]);

        $usercheck = DB::select('select * from users where email = ?', [$request->email]);

        if($usercheck  == null)
        {
            return view("auth/verify-email")->with("status","email_not_found");
        }

        foreach($usercheck as $check)

        if($check->email_verified == true)
        {
            return view("auth/verify-email")->with("status","email_not_found");
        }
        

        $token = bin2hex(random_bytes(16));

        // $expiry_date = date("Y-m-d H:i:s", time() + 60 * 30);

        $userupdate = User::where("email",$request->email)->update([
            "verification_token" => $token,
        ]);

        $user = User::where("email",$request->email);
        

        // Mail::to($request->email)->queue(new EmailVerification($user));

        return response()->json(["success" => true]);




    }

    public function email_verify($token)
    {

        $check = DB::select('select * from users where verification_token = ?', [$token]);

        if($check == null)
        {
            return $this->new_token();
        }else
        {

        $update = DB::update('update users set email_verified = "true", verification_token = null where verification_token = ?', [$token]);

        }



        return redirect('/login')->with("status","email_verified");

    }
}
