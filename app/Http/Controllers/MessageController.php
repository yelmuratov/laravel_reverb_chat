<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Events\PrivateMessageEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chats = Message::all();
        $users = User::all();
        return view('welcome', compact('chats', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'path_file' => 'nullable|file',
            'image_path' => 'nullable|image',
        ]);
        
        // storage image and file
        $path_file = $request->file('path_file') ? $request->file('path_file')->store('files', 'public') : null;
        $image_path = $request->file('image_path') ? $request->file('image_path')->store('images', 'public') : null;

        $message = Message::create([
            'content' => $request->content,
            'path_file' => $path_file,
            'image_path' => $image_path,
        ]);

        // broadcast event
        broadcast(new MessageEvent($message));

        return redirect()->back();
    }

    public function storePrivate(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'receiver_id' => 'required|exists:users,id',
            'path_file' => 'nullable|file',
            'image_path' => 'nullable|image',
        ]);

        $path_file = $request->file('path_file') ? $request->file('path_file')->store('files', 'public') : null;
        $image_path = $request->file('image_path') ? $request->file('image_path')->store('images', 'public') : null;

        $message = Message::create([
            'content' => $request->content,
            'path_file' => $path_file,
            'image_path' => $image_path,
        ]);

        broadcast(new PrivateMessageEvent($message, $request->receiver_id));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
