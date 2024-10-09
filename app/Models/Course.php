<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function pelaporanIku(): HasMany
    {
        return $this->hasMany(IKU7::class);
    }
}
