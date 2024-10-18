<?php

namespace Abd\Payment\Http\Controllers;

use Abd\Payment\Http\Requests\SettlementRequest;
use Abd\Payment\Models\Settlement;
use Abd\Payment\Repositories\SettlementRepo;
use Abd\Payment\Services\SettlementService;
use Abd\RolePermissions\Models\Permission;
use App\Http\Controllers\Controller;

class SettlementController extends Controller
{
    public function index(SettlementRepo $repo)
    {
        $this->authorize('index', Settlement::class);
        if (auth()->user()->can(Permission::PERMISSION_MANAGE_SETTLEMENTS)) {
            $settlements = $repo->latest()->paginate();
        } else {
            $settlements = $repo->paginateUserSettlements(auth()->id());
        }
        return view('Payment::settlements.index', compact('settlements'));
    }

    public function create(SettlementRepo $repo)
    {
        $this->authorize('create', Settlement::class);
        if ($repo->getLatestPendingSettlement(auth()->id())) {
            newFeedback("Unsuccessful", "You have a pending request and cannot submit a new request at this time.", "error");
            return redirect(route('settlements.index'));
        }
        return view('Payment::settlements.create');
    }

    public function store(SettlementRequest $request, SettlementRepo $repo)
    {
        $this->authorize('create', Settlement::class);
        if ($repo->getLatestPendingSettlement(auth()->id())) {
            newFeedback("Unsuccessful", "You have a pending request and cannot submit a new request at this time.", "error");
            return redirect(route('settlements.index'));
        }
        SettlementService::store($request->all());
        return redirect(route('settlements.index'));
    }

    public function edit($settlementId, SettlementRepo $repo)
    {
        $this->authorize('manage', Settlement::class);
        $requestedSettlement = $repo->find($settlementId);
        $settlement = $repo->getLatestSettlement($requestedSettlement->user_id);
        if ($settlement->id != $settlementId) {
            newFeedback("Unsuccessful", "This settlement request cannot be edited and has been archived. Only the latest settlement request of each user can be edited.", "error");
            return redirect(route('settlements.index'));
        }
        return view('Payment::settlements.edit', compact('settlement'));
    }

    public function update($settlementId, SettlementRequest $request, SettlementRepo $repo)
    {
        $this->authorize('manage', Settlement::class);
        $requestedSettlement = $repo->find($settlementId);
        $settlement = $repo->getLatestSettlement($requestedSettlement->user_id);
        if ($settlement->id != $settlementId) {
            newFeedback("Unsuccessful", "This settlement request cannot be edited and has been archived. Only the latest settlement request of each user can be edited.", "error");
            return redirect(route('settlements.index'));
        }
        SettlementService::update($settlementId, $request->all());
        return redirect(route('settlements.index'));
    }
}
