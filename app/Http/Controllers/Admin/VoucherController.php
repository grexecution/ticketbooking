<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vouchers\StoreVoucherRequest;
use App\Http\Requests\Vouchers\UpdateVoucherRequest;
use App\Models\Event;
use App\Models\Voucher;
use Carbon\Carbon;
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
    public function index(Request $request): Renderable
    {
        return view('admin.vouchers.index', [
            'vouchers' => Voucher::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        abort_if(Gate::denies('voucher_access'), Response::HTTP_FORBIDDEN);
        return view('admin.vouchers.create', [
            'events' => Event::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request) : RedirectResponse
    {
        $toCreate = $request->validated();
        if ($request->type === 'fixed') {
            $toCreate['fixed'] = $request->discount;
        } else {
            $toCreate['percentage'] = $request->discount;
        }
        unset($toCreate['discount']);
        $toCreate['expired_at'] = Carbon::parse($toCreate['expired_at']);
        $voucher = Voucher::query()->create($toCreate);
        $voucher->events()->sync($toCreate['event_ids']);
        $voucher->eventsExcepts()->sync($toCreate['event_except_ids']);

        return redirect()->route('vouchers.index')->with('success', 'Operation successful!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher) : View
    {
        abort_if(Gate::denies('voucher_access'), Response::HTTP_FORBIDDEN);
        $voucher->load(['events', 'eventsExcepts']);

        return view('admin.vouchers.edit', [
            'voucher' => $voucher,
            'events' => Event::all(),
            'eventIds' => $voucher->events->pluck('id')->toArray(),
            'eventExceptIds' => $voucher->eventsExcepts->pluck('id')->toArray(),
            'discount' => $voucher->type === 'fixed' ? $voucher->fixed : $voucher->percentage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRequest $request, Voucher $voucher) : RedirectResponse
    {
        $toUpdate = $request->validated();
        if ($request->type === 'fixed') {
            $toUpdate['fixed'] = $request->discount;
            $toUpdate['percentage'] = null;
        } else {
            $toUpdate['percentage'] = $request->discount;
            $toUpdate['fixed'] = null;
        }
        $toUpdate['expired_at'] = Carbon::parse($toUpdate['expired_at']);
        $voucher->events()->sync($toUpdate['event_ids']);
        $voucher->eventsExcepts()->sync($toUpdate['event_except_ids']);
        unset(
            $toUpdate['discount'],
            $toUpdate['eventIds'],
            $toUpdate['eventExceptIds'],
        );
        $voucher->update($toUpdate);

        return redirect()->route('vouchers.index')->with('success', 'Operation successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : RedirectResponse
    {
        Voucher::query()->findOrFail($id)->delete();
        return redirect()->route('vouchers.index')->with('success', 'Operation successful!');
    }
}
