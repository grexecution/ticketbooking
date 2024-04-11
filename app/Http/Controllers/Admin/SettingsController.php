<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
    }

    public function index() : Renderable
    {
        $user = Auth::user();
        return view('admin.settings.account', compact('user'));
    }

    public function updateAccount(UpdateAccountRequest $request) : RedirectResponse
    {
        $request->user()->update($request->validated());
        return redirect()->route('settings')->with('success', 'Operation successful!');
    }

    public function updatePassword(UpdatePasswordRequest $request) : RedirectResponse
    {
        $user = auth()->user();
        $user->password = $request->newPassword;
        $user->save();
        return redirect()->route('settings')->with('success', 'Operation successful!');
    }

}
