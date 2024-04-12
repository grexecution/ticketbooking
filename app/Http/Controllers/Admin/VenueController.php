<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Venues\IndexVenueRequest;
use App\Http\Requests\Venues\StoreVenueRequest;
use App\Http\Requests\Venues\UpdateVenueRequest;
use App\Models\Venue;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class VenueController extends Controller
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
     * @param IndexVenueRequest $request
     * @return Renderable
     */
    public function index(IndexVenueRequest $request): Renderable
    {
        $venues = Venue::query()->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })->get();

        return view('admin.venues.index', compact('venues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        abort_if(Gate::denies('venue_access'), Response::HTTP_FORBIDDEN);
        return view('admin.venues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVenueRequest $request) : RedirectResponse
    {
        $toCreate = collect($request->validated())->except(['logo', 'logo_origin_names', 'logo_sizes'])->toArray();
        $venue = Venue::query()->create($toCreate);
        MediaHelper::handleMedia($venue, 'logo', $request->logo);

        return redirect()->route('venues.index')->with('success', 'Operation successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venue $venue) : View
    {
        abort_if(Gate::denies('venue_access'), Response::HTTP_FORBIDDEN);
        return view('admin.venues.edit', compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVenueRequest $request, Venue $venue) : RedirectResponse
    {
        $toUpdate = collect($request->validated())->except(['logo', 'logo_origin_names', 'logo_sizes'])->toArray();
        if ($request->logo !== $venue->logo?->name) {
            MediaHelper::handleMedia($venue, 'logo', $request->logo);
        }
        $venue->update($toUpdate);

        return redirect()->route('venues.index')->with('success', 'Operation successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : RedirectResponse
    {
        Venue::query()->findOrFail($id)->delete();
        return redirect()->route('venues.index')->with('success', 'Operation successful!');
    }

}
