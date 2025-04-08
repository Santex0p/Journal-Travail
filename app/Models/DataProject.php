<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataProject extends Model
{
    protected $table = 't_data';
    protected $fillable = [
        'datModule',
        'datName',
        'datClass',
        'datPlace',
        'datStartDate',
        'datEndDate',
        'datNbWeeks',
        'datNbHours',
        'datNbPeriod',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function weeks()
    {
        return $this->hasMany(Weeks::class, 'idDataProject');
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'idDataProject'); // Clave foránea en t_tasks
    }

}
