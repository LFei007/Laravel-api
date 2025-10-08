<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stream extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'stream_id',
        'title',
        'is_active',
    ];

    /**
     * Get the user (streamer) that owns this stream.
     * This is the relationship.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}