<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::all();
        return view('messages.index', compact('messages'));
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
        // content, file_path, image_path
        // validate the file and image then save the file and image path to the database
        $request->validate([
            'content' => 'required',
            'file_path' => 'required|file',
            'image_path' => 'required|image',
        ]);

        $file_path = $request->file('file_path')->store('files','public');
        $image_path = $request->file('image_path')->store('images','public');

        Message::create([
            'content' => $request->content,
            'file_path' => $file_path,
            'image_path' => $image_path,
        ]);

        return redirect()->route('messages.index');
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
