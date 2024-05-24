<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateAccountRequest;
use App\Http\Requests\Settings\UpdateFinanceRequest;
use App\Http\Requests\Settings\UpdatePasswordRequest;
use App\Http\Requests\Tenants\UpdateTenantByAdminRequest;
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
        $toUpdate = collect($request->validated())->except(['avatar', 'avatar_origin_names', 'avatar_sizes'])->toArray();
        if ($request->avatar !== $request->user()->avatar?->name) {
            MediaHelper::handleMedia($request->user(), 'avatar', $request->avatar);
        }
        $request->user()->update($toUpdate);

        return redirect()->route('settings')->with('success', 'Operation successful!');
    }

    public function updateTenant(UpdateTenantByAdminRequest $request) : RedirectResponse
    {
        $toUpdate = collect($request->validated())->except(['logo', 'logo_origin_names', 'logo_sizes'])->toArray();
        unset($toUpdate['id']);
        if ($request->logo !== $request->user()->tenant->logo?->name) {
            MediaHelper::handleMedia($request->user()->tenant, 'logo', $request->logo);
        }
        $request->user()->tenant()->update($toUpdate);

        return redirect()->route('settings')->with('success', 'Operation successful!');
    }

    public function updateFinance(UpdateFinanceRequest $request) : RedirectResponse
    {
        $request->user()->tenant()->update($request->validated());
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
