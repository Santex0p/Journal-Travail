<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weeks extends Model
{
    protected $table = 't_weeks';

    protected $fillable = [
        'weekName',
        'weekStartDate',
        'weekEndDate',
    ];


    public function planning(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Planning::class, 'idWeek');
    }

    /**
     * Relación con Journal (Weeks de journal).
     */
    public function journal(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Journal::class, 'idWeek');
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tasks::class, 'idWeek'); // Clave foránea en t_tasks
    }

    public function data(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DataProject::class, 'idDataProject');
    }



}
