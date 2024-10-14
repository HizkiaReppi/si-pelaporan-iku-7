<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function pelaporanIku(): HasOne
    {
        return $this->hasOne(IKU7::class);
    }
}
