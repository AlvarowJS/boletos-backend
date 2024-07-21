<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\EventDay;
use App\Models\Ticket;
use Illuminate\Http\Request;

class EventDayController extends Controller
{
    public function index()
    {
        $data = EventDay::with('event', 'day')->get();
        return response()->json(['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ticketAmount = $request->ticketAmount;
        $userCurrent = auth()->id();
        $data = new EventDay();
        $data->ticketAmount = $ticketAmount;
        $data->refDate = $request->refDate;
        $data->event_id = $request->event_id;
        $data->day_id = $request->day_id;
        $data->user_id = $userCurrent;
        $data->save();
        // return response()->json($data);

        // Ahora creara un forlop para que registre la tabla de tickets:

        for ($i = 1; $i < $ticketAmount + 1; $i++) {
            // $ticketCode = "000". (string)$data->id . "000". (string)$data->event_id ."000". (string)$data->day_id."00000".$i;
            $ticketCode = str_pad((string)$data->id, 3, '0', STR_PAD_LEFT) .
                str_pad((string)$data->event_id, 3, '0', STR_PAD_LEFT) .
                str_pad((string)$data->day_id, 3, '0', STR_PAD_LEFT) .
                str_pad((string)$i, 5, '0', STR_PAD_LEFT);

            $ticket = new Ticket();
            $ticket->code = $ticketCode;
            $ticket->event_day_id = $data->id;
            $ticket->user_id = $userCurrent;
            $ticket->save();
        }

        return response()->json([
            "data" => $data,
            "amount" => $ticketAmount . " tickets create!"
        ]);
        // $ticketCode = "00". (string)$data->id . "00". (string)$data->event_id ."00". (string)$data->day_id."00"."1";
        // return $ticketCode;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = EventDay::find($id);
        return response()->json(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
