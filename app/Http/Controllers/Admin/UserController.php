<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\IndexUserRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Tenant;
use App\Models\User\Role;
use App\Models\User\User;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexUserRequest $request) : View
    {
        $users = User::with(['tenant'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            })
            ->where('email', '<>', 'super@admin.com')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN);
        $tenants = Tenant::all();
        return view('admin.users.create', compact('tenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request) : RedirectResponse
    {
        $toCreate = $request->validated();
        $toCreate['name'] = $toCreate['first_name'] . ' ' . $toCreate['last_name'];
        $toCreate['password'] = Hash::make($toCreate['password']);
        $toCreate['google2fa_secret'] = \Google2FA::generateSecretKey();

        $user = User::query()->create($toCreate);
        $role = Role::query()->where('label', RoleService::ROLE_LABEL_ADMIN)->firstOrFail();
        $user->roles()->sync($role->id);

        return redirect()->route('users.index')->with('success', 'Operation successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) : View
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN);
        $tenants = Tenant::all();
        return view('admin.users.edit', compact('user', 'tenants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user) : RedirectResponse
    {
        $toUpdate = $request->validated();
        $toUpdate['name'] = $toUpdate['first_name'] . ' ' . $toUpdate['last_name'];

        if ($request->password != '******') {
            $toUpdate['password'] = Hash::make($toUpdate['password']);
        } else {
            unset($toUpdate['password']);
        }

        $user->update($toUpdate);

        return redirect()->route('users.index')->with('success', 'Operation successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $userID) : RedirectResponse
    {
        User::query()->findOrFail($userID)->delete();
        return redirect()->route('users.index')->with('success', 'Operation successful!');
    }
}
