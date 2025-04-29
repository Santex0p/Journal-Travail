<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $table = 't_tasks';

    protected $fillable = [
        'taskName',
        'taskDescription',
    ];

    public function dataProject(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DataProject::class, 'idDataProject'); // Relación con DataProject
    }




}
