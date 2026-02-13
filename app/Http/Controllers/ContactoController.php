<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function index()
    {
        return view('contacto.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|min:10',
        ]);

        // Enviar el correo electrónico
        Mail::raw($request->mensaje, function ($message) use ($request) {
            $message->to('tu_correo@example.com')
                    ->subject('Mensaje de contacto de ' . $request->nombre)
                    ->from($request->email, $request->nombre);
        });

        return redirect()->route('contacto.index')->with('success', 'Mensaje enviado correctamente.');
    }
}
