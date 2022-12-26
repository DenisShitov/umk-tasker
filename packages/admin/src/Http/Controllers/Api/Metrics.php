<?php

namespace Admin\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Metrics
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // return [
        //     'open_tasks' => 0,
        //     'completed_tasks' => 0,
        //     'total_projects' => 0,
        //     'chart_tasks_yearly' => ['Jan' => 0, 'Feb' => 0,],
        //     'chart_tasks_weekly' => ['Sat' => 0, 'Sun' => 0,],
        // ];

        if (auth()->user()->isSuperAdmin()) {
            return [
                'open_tasks' => Task::whereNull('parent_id')->whereNull('completed_at')->count(),
                'completed_tasks' => Task::whereNull('parent_id')->whereNotNull('completed_at')->count(),
                'total_projects' => Project::count(),
                'chart_tasks_yearly' => $this->chartTasksYearly(),
                'chart_tasks_weekly' => $this->chartTasksWeekly(),
            ];
        }

        return [
            'open_tasks' => Task::whereHas('users', function (Builder $query) {
                                $query->where('id', auth()->id());
                            })->whereNull('parent_id')->whereNull('completed_at')->count(),
            'completed_tasks' => Task::whereHas('users', function (Builder $query) {
                                    $query->where('id', auth()->id());
                                })->whereNull('parent_id')->whereNotNull('completed_at')->count(),
            'total_projects' => Project::whereHas('users', function (Builder $query) {
                                    $query->where('id', auth()->id());
                                })->count(),
            'chart_tasks_yearly' => $this->chartTasksYearly(),
            'chart_tasks_weekly' => $this->chartTasksWeekly(),
        ];
    }

    protected function getTodayEndDate()
    {
        return today()->add('23 Hours 59 Minutes 59 Seconds');
        return today()->add('18 Hours 59 Minutes 59 Seconds');
    }

    protected function chartTasksWeekly()
    {
        $query = DB::table('tasks');

        $query->select(DB::raw("date_format(tasks.completed_at + INTERVAL 0 HOUR, '%Y-%m-%d') as date_result, count(tasks.id) as aggregate"))
                ->whereBetween('tasks.completed_at', [today()->addDay()->subWeek(), $this->getTodayEndDate()])
                ->whereNull('parent_id')
                ->whereExists(function ($q) {
                    $q->select(DB::raw('*'))
                        ->from('users')
                        ->join('task_user', 'users.id', '=', 'task_user.user_id')
                        ->whereColumn('task_user.task_id', 'tasks.id')
                        ->whereId(auth()->id());
                })
                ->groupBy(DB::raw("date_format(tasks.completed_at + INTERVAL 0 HOUR, '%Y-%m-%d')"))
                ->orderBy('date_result');

        $results = $query->get();

        $array = $results->map(function ($item) {
            return [Carbon::parse($item->date_result)->format('D') => $item->aggregate];
        });

        $data = $array->collapse();

        $days = [];

        for ($i = 0; $i < 7; $i++) {
            $day = today()->addDay($i + 1)->format('D');
            $days[$day] = $data[$day] ?? 0;
        }

        return $days;
    }

    protected function chartTasksYearly()
    {
        $query = DB::table('tasks');

        $query->select(DB::raw("date_format(tasks.completed_at + INTERVAL 0 HOUR, '%Y-%m') as date_result, count(tasks.id) as aggregate"))
                ->whereBetween('tasks.completed_at', [today()->startOfYear(), today()->endOfYear()])
                ->whereNull('parent_id')
                ->whereExists(function ($q) {
                    $q->select(DB::raw('*'))
                        ->from('users')
                        ->join('task_user', 'users.id', '=', 'task_user.user_id')
                        ->whereColumn('task_user.task_id', 'tasks.id')
                        ->whereId(auth()->id());
                })
                ->groupBy(DB::raw("date_format(tasks.completed_at + INTERVAL 0 HOUR, '%Y-%m')"))
                ->orderBy('date_result');

        $results = $query->get();

        $array = $results->map(function ($item) {
            return [Carbon::parse($item->date_result)->format('M') => $item->aggregate];
        });

        $data = $array->collapse();

        $months = [];

        for ($i = 0; $i < 12; $i++) {
            $day = today()->month($i + 1)->format('M');
            $months[$day] = $data[$day] ?? 0;
        }

        return $months;
    }
}
