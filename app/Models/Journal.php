<?php

namespace App\Models;

use App\Models\Tasks;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 't_journal';

    protected $fillable = [
        'jouHours',
        'jouDescription',
        'jouLinks',
    ];

    public function task()
    {
        return $this->belongsTo(Tasks::class, 'idTask');
    }
}
