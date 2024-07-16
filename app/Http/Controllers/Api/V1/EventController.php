<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $data = Event::all();
        return $data;
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
        $events->save();

        return response()->json(['mensaje' => 'Event create', 'data' => $events], 201);
    }

    public function show(string $id)
    {
        $data = Event::find($id);
        if(!$data){            
            return response()->json(['mensaje' => 'Event update', 'data' => $data], 201);
        }

    }

    public function update(Request $request, string $id)
    {
        $id = $request->id;
        $data = Event::find($id);
        if (!$data) {
            return response()->json(['error' => 'data not found'], 404);
        }

        $data->eventName = $request->eventName;
        if ($request->hasFile('foto')) {
            // Elimina la imagen antigua si existe
            if ($data->foto) {
                \Storage::disk('public')->delete('eventosFotos/' . $data->foto);
            }

            // Sube la nueva imagen
            $imagen = $request->file('foto');
            $nombre = uniqid() . '.' . $imagen->getClientOriginalName();
            $path = 'fotosPortada/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($imagen));
            $data->foto = $nombre;
        }

        $data->estado = $request->estado;
        $data->user_id = $request->user_id;
        $data->save();

        return response()->json(['mensaje' => 'Portada actualizada exitosamente', 'data' => $portada], 200);
    }

    public function destroy(string $id)
    {
        //
    }
}
