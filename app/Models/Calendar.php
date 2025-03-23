<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'start_time', 'end_time', 'calendar_id'];

    protected $casts = [
        'start_time' => 'date'
    ];

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
