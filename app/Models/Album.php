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
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images() {
        return $this->hasMany(Image::class);
    }
}
