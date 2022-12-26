<?php

namespace Admin\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\Attachment;
use Illuminate\Http\Request;

class TaskAttachment
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $taskId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $taskId)
    {
        $attachment = Attachment::create([
            'task_id' => $taskId,
            'path' => request('attachments')[0]['path'],
            'name' => request('attachments')[0]['name'],
            'comment_id' => null,
        ]);

        $attachment->save();

        return $attachment;

        return ['success' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return [
            'success' => true,
            'message' => 'Comment Deleted Successfully!',
        ];
    }
}
