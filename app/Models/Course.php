<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Episode;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\Authorizable;
use phpDocumentor\Reflection\DocBlock\Description;

/**
 * Class Course
 * @package App\Models
 */
class Course extends Model
{
    use HasFactory;
    use Authorizable;

    protected $fillable = [
      'title',
      'description'
    ];

    protected $appends = [
      'update'
    ];

    protected static function booted()
    {
        static::creating(function ($course) {
            $course->user_id = auth()->user()->id;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUpdateAttribute()
    {
        return $this->can('update-course',$this);
    }
}
