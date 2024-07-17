<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\State;
use App\Models\Lga;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {

        $user = Auth::user();
        $states = State::all();
        return view('profile/edit_profile', [ 'user'=>$user , "states"=>$states]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // public function lgabystate(Request $request)
    // {
    //     $stateId = $request->input('stateId');

    //     $lgas = DB::select('select * from lga where state_id = ?', [$stateId]);
        

    //     if($lgas == true)
    //     {
    //     $lga = json_encode($lgas);
    //     return response()->json($data, 200, $headers);
    //     return response()->json([$lgas,"success"=> true]);
    //     // return response()->json(['success' => true]);
    //     }else
    //     {
    //     return response()->json(['success' => false]);
    //     }
    // }

    public function newm()
    {
        return view("test_email");
    }

    public function testemail()
    {
        return $this->newm();
    }

    public function logmail(Request $request)
    {

        $email = $request->input('email');

        Mail::raw('plain text message', function ($message) use ($request) {
            $message->to($request->email,'John Doe');
            $message->subject(
                'www.google.com'
            );
        });


        return redirect('test_email');

    }
}