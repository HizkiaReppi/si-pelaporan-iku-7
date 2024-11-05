<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IKU7 extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'iku7';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
