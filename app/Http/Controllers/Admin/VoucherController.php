<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\StoreTenantRequest;
use App\Http\Requests\Tenants\UpdateTenantBySuperAdminRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class VoucherController extends Controller
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
     * @return Renderable
     */
    public function index(Request $request)
    {
        return view('admin.vouchers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
//        abort_if(Gate::denies('tenant_access'), Response::HTTP_FORBIDDEN);
        return view('admin.vouchers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenantRequest $request) : RedirectResponse
    {
//        Tenant::query()->create($request->validated());
//        return redirect()->route('vouchers.index')->with('success', 'Operation successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : View
    {
//        abort_if(Gate::denies('tenant_access'), Response::HTTP_FORBIDDEN);
//        $tenant = Tenant::query()->findOrFail($id);
//        return view('admin.vouchers.edit', compact('tenant'));
        return view('admin.vouchers.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenantBySuperAdminRequest $request, string $id) : RedirectResponse
    {
//        Tenant::query()->findOrFail($id)->update($request->validated());
//        return redirect()->route('vouchers.index')->with('success', 'Operation successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : RedirectResponse
    {
//        Tenant::query()->findOrFail($id)->delete();
//        return redirect()->route('vouchers.index')->with('success', 'Operation successful!');
    }

}
