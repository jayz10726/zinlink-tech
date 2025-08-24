<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'service_used',
        'rating',
        'comment',
        'status'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            self::STATUS_APPROVED => 'bg-green-900 text-green-200',
            self::STATUS_REJECTED => 'bg-red-900 text-red-200',
            default => 'bg-yellow-900 text-yellow-200'
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            default => 'Pending'
        };
    }

    public function getRatingStarsAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '<i class="fas fa-star text-yellow-400"></i>';
            } else {
                $stars .= '<i class="far fa-star text-gray-400"></i>';
            }
        }
        return $stars;
    }
} 