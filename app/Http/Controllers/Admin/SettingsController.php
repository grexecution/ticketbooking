<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Auth;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        return view('admin.settings.account', compact('user'));
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        auth()->user()->update($request->validated());

        return redirect()->route('account')->with('success', 'Operation successful!');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = auth()->user();
        $user->password = $request->newPassword;
        $user->save();

        return redirect()->route('account')->with('success', 'Operation successful!');
    }

}
