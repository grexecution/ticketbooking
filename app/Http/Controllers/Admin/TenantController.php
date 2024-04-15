<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\IndexTenantRequest;
use App\Http\Requests\Tenants\StoreTenantRequest;
use App\Http\Requests\Tenants\UpdateTenantBySuperAdminRequest;
use App\Http\Services\UserService;
use App\Models\Tenant;
use App\Models\User\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class TenantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexTenantRequest $request) : View
    {
        $tenants = Tenant::query()->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })->get();
        return view('admin.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        abort_if(Gate::denies('tenant_access'), Response::HTTP_FORBIDDEN);
        return view('admin.tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenantRequest $request) : RedirectResponse
    {
        $toCreate = collect($request->validated())->except(['logo', 'logo_origin_names', 'logo_sizes'])->toArray();
        $tenant = Tenant::query()->create($toCreate);
        MediaHelper::handleMedia($tenant, 'logo', $request->logo);

        return redirect()->route('tenants.index')->with('success', 'Operation successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : View
    {
        abort_if(Gate::denies('tenant_access'), Response::HTTP_FORBIDDEN);
        $tenant = Tenant::query()->findOrFail($id);
        return view('admin.tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenantBySuperAdminRequest $request, Tenant $tenant) : RedirectResponse
    {
        $toUpdate = collect($request->validated())->except(['logo', 'logo_origin_names', 'logo_sizes'])->toArray();
        if ($request->logo !== $tenant->logo?->name) {
            MediaHelper::handleMedia($tenant, 'logo', $request->logo);
        }
        $tenant->update($toUpdate);

        return redirect()->route('tenants.index')->with('success', 'Operation successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : RedirectResponse
    {
        Tenant::query()->findOrFail($id)->delete();
        return redirect()->route('tenants.index')->with('success', 'Operation successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function adminLogin(Request $request) : RedirectResponse
    {
        /** @var User $adminUser */
        if ($adminUser = User::where('tenant_id', $request->tenant_id)->first()) {
            $request->session()->put('loggedAsSuperAdmin', true);
            $request->session()->put('skip2fa', true);
            Auth::logout();
            Auth::login($adminUser);
            return redirect()->route('events.index')->with('success', 'Operation successful!');

        } else {
            return back()->with('error', 'Admin login failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function superAdminLogin(Request $request, UserService $service) : RedirectResponse
    {
        $request->session()->forget('loggedAsSuperAdmin');
        $request->session()->put('skip2fa', true);
        Auth::logout();
        Auth::login($service->getSuperAdmin());
        return redirect()->route('dashboard')->with('success', 'Operation successful!');
    }
}
