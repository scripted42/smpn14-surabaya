<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PpdbFaq extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'ppdb_setting_id',
        'question',
        'answer',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function ppdbSetting(): BelongsTo
    {
        return $this->belongsTo(PpdbSetting::class);
    }
}
