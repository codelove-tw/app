<?php

namespace App\Models\Idea;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;

    protected $table = 'idea_ideas';

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getVoteCountAttribute()
    {
        return $this->votes()->count();
    }

    public function getCommentCountAttribute()
    {
        return $this->comments()->count();
    }

    public function hasVotedBy($user)
    {
        if (!$user) {
            return false;
        }

        return $this->votes()->where('user_id', $user->id)->exists();
    }

    public function scopeOrderByVotes($query)
    {
        return $query->withCount('votes')->orderBy('votes_count', 'desc');
    }

    public function scopeOrderByLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
