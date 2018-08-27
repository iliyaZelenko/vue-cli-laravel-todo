<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends BaseModel
{
    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'finished' => 'boolean'
    ];

    protected $appends = ['finished'];

    public function getFinishedAttribute()
    {
        return $this->todo()->select(['completed'])->get()
            ->every(function ($todo) {
                return $todo->completed;
            });
    }

    public function getFinishedCount()
    {
        return $this->todo()->select(['completed'])->get()
            ->every(function ($todo) {
                return $todo->completed;
            });
    }

    public function todo()
    {
        return $this->hasMany(Todo::class);
    }
}
