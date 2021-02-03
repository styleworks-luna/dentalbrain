<?php


namespace App\Services\Program;


use App\Models\Program\Program;
use App\Models\Program\ProgramPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfflineProgramConcrete extends ProgramTemplate
{

    public function __construct()
    {
        $is_online = false;
        parent::__construct($is_online);
    }

    public function validatePlace(Request $request, array $additionalRules = [])
    {
        $v = Validator::make($request->all()['program_place'], array_merge([
            'address' => ['required', 'string',],
            'address_detail' => ['required', 'nullable', 'string',],

            'sido' => ['required', 'string',],
            'gugun' => ['required', 'string',],
            'dong' => ['required', 'string', 'nullable'],

            'latitude' => ['required', 'regex:/^[0-9]{2,3}\.[0-9]{1,7}$/'],
            'longitude' => ['required', 'regex:/^[0-9]{2,3}\.[0-9]{1,7}$/'],

            'capacity' => ['required', 'numeric'],

            'started_at' => ['required', 'date', 'before:ended_at'],
            'ended_at' => ['required', 'date', 'after:started_at'],

            'receipt_started_at' => ['required', 'date', 'before:receipt_ended_at'],
            'receipt_ended_at' => ['required', 'date', 'after:receipt_started_at', 'before_or_equal:ended_at'],
        ], $additionalRules));

        return $v->validate();
    }

    public function storePlace(Program $program, array $data)
    {
        return ProgramPlace::create([
            'program_id' => $program->id,

            'address' => $data['address'],
            'address_detail' => $data['address_detail'],

            'sido' => $data['sido'],
            'gugun' => $data['gugun'],
            'dong' => $data['dong'],

            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],

            'capacity' => $data['capacity'],

            'started_at' => $data['started_at'],
            'ended_at' => $data['ended_at'],

            'receipt_started_at' => $data['receipt_started_at'],
            'receipt_ended_at' => $data['receipt_ended_at'],
        ]);
    }

    public function updatePlace(Program $program, array $data)
    {
        $program->place->update([
            'program_id' => $program->id,

            'address' => $data['address'],
            'address_detail' => $data['address_detail'],

            'sido' => $data['sido'],
            'gugun' => $data['gugun'],
            'dong' => $data['dong'],

            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],

            'capacity' => $data['capacity'],

            'started_at' => $data['started_at'],
            'ended_at' => $data['ended_at'],

            'receipt_started_at' => $data['receipt_started_at'],
            'receipt_ended_at' => $data['receipt_ended_at'],
        ]);
    }

}
