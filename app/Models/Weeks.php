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


    public function planning()
    {
        return $this->hasOne(Planning::class, 'idWeek');
    }

    /**
     * Relación con Journal (Weeks de journal).
     */
    public function journal()
    {
        return $this->hasOne(Journal::class, 'idWeek');
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'idWeek'); // Clave foránea en t_tasks
    }

    public function data()
    {
        return $this->belongsTo(DataProject::class, 'idDataProject');
    }



}
