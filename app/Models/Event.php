<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Carbon\Carbon;

// class Event extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'club_id',
//         'title',
//         'description',
//         'start_time',
//         'end_time',
//         'location',
//         'max_participants',
//         'status',
//     ];

//     protected $casts = [
//         'start_time' => 'datetime',
//         'end_time' => 'datetime',
//     ];

//     public function club()
//     {
//         return $this->belongsTo(Club::class);
//     }

//     public function getCalculatedStatusAttribute()
//     {
//         $now = Carbon::now();

//         if ($now->lt($this->start_time)) {
//             return 'upcoming';
//         }

//         if ($now->between($this->start_time, $this->end_time)) {
//             return 'ongoing';
//         }

//         return 'finished';
//     }

//     public function getCalculatedStatusLabelAttribute()
//     {
//         return match ($this->calculated_status) {
//             'upcoming' => 'Sắp diễn ra',
//             'ongoing' => 'Đang diễn ra',
//             'finished' => 'Đã kết thúc',
//             default => 'Không xác định',
//         };
//     }

//     public function getCalculatedStatusColorAttribute()
//     {
//         return match ($this->calculated_status) {
//             'upcoming' => '#0d6efd',
//             'ongoing' => '#198754',
//             'finished' => '#6c757d',
//             default => '#000000',
//         };
//     }
// }



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'image',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function getCalculatedStatusAttribute()
    {
        $now = Carbon::now();

        if ($now->lt($this->start_time)) {
            return 'upcoming';
        }

        if ($now->between($this->start_time, $this->end_time)) {
            return 'ongoing';
        }

        return 'finished';
    }

    public function getCalculatedStatusLabelAttribute()
    {
        return match ($this->calculated_status) {
            'upcoming' => 'Sắp diễn ra',
            'ongoing' => 'Đang diễn ra',
            'finished' => 'Đã kết thúc',
            default => 'Không xác định',
        };
    }

    public function getCalculatedStatusColorAttribute()
    {
        return match ($this->calculated_status) {
            'upcoming' => '#0d6efd',
            'ongoing' => '#198754',
            'finished' => '#6c757d',
            default => '#000000',
        };
    }
}