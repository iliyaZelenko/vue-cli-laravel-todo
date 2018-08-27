<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Todo extends BaseModel
{
    protected $fillable = [
        'comment', 'completed', 'completed_at', 'created_at', 'title', 'group_id'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
