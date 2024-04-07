<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\IndexTenantRequest;
use App\Http\Requests\Tenants\StoreTenantRequest;
use App\Http\Requests\Tenants\UpdateTenantRequest;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class TenantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        Tenant::query()->create($request->validated());
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
    public function update(UpdateTenantRequest $request, string $id) : RedirectResponse
    {
        Tenant::query()->findOrFail($id)->update($request->validated());
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
}
