<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'Pending';
    case Processing = 'Processing';
    case Dispatched = 'Dispatched';
    case Completed = 'Completed';
    case Cancelled = 'Cancelled';

    /**
     * Returns the CSS badge class corresponding to the status.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'badge-pending',
            self::Processing => 'badge-processing',
            self::Dispatched => 'badge-dispatched',
            self::Completed => 'badge-completed',
            self::Cancelled => 'badge-cancelled',
        };
    }
}