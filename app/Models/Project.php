<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'hours'];

    public $timestamps = false; 

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'project_staff');
    }
}
