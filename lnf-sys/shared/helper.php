<?php

// Real time date
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

// Badges Configuration
function getStatusBadge($status) {
    $statusLower = strtolower($status);

    switch ($statusLower) {
        case 'lost':
            $color = 'bg-danger';
            $text  = 'Missing';
            break;
        case 'found':
            $color = 'bg-primary';
            $text  = 'Reported Found';
            break;
        case 'claimed':
            $color = 'bg-success';
            $text  = 'Claimed';
            break;
        default:
            $color = 'bg-secondary';
            $text  = htmlspecialchars($status);
            break;
    }

    return ['color' => $color, 'text' => $text];
}
?>