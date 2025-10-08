<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stream; // <-- IMPORTANT: Import the Stream model

class StreamController extends Controller
{
    /**
     * Mark the authenticated user's stream as started.
     * This will be called by your friend's web app.
     */
    public function start(Request $request)
    {
        $request->validate([
            'stream_id' => 'required|string|unique:streams,stream_id',
            'title' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        // Optional but recommended: Mark any old, unfinished streams from this user as inactive first.
        Stream::where('user_id', $user->id)->where('is_active', true)->update(['is_active' => false]);

        $stream = Stream::create([
            'user_id'   => $user->id,
            'stream_id' => $request->stream_id,
            'title'     => $request->title,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Stream started successfully.',
            'stream'  => $stream,
        ], 201); // 201 means "Created"
    }

    /**
     * Mark the authenticated user's stream as stopped.
     * This will be called by your friend's web app.
     */
    public function stop(Request $request)
    {
        $request->validate([
            // The stream_id must already exist in the streams table for us to stop it
            'stream_id' => 'required|string|exists:streams,stream_id',
        ]);

        $user = Auth::user();

        // Find the stream that matches the stream_id AND belongs to the currently logged-in user
        $stream = Stream::where('stream_id', $request->stream_id)
                        ->where('user_id', $user->id)
                        ->first();

        if ($stream) {
            $stream->update(['is_active' => false]);
            return response()->json(['message' => 'Stream stopped successfully.']);
        }

        // If we can't find the stream, it either doesn't exist or the user isn't authorized to stop it
        return response()->json(['message' => 'Stream not found or you are not authorized to stop it.'], 404); // 404 means "Not Found"
    }

    /**
     * Get a list of all currently active streams.
     * This will be called by your Flutter app.
     */
    public function getActiveStreams()
    {
        // Get all streams where is_active is true
        // Also load the 'user' relationship, but only select the user's id and name
        $activeStreams = Stream::with('user:id,name') 
                               ->where('is_active', true)
                               ->orderBy('created_at', 'desc') // Show newest streams first
                               ->get();

        return response()->json($activeStreams);
    }
}
