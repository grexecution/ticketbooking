<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriptions\IndexSubscriptionRequest;
use App\Http\Requests\Subscriptions\StoreSubscriptionRequest;
use App\Http\Requests\Subscriptions\UpdateSubscriptionRequest;
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
        try {
            $toCreate = collect($request->validated())->except([
                'logo', 'logo_origin_names', 'logo_sizes',
                'event_ids', 'type' , 'discount', 'sum',
            ])->toArray();

            $subscription = Subscription::query()->create($toCreate);
            $this->handleSelectedEvents($request, $subscription);
            MediaHelper::handleMedia($subscription, 'logo', $request->logo);

        } catch (\Throwable $e) {
            return redirect()->route('subscriptions.create')->with('error', 'Operation failed!');
        }

        return redirect()->route('subscriptions.index')->with('success', 'Operation successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription) : View
    {
        abort_if(Gate::denies('subscription_access'), Response::HTTP_FORBIDDEN);
        $subscription->load(['events']);
        $selectedEvents = $subscription->events->map(function (Event $event) {
           return [
               'id' => $event->id,
               'name' => $event->name,
               // ToDo need to replace after implementation event categories
               'categories' => [
                   ['id' => 1, 'name' => 'Category A',],
                   ['id' => 2, 'name' => 'Category VIP',],
               ],
               'type' => $event->pivot->type,
               'discount' => $event->pivot->discount,
               'sum' => $event->pivot->sum,
           ];
        });

        return view('admin.subscriptions.edit', compact('subscription', 'selectedEvents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription) : RedirectResponse
    {
        try {
            $toUpdate = collect($request->validated())->except([
                'logo', 'logo_origin_names', 'logo_sizes',
                'event_ids', 'type' ,'discount', 'sum',
            ])->toArray();

            if ($request->logo !== $subscription->logo?->name) {
                MediaHelper::handleMedia($subscription, 'logo', $request->logo);
            }

            $subscription->update($toUpdate);
            $this->handleSelectedEvents($request, $subscription);

        } catch (\Throwable $e) {
            return redirect()->route('subscriptions.edit')->with('error', 'Operation failed!');
        }

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

    private function handleSelectedEvents(StoreSubscriptionRequest|UpdateSubscriptionRequest $request, Subscription $subscription): void
    {
        $subscription->events()->sync([]);

        $events = [];
        $eventIds = array_keys($request->type);

        foreach ($eventIds as $eventId) {
            $events[] = [
                'event_id' => $eventId,
                'type' => $request->type[$eventId],
                'discount' => $request->discount[$eventId],
                'sum' => $request->sum[$eventId]
            ];
        }

        foreach ($events as $event) {
            $subscription->events()->attach($event['event_id'], [
                'type' => $event['type'],
                'discount' => $event['discount'],
                'sum' => $event['sum'],
            ]);
        }
    }

}
