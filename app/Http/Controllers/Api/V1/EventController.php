<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $data = Event::with('eventDays')->get();
        return response()->json(['mensaje' => 'Event success', 'data' => $data], 201);
        
    }

    public function store(Request $request)
    {
        $file = 'eventosFotos';
        $route = public_path($file);
        if (!\File::isDirectory($route)) {
            $publicpath = 'storage/' . $file;
            \File::makeDirectory($publicpath, 0777, true, true);
        }

        $events = new Event;
        $events->eventName = $request->eventName;
        $image = $request->file('eventImage');

        if ($request->hasFile('eventImage')) {
            $name = uniqid() . '.' . $image->getClientOriginalName();
            $path = $file . '/' . $name;
            \Storage::disk('public')->put($path, \File::get($image)); 
            $events->eventImage = $name;
        }
        $events->eventName = $request->eventName;
        $events->startDate = $request->startDate;
        $events->endingDate = $request->endingDate;
        $events->place = $request->place;
        $events->description = $request->description;
        $events->user_id = auth()->id();
        $events->save();

        return response()->json(['mensaje' => 'Event create', 'data' => $events], 201);
    }

    public function show(string $id)
    {
        $data = Event::find($id);
        if(!$data){            
            return response()->json(['mensaje' => 'Event not found', 'data' => $data], 201);
        }
        return response()->json(['mensaje' => 'Event found', 'data' => $data], 201);

    }

    public function updateEvent(Request $request)
    {

        $id = $request->id;
        $data = Event::find($id);
        if (!$data) {
            return response()->json(['error' => 'data not found'], 404);
        }

        $data->eventName = $request->eventName;
        if ($request->hasFile('eventImage')) {
            // Elimina la imagen antigua si existe
            if ($data->eventImage) {
                \Storage::disk('public')->delete('eventosFotos/' . $data->eventImage);
            }

            // Sube la nueva imagen
            $imagen = $request->file('eventImage');
            $eventImage = uniqid() . '.' . $imagen->getClientOriginalName();
            $path = 'eventosFotos/' . $eventImage;
            \Storage::disk('public')->put($path, \File::get($imagen));
            $data->eventImage = $eventImage;
        }
        $data->eventName = $request->eventName;
        $data->startDate = $request->startDate;
        $data->endingDate = $request->endingDate;
        $data->place = $request->place;
        $data->description = $request->description;
        $data->user_id = auth()->id();
        $data->save();

        return response()->json(['mensaje' => 'Portada actualizada exitosamente', 'data' => $data], 200);
    }

    public function destroy(string $id)
    {
        //
    }
}
