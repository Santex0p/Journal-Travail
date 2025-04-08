<?php

namespace App\Models;

use App\Models\Tasks;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    protected $table = 't_planning';

    protected $fillable = [
        'plaHours',
        'plaDescription',
        'plaLinks',
    ];

    public function task()
    {
        return $this->belongsTo(Tasks::class, 'idTask');
    }
}
