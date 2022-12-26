<?php

namespace Admin\Http\Controllers\Api;

use App\Models\Task;

class TaskArchive
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Task $task)
    {
        $task->delete();

        return ['success' => true];
    }
}
