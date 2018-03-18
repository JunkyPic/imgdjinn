<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 *
 * @package App\Models
 */
class Image extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'image';

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function album(){
        return $this->belongsto(Album::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsto(User::class);
    }
}
