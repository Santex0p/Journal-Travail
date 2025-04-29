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

    public function task(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tasks::class, 'idTask');
    }
    public function data(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DataProject::class, 'idDataProject');
    }
    public function week(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Weeks::class, 'idWeek');
    }
}
