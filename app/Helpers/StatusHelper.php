<?php

namespace App\Helpers;

class StatusHelper
{
    /**
     * Parse the status of a user.
     *
     * @param string $status The status of the user.
     * @return string The parsed status.
     */
    public static function parseUserStatus(string $status): string
    {
        $statuses = [
            'pending' => 'Menunggu Persetujuan',
            'done' => 'Disetujui',
            'rejected' => 'Ditolak',
        ];

        return $statuses[$status] ?? $status;
    }

    /**
     * Returns the Bootstrap CSS class name for a given User type.
     *
     * @param string $type The type of User.
     * @return string The Bootstrap CSS class name for the User type.
     */
    public static function parseUserBadgeClassNameStatus(string $type): string
    {
        $classes = [
            'pending' => 'info',
            'approved' => 'success',
            'rejected' => 'danger',
        ];

        return $classes[$type] ?? 'info';
    }
}