<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['name', 'salary'];

    public $timestamps = false; 

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_staff');
    }
}
