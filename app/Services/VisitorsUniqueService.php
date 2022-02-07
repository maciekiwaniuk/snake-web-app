<?php

namespace App\Services;

use App\Models\VisitorUnique;

class VisitorsUniqueService
{
    /**
     * Handle ban ip
     */
    public function handleBanIp(VisitorUnique $ip)
    {
        $ip->update([
            'ip_banned' => 1
        ]);
    }

    /**
     * Handle unban ip
     */
    public function handleUnbanIp(VisitorUnique $ip)
    {
        $ip->update([
            'ip_banned' => 0
        ]);
    }

}
