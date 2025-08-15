<?php
namespace App;

use Filament\Support\Contracts\HasLabel;

enum InquiryStatus: string implements HasLabel {

    case Pending    = 'Pending';
    case InProgress = 'In Progress';
    case Resolved   = 'Resolved';
    case Closed     = 'Closed';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::InProgress => 'In Progress',
            self::Resolved => 'Resolved',
            self::Closed => 'Closed',
        };
    }

    public function getBadgeColor(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::InProgress => 'info',
            self::Resolved => 'success',
            self::Closed => 'danger',
        };
    }
}
