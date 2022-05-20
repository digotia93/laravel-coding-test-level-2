<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use EloquentFilter\Filterable;
use App\Models\Task;

class Project extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
