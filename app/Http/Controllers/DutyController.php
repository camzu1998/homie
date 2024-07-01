<?php

namespace App\Http\Controllers;

use App\Helpers\HouseInviteStatus;
use App\Http\Requests\DutyRequest;
use App\Models\Duty;

class DutyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Duty::class, 'duty');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = auth()->user()->pickedHouse->users()->wherePivot('status', HouseInviteStatus::ACCEPTED)->get()->map(function ($user) {
            return [
                'value' => $user->id,
                'text' => $user->name,
            ];
        });

        return response()->json(["duties" => auth()->user()->pickedHouse->duties()->with(['user', 'room'])->get(), "users" => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DutyRequest $request)
    {
        $duty = auth()->user()->pickedHouse->duties()->create($request->data()->toArray());

        return response()->json(["duties" => auth()->user()->pickedHouse->duties()->with(['user', 'room'])->get()]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Duty $duty)
    {
        $users = auth()->user()->pickedHouse->users()->wherePivot('status', HouseInviteStatus::ACCEPTED)->get()->map(function ($user) {
            return [
                'value' => $user->id,
                'text' => $user->name,
            ];
        });

        return response()->json(["duty" => $duty, "users" => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DutyRequest $request, Duty $duty)
    {
        $duty->update($request->validated());

        return response()->json(["duties" => auth()->user()->pickedHouse->duties()->with(['user', 'room'])->get()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Duty $duty)
    {
        $duty->delete();

        return response()->json(["duties" => auth()->user()->pickedHouse->duties()->with(['user', 'room'])->get()]);
    }
}
