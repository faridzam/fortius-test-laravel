<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['role', 'name', 'salary'];

    public function role()
    {
        return $this->belongsTo(Role::class,'role','id');
    }
}
