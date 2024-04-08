<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\WatchContent;
use Illuminate\Support\Str;

class WatchContentController extends Controller
{
    //
    public function getWatchContent(Request $request) {
        return WatchContent::get();
    }


    public function contentRegister(Request $request)
    {
try {
    $validator = Validator::make($request->all(), [
        'added_by' => 'required',
        'content_url' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => $validator->errors()], 400);
    }

    $input = $request->all();

    $content_url = $input['content_url'];
    $video_id = '';

    if (strpos($content_url, 'youtube.com') !== false) {
        $video_id = substr(strrchr($content_url, '='), 1);
    } elseif (strpos($content_url, 'youtu.be') !== false) {
        $video_id = substr(strrchr($content_url, '/'), 1);
    }

    if (!empty($video_id)) {
        $embed_url = 'https://www.youtube.com/embed/' . $video_id;
        $input['content_url'] = $embed_url;

        $content = WatchContent::create($input);

        $response = [
            'success' => true,
            'data' => $content,
            'message' => 'Content Registered Successfully'
        ];

        return response()->json($response, 200);
    } else {
        return response()->json(['success' => false, 'message' => 'Invalid YouTube URL'], 400);
    }
} catch (QueryException $e) {
    if ($e->errorInfo[1] === 1062) {
        return response()->json(['success' => false, 'message' => 'Content with this URL already exists'], 400);
    } else {
        return response()->json(['success' => false, 'message' => 'Database error'], 500);
    }
}

    }

}
