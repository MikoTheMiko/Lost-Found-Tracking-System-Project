<?php
function timeAgo($datetime) {
    if (!$datetime) return 'Unknown time';

    try {
        $time = new DateTime($datetime);
        $now = new DateTime();
        $diff = $now->getTimestamp() - $time->getTimestamp();

        if ($diff < 0) $diff = 0;

        if ($diff < 60) {
            return $diff . ' second' . ($diff != 1 ? 's' : '') . ' ago';
        } elseif ($diff < 3600) {
            $mins = floor($diff / 60);
            return $mins . ' minute' . ($mins != 1 ? 's' : '') . ' ago';
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return $hours . ' hour' . ($hours != 1 ? 's' : '') . ' ago';
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return $days . ' day' . ($days != 1 ? 's' : '') . ' ago';
        } else {
            return $time->format('F j, Y');
        }
    } catch (Exception $e) {
        return 'Unknown time';
    }
}
?>