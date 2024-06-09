<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscriptions\IndexSubscriptionRequest;
use App\Http\Requests\Subscriptions\StoreSubscriptionRequest;
use App\Http\Requests\Subscriptions\UpdateSubscriptionRequest;
use App\Models\Event;
use App\Models\SeatPlan\EventSeatPlanCategory;
use App\Models\SeatPlan\SeatPlan;
use App\Models\Subscription;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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
            $event->load(['seatPlanCategories', 'seatPlanCategoriesForSubscriptions']);
            $event = $event->toArray();

            return [
               'id' => $event['id'],
               'name' => $event['name'],
               'seat_plan_categories' => $event['seat_plan_categories'],
               'seat_plan_categories_for_subscriptions' => $event['seat_plan_categories_for_subscriptions'],
               'type' => $event['pivot']['type'],
               'discount' => $event['pivot']['discount'],
               'sum' => $event['pivot']['sum'],
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
        $eventsArr = [];
        $eventIds = array_keys($request->type);

        foreach ($eventIds as $eventId) {
            $eventsArr[] = [
                'event_id' => $eventId,
                'type' => $request->type[$eventId],
                'discount' => $request->discount[$eventId],
                'sum' => $request->sum[$eventId],
                'category_ids' => $request->category_ids[$eventId],
            ];
        }

        $sum = collect($eventsArr)->sum('sum');
        if ($sum !== (float) $request->price) {
            return false;
        }

        $subscription->events()->sync([]);

        foreach ($eventsArr as $eventArr) {
            $subscription->events()->attach($eventArr['event_id'], [
                'type' => $eventArr['type'],
                'discount' => $eventArr['discount'],
                'sum' => $eventArr['sum'],
            ]);

            // Save subscription categories
            $event = Event::query()->find($eventArr['event_id']);
            // Delete sub categories after creating new ones
            // Todo check if any tickets was bought or booked (create is_subscription field in tickets table)
            $toDeleteSubCatIds = $event->seatPlanCategoriesForSubscriptions->pluck('id')->toArray();

            $parentId = null;
            foreach ($eventArr['category_ids'] as $categoryId) {
                /** @var EventSeatPlanCategory $eventRelatedCategory */
                $eventRelatedCategory = EventSeatPlanCategory::query()->find($categoryId);
//                if (! $eventRelatedCategory->subscription_id) {
                    $parentId = $eventRelatedCategory->id;
//                }
                EventSeatPlanCategory::query()->create([
                    'parent_id' => $parentId,
                    'seat_plan_id' => SeatPlan::SEAT_PLAN_CUSTOM_ID,
                    'event_id' => $event->id,
                    'subscription_id' => $subscription->id,
                    'name' => $eventRelatedCategory->name,
                    'price' => $eventArr['sum'],
                    'places' => $eventRelatedCategory->places,
                    'rows' => $eventRelatedCategory->rows,
                    'seats' => $eventRelatedCategory->seats,
                    'aisles_after' => $eventRelatedCategory->aisles_after,
                    'description' => $eventRelatedCategory?->description ?? '',
                ]);
            }

            if ($toDeleteSubCatIds) {
                DB::table('event_seat_plan_categories')
                    ->whereIn('id', $toDeleteSubCatIds)
                    ->delete();
            }
        }

        return true;
    }

}
