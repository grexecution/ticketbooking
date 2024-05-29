<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MediaHelper;
use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\IndexEventRequest;
use App\Http\Requests\Events\StoreEventRequest;
use App\Http\Requests\Events\UpdateEventRequest;
use App\Models\Artist;
use App\Models\Discount;
use App\Models\Event;
use App\Models\Program;
use App\Models\SeatPlan\SeatPlan;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

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
     * @param IndexEventRequest $request
     * @return Renderable
     */
    public function index(IndexEventRequest $request) : Renderable
    {
        $events = Event::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->get();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN);
        return view('admin.events.create', [
            'venues' => Venue::all(),
            'artists' => Artist::all(),
            'programs' => Program::all(),
            'discounts' => Discount::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request) : RedirectResponse
    {
        $toCreate = collect($request->validated())->except([
            'logo', 'logo_origin_names', 'logo_sizes',
            'partners', 'partners_origin_names', 'partners_sizes',
            'artist_ids', 'program_id',
        ])->toArray();

        $toCreate['user_id'] = auth()->id();
        $toCreate['price'] = PriceHelper::fromStrToFloat($toCreate['price']);

        $event = Event::query()->create($toCreate);
        $event->discounts()->sync($toCreate['discount_ids'] ?? []);
        $this->handleArtists($request, $event);
        $this->handleProgram($request, $event);

        MediaHelper::handleMedia($event, 'logo', $request->logo);
        MediaHelper::handleMediaCollect($event, 'partners', $request->partners);

        return redirect()->route('events.index')->with('success', 'Operation successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event) : View
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN);
        return view('admin.events.edit', [
            'event' => $event,
            'venues' => Venue::all(),
            'artists' => Artist::all(),
            'programs' => Program::all(),
            'discounts' => Discount::all(),
            'isEnded' => $event->status === Event::STATUS_ENDED
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event) : RedirectResponse
    {
        $toUpdate = collect($request->validated())->except([
            'logo', 'logo_origin_names', 'logo_sizes',
            'partners', 'partners_origin_names', 'partners_sizes',
            'artist_ids', 'program_id',
        ])->toArray();

        $toUpdate['start_time'] = Carbon::parse($request->start_time);
        $toUpdate['doors_open_time'] = Carbon::parse($request->doors_open_time);
        $toUpdate['price'] = PriceHelper::fromStrToFloat($toUpdate['price']);

        $event->update($toUpdate);
        if ($request->logo !== $event->logo?->name) {
            MediaHelper::handleMedia($event, 'logo', $request->logo);
        }
        if (collect($request->partners)->implode(',') !== $event->partners->pluck('name')->implode(',')) {
            MediaHelper::handleMediaCollect($event, 'partners', $request->partners);
        }

        $event->discounts()->sync($request->discount_ids);
        $this->handleArtists($request, $event);
        $this->handleProgram($request, $event);

        return redirect()->route('events.index')->with('success', 'Operation successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : RedirectResponse
    {
        Event::query()->findOrFail($id)->delete();
        return redirect()->route('events.index')->with('success', 'Operation successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(Request $request, string $id, string $status) : RedirectResponse
    {
        Event::query()->findOrFail($id)->update(['status' => $status]);
        return redirect()->route('events.edit', $id)->with('success', 'Operation successful!');
    }

    public function getData(Request $request, int $id): JsonResponse
    {
        $event = Event::find($id);
        return response()->json($event);
    }

    public function getDefaultSeatPlans(Request $request) : JsonResponse
    {
        $seatPlans = SeatPlan::query()
            ->where('is_active', true)
            ->with('seatPlanCategories')
            ->get();

        return response()->json($seatPlans);
    }

    private function handleArtists(StoreEventRequest|UpdateEventRequest $request, Event $event) : void
    {
        if (!$request->artist_ids) {
            return;
        }

        $existsIds = Artist::query()->whereIn('id', $request->artist_ids)->get()->pluck('id')->toArray();
        $newArtists = array_diff($request->artist_ids, $existsIds);
        $createdIds = [];
        collect($newArtists)->each(function ($artist) use ($request, &$createdIds) {
            $artist = Artist::query()->create(['name' => $artist]);
            $createdIds[] = $artist->id;
        });
        $toSync = array_merge($existsIds, $createdIds);
        $event->artists()->sync($toSync);
    }

    private function handleProgram(StoreEventRequest|UpdateEventRequest $request, Event $event) : void
    {
        if (! Program::query()->find($request->program_id)) {
            $program = Program::query()->create(['name' => $request->program_id]);
            $event->update(['program_id' => $program->id]);
        } else {
            $event->update(['program_id' => $request->program_id]);
        }
    }
}
