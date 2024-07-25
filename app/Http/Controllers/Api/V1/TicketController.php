<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class TicketController extends Controller
{

    public function generateQR(Request $request)
    {

        $data = $request->input('data');
        $qr = QrCode::format('png')->generate($data);
        // return response($qr, 200)->header('Content-Type', 'image/png');

    }
    public function index()
    {
        $queryEvent = 'eventDay';
        if(request()->filled($queryEvent))
        {            
            $query = Ticket::with('user', 'eventDay','eventDay.event')->where('event_day_id', request()->input($queryEvent))->get();
            $validTickets = $query->where('validate', true)->count();
            $invalidTickets = $query->where('validate', false)->count();
            return response()->json([
                'total' => count($query),   
                'valid' => $validTickets,
                'invalid' => $invalidTickets,             
                'data' => $query  
            ]);
        }
    }


    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $data = Ticket::find($id);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request, string $code)
    {        
        $ticket = Ticket::where('code', $code)->first();
        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }
        if ($ticket->validate == true) {
            return response()->json(['error' => 'Ticket already validated'], 400);
        }
        $ticket->validate = true;
        $ticket->dateRegister = now();
        $ticket->save();
        return response()->json(['message' => 'Ticket updated successfully', 'data' => $ticket], 200);
    }

    public function destroy(string $id)
    {
        //
    }
}
