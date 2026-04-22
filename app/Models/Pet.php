<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pet extends Model
{
    protected $primaryKey = 'pet_id';

    protected $fillable = [
        'pet_name',
        'location',
        'description',
        'pet_species',
        'pet_status',
        'health_condition',
        'castrated',
        'pet_photo',
        'user_id',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasOne<Adoption, $this>
     */
    public function adoption(): HasOne
    {
        return $this->hasOne(Adoption::class, 'pet_id');
    }
}
