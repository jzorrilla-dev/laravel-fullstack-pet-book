<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adoption extends Model
{
    protected $primaryKey = 'adoption_id';

    protected $fillable = [
        'creator_user_id',
        'adopter_user_id',
        'pet_id',
        'adoption_date',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function adopter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adopter_user_id');
    }

    /**
     * @return BelongsTo<Pet, $this>
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }
}
