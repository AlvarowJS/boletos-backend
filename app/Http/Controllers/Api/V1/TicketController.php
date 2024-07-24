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
        if (request()->filled($queryEvent)) {
            // Define el número de registros por página
            $perPage = 500;

            // Obtén el número de página actual
            $page = request()->input('page', 1);

            // Consulta con paginación
            $query = Ticket::with('user', 'eventDay', 'eventDay.event')
                ->where('event_day_id', request()->input($queryEvent))
                ->paginate($perPage, ['*'], 'page', $page);

            // Cálculo de tickets válidos e inválidos
            $validTickets = $query->filter(function ($ticket) {
                return $ticket->validate;
            })->count();

            $invalidTickets = $query->filter(function ($ticket) {
                return !$ticket->validate;
            })->count();

            return response()->json([
                'total' => $query->total(), // Total de registros en la consulta
                'valid' => $validTickets,
                'invalid' => $invalidTickets,
                'data' => $query->items(), // Registros de la página actual
                'current_page' => $query->currentPage(),
                'last_page' => $query->lastPage(),
                'per_page' => $query->perPage(),
                'total_pages' => $query->lastPage(),
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
