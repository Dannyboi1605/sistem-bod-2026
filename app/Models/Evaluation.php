<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'b1', 'b2', 'b3', 'b4', 'b5', 'b6', 'b7', 'b8', 'b9', 'b10',
    'c1_idris_jala', 'c2_fuad_bee', 'c3_petrus_gimbad', 'c4_lee_min_onn', 'c5_khairunnizat', 'c6_saravana_kumar',
    'd1_beneficial', 'd2_improvements', 'd3_future_topics',
    'e_overall',
    'f_interested', 'f_field',
])]
class Evaluation extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'b1' => 'integer', 'b2' => 'integer', 'b3' => 'integer', 'b4' => 'integer', 'b5' => 'integer',
            'b6' => 'integer', 'b7' => 'integer', 'b8' => 'integer', 'b9' => 'integer', 'b10' => 'integer',
            'c1_idris_jala' => 'integer', 'c2_fuad_bee' => 'integer', 'c3_petrus_gimbad' => 'integer',
            'c4_lee_min_onn' => 'integer', 'c5_khairunnizat' => 'integer', 'c6_saravana_kumar' => 'integer',
            'e_overall' => 'integer',
            'f_interested' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the evaluation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
