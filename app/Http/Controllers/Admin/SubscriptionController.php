<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriptions\IndexSubscriptionRequest;
use App\Http\Requests\Subscriptions\StoreSubscriptionRequest;
use App\Http\Requests\Tenants\UpdateTenantBySuperAdminRequest;
use App\Models\Event;
use App\Models\Subscription;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
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
     * @param IndexSubscriptionRequest $request
     * @return Renderable
     */
    public function index(IndexSubscriptionRequest $request) : Renderable
    {
        $subscriptions = Subscription::query()->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })->get();

        return view('admin.subscriptions.index', [
            'subscriptions' => $subscriptions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        abort_if(Gate::denies('subscription_access'), Response::HTTP_FORBIDDEN);
        return view('admin.subscriptions.create', [
            'events' => Event::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request) : RedirectResponse
    {
        $toCreate = collect($request->validated())->except(['logo', 'logo_origin_names', 'logo_sizes'])->toArray();
        $subscription = Subscription::query()->create($toCreate);
        MediaHelper::handleMedia($subscription, 'logo', $request->logo);

        return redirect()->route('subscriptions.index')->with('success', 'Operation successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription) : View
    {
        abort_if(Gate::denies('subscription_access'), Response::HTTP_FORBIDDEN);
        $subscription->load(['events']);
        return view('admin.subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenantBySuperAdminRequest $request, Subscription $subscription) : RedirectResponse
    {
        $toUpdate = collect($request->validated())->except(['logo', 'logo_origin_names', 'logo_sizes'])->toArray();
        if ($request->logo !== $subscription->logo?->name) {
            MediaHelper::handleMedia($subscription, 'logo', $request->logo);
        }
        $subscription->update($toUpdate);

        return redirect()->route('subscriptions.index')->with('success', 'Operation successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : RedirectResponse
    {
        Subscription::query()->findOrFail($id)->delete();
        return redirect()->route('subscriptions.index')->with('success', 'Operation successful!');
    }

}
