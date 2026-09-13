<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityLogController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Activity Logs
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $search = $request->input('search');


        /*
        |--------------------------------------------------------------------------
        | Activity Type
        |--------------------------------------------------------------------------
        */

        $type = $request->input('type');


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        $status = $request->input('status');


        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        $dateRange = $request->input(
            'date_range',
            'Last 7 Days'
        );


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        |
        | Admin can see activity logs from all users.
        |
        */

        $query = ActivityLog::with('user');


        /*
        |--------------------------------------------------------------------------
        | Search Filter
        |--------------------------------------------------------------------------
        |
        | Search by:
        | - User name
        | - Activity
        | - Description
        | - IP address
        |
        */

        if ($search) {
            $query->where(function ($q) use ($search) {

                $q->where('activity', 'like', '%' . $search . '%')

                    ->orWhere(
                        'description',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'ip_address',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhereHas('user', function ($userQuery) use ($search) {

                        $userQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );

                    });
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Activity Type Filter
        |--------------------------------------------------------------------------
        */

        if ($type && $type !== 'All Activities') {
            $query->where('type', $type);
        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($status && $status !== 'All Status') {
            $query->where('status', $status);
        }


        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        switch ($dateRange) {

            case 'Last 7 Days':

                $query->where(
                    'created_at',
                    '>=',
                    now()->subDays(6)->startOfDay()
                );

                break;


            case 'Last 30 Days':

                $query->where(
                    'created_at',
                    '>=',
                    now()->subDays(29)->startOfDay()
                );

                break;


            case 'Last 90 Days':

                $query->where(
                    'created_at',
                    '>=',
                    now()->subDays(89)->startOfDay()
                );

                break;


            case 'This Year':

                $query->whereYear(
                    'created_at',
                    now()->year
                );

                break;


            case 'Custom Range':

                if (
                    $request->filled('start_date') &&
                    $request->filled('end_date')
                ) {

                    $query->whereBetween('created_at', [
                        $request->start_date . ' 00:00:00',

                        $request->end_date . ' 23:59:59',
                    ]);
                }

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | Activity History
        |--------------------------------------------------------------------------
        */

        $activities = $query
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Summary Cards
        |--------------------------------------------------------------------------
        */

        $totalActivities = ActivityLog::count();


        $today = ActivityLog::whereDate(
            'created_at',
            today()
        )->count();


        $successful = ActivityLog::where(
            'status',
            'Successful'
        )->count();


        $failed = ActivityLog::where(
            'status',
            'Failed'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'pages.activity-logs.index',
            compact(
                'activities',
                'totalActivities',
                'today',
                'successful',
                'failed',
                'search',
                'type',
                'status',
                'dateRange'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Export
    |--------------------------------------------------------------------------
    */

    public function export(): StreamedResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Get All Activities
        |--------------------------------------------------------------------------
        */

        $activities = ActivityLog::with('user')
            ->latest('created_at')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | File Name
        |--------------------------------------------------------------------------
        */

        $filename =
            'activity_logs_' .
            now()->format('Ymd_His') .
            '.csv';


        /*
        |--------------------------------------------------------------------------
        | Generate CSV
        |--------------------------------------------------------------------------
        */

        return response()->streamDownload(
            function () use ($activities) {

                $handle = fopen(
                    'php://output',
                    'w'
                );


                /*
                |--------------------------------------------------------------------------
                | CSV Header
                |--------------------------------------------------------------------------
                */

                fputcsv($handle, [
                    'User ID',
                    'User',
                    'Activity',
                    'Type',
                    'Description',
                    'IP Address',
                    'Status',
                    'Date & Time',
                ]);


                /*
                |--------------------------------------------------------------------------
                | CSV Rows
                |--------------------------------------------------------------------------
                */

                foreach ($activities as $activity) {

                    fputcsv($handle, [

                        $activity->user_id,

                        $activity->user?->name
                            ?? 'Deleted User',

                        $activity->activity,

                        $activity->type,

                        $activity->description,

                        $activity->ip_address,

                        $activity->status,

                        $activity->created_at?->format(
                            'Y-m-d H:i:s'
                        ),
                    ]);
                }


                fclose($handle);
            },

            $filename
        );
    }
}