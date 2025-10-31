<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MeshtasticMessage;

class MeshtasticController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
            'message'   => 'required|string',
        ]);

        $message = MeshtasticMessage::create([
            'device_id' => $request->device_id,
            'message'   => $request->message,
        ]);

        return response()->json(['status' => 'Message enregistré', 'data' => $message], 201);
    }
}

