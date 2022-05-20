<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Project;
use App\Models\User;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    const NOT_STARTED       = 'NOT STARTED';
    const IN_PROGRESS       = 'IN PROGRESS';
    const READY_FOR_TEST    = 'READY FOR TEST';
    const COMPLETED         = 'COMPLETED';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
