<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Album
 *
 * @package App\Models
 */
class Album extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'album';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
    public $fillable = [
        'path',
        'alias',
        'password',
        'display_password',
        'token',
        'display_token',
        'user_id',
        'is_nsfw',
        'is_private',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images() {
        return $this->hasMany(Image::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsto(User::class);
    }
}
