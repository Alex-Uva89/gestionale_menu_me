<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\Message;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
 


class MessageController extends Controller
{

    public function show(Message $message): Response
    {
        return Inertia::render('Welcome', [
            'message' => $message,
        ]);
    }

    public function index()
    {
        $messages = Message::all();

        return Inertia::render('Welcome', [
            'messages' => $messages, //
        ]);
    }

    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $message->is_read = $request->get('is_read');
        $message->save();

        return response()->json($message);
    }
}
