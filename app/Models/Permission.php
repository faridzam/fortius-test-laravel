<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['role', 'module', 'name'];

    public function role()
    {
        return $this->belongsTo(Role::class,'role','id');
    }
    public function module()
    {
        return $this->belongsTo(Modules::class,'module','id');
    }
}
