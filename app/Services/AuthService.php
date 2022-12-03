<?php

namespace App\Services;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{

    public function registerUser(array $request){

        DB::transaction(function ()use ($request){
            $request['password']=Hash::make($request['password']);
            $user=User::create($request);
            $user->assignRole('User');
            $user->createBraintreeCustomer();
            Auth::loginUsingId($user->id);
        });

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * @throws ValidationException
     */
    public function logUserIn(mixed $validated)
    {
        if (! Auth::attempt(Arr::only($validated,['email', 'password']), $validated['remember'])) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        request()->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function logUserOut()
    {
        Auth::guard('web')->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }


}
