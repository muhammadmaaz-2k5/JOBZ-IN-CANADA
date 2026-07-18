<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class AuditLogHelper
{
    /**
     * Write an audit log entry to the database.
     *
     * @param int|null $userId
     * @param string $action
     * @param string $description
     * @return \App\Models\AuditLog
     */
    public static function log(?int $userId, string $action, string $description): AuditLog
    {
        return AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
