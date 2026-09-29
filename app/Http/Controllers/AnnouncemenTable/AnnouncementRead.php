<?php

namespace App\Http\Controllers\AnnouncemenTable;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Resource;

class AnnouncementRead extends Controller
{
    public function getAnnoucements()
    {
        $announcements = Announcement::orderBy(
            'created_at',
            'desc'
        )->paginate(10);

        $announcementIds = $announcements
            ->getCollection()
            ->pluck('announcement_id');

        $resources = Resource::where(
            'owner_table',
            'announcements'
        )
            ->whereIn(
                'owner_row_id',
                $announcementIds
            )
            ->get([
                'resource_id',
                'owner_row_id',
                'title',
                'url'
            ])
            ->groupBy('owner_row_id');

        $announcements->getCollection()->transform(
            function ($announcement) use ($resources) {

                $announcement->resources =
                    $resources->get(
                        $announcement->announcement_id,
                        collect()
                    )->values();

                return $announcement;
            }
        );

        return response()->json($announcements);
    }
}
