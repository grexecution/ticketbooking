<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\StoreTenantRequest;
use App\Http\Requests\Tenants\UpdateTenantRequest;
use App\Models\Tenant;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
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
    public function index(Request $request)
    {
        return view('admin.events.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
//        abort_if(Gate::denies('tenant_access'), Response::HTTP_FORBIDDEN);
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenantRequest $request) : RedirectResponse
    {
//        Tenant::query()->create($request->validated());
//        return redirect()->route('tenants.index')->with('success', 'Operation successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : View
    {
//        abort_if(Gate::denies('tenant_access'), Response::HTTP_FORBIDDEN);
//        $tenant = Tenant::query()->findOrFail($id);
//        return view('admin.tenants.edit', compact('tenant'));
        return view('admin.events.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenantRequest $request, string $id) : RedirectResponse
    {
//        Tenant::query()->findOrFail($id)->update($request->validated());
//        return redirect()->route('tenants.index')->with('success', 'Operation successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : RedirectResponse
    {
//        Tenant::query()->findOrFail($id)->delete();
//        return redirect()->route('tenants.index')->with('success', 'Operation successful!');
    }

}
