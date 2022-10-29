<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'value',
        'required',
    ];

    public function options() {
        return $this->hasMany(Option::class);
    }
}
