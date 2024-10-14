<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];
    
    public function pelaporanIku(): HasMany
    {
        return $this->hasMany(IKU7::class);
    }
    
    public function mataKuliah(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
