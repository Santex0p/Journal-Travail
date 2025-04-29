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

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function weeks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Weeks::class, 'idDataProject');
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tasks::class, 'idDataProject'); // Clave foránea en t_tasks
    }

}
