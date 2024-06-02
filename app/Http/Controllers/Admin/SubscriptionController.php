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

    /*
     * Show the Subscription on the site.
     */
    public function show($id)
    {
        $subscription = Subscription::with('events')->find($id);

        return view('site.events.subscription', compact('subscription'));
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

            /** @var Subscription $subscription */
            $subscription = Subscription::query()->create($toCreate);
            MediaHelper::handleMedia($subscription, 'logo', $request->logo);

            $result = $this->handleSelectedEvents($request, $subscription);
            if (! $result) {
                $subscription->delete();
                return redirect()->route('subscriptions.create')->with('error', 'Invalid Sales volume!');
            }

        } catch (\Throwable $e) {
            return redirect()->route('subscriptions.create')->with('error', 'Invalid Sales volume!');
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

            $result = $this->handleSelectedEvents($request, $subscription);
            if (! $result) {
                return redirect()->route('subscriptions.edit', $request->id)->with('error', 'Invalid Sales volume!');
            }

            $subscription->update($toUpdate);

        } catch (\Throwable $e) {
            return redirect()->route('subscriptions.edit', $request->id)->with('error', 'Invalid Sales volume!');
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

    private function handleSelectedEvents(StoreSubscriptionRequest|UpdateSubscriptionRequest $request, Subscription $subscription): bool
    {
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

        $sum = collect($events)->sum('sum');
        if ($sum !== (float) $request->price) {
            return false;
        }

        $subscription->events()->sync([]);

        foreach ($events as $event) {
            $subscription->events()->attach($event['event_id'], [
                'type' => $event['type'],
                'discount' => $event['discount'],
                'sum' => $event['sum'],
            ]);
        }

        return true;
    }

}
