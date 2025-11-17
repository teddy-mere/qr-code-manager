<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class QrCode extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'uuid',
        'title',
        'fields',
    ];

    protected $casts = [
        'fields' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($qr) {
            if (!$qr->uuid) {
                $qr->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
