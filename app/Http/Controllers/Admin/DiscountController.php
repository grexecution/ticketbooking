<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discounts\IndexDiscountRequest;
use App\Http\Requests\Discounts\StoreDiscountRequest;
use App\Http\Requests\Discounts\UpdateDiscountRequest;
use App\Models\Discount;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class DiscountController extends Controller
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
     * @param IndexDiscountRequest $request
     * @return Renderable
     */
    public function index(IndexDiscountRequest $request): Renderable
    {
        $discounts = Discount::query()->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })->get();
        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        abort_if(Gate::denies('discount_access'), Response::HTTP_FORBIDDEN);
        return view('admin.discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request) : RedirectResponse
    {
        $toCreate = $request->validated();
        if ($request->type === 'fixed') {
            $toCreate['fixed'] = $request->discount;
        } else {
            $toCreate['percentage'] = $request->discount;
        }
        unset($toCreate['discount']);
        Discount::query()->create($toCreate);

        return redirect()->route('discounts.index')->with('success', 'Operation successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount) : View
    {
        abort_if(Gate::denies('discount_access'), Response::HTTP_FORBIDDEN);
        return view('admin.discounts.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscountRequest $request, Discount $discount) : RedirectResponse
    {
        $toUpdate = $request->validated();
        if ($request->type === 'fixed') {
            $toUpdate['fixed'] = $request->discount;
            $toUpdate['percentage'] = null;
        } else {
            $toUpdate['percentage'] = $request->discount;
            $toUpdate['fixed'] = null;
        }
        unset($toUpdate['discount']);
        $discount->update($toUpdate);
        return redirect()->route('discounts.index')->with('success', 'Operation successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : RedirectResponse
    {
        Discount::query()->findOrFail($id)->delete();
        return redirect()->route('discounts.index')->with('success', 'Operation successful!');
    }

}
