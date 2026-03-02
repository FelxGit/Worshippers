<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class PostFavorite extends MainModel
{
    /**
    * @var $table
    */
    protected $table = 'post_favorites';

    /**
    * @var $primaryKey
    */
    protected $primaryKey = 'id';

    /**
    * @var $fillable
    */
    protected $fillable = [
        'user_id',
        'post_id',
        'deleted_at'
    ];

    /**
    * @var $cast
    */
    protected $casts = [
        //
    ];

    /**
    * @var $appends
    */
    protected $appends = [
        //
    ];

    /*======================================================================
     * CONSTANTS
     *======================================================================*/
    /*======================================================================
     * ACCESSORS
     *======================================================================*/
    /*======================================================================
     * MUTATORS
     *======================================================================*/
    /*======================================================================
     * RELATIONSHIPS
     *======================================================================*/

     /**
     * This method return mulitple favorites relation to user.
     *
     * @return collection
     */
    public function posts()
    {
        return $this->belongsTo(Post::class);
    }
    /*======================================================================
     * SCOPES
     *======================================================================*/
}
