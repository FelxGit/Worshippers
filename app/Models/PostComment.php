<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Post;

class PostComment extends MainModel
{
    use SoftDeletes;

    /**
    * @var $table
    */
    protected $table = 'post_comments';

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
        'description',
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
     * This method return mulitple User relation to post.
     *
     * @return collection
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * This method return mulitple Likes relation to post.
     *
     * @return collection
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * This method return mulitple Likes relation to post.
     *
     * @return collection
     */
    // public function likes()
    // {
    //     return $this->belongsToMany(Post::class, 'post_id');
    // }

    /*======================================================================
     * SCOPES
     *======================================================================*/
}
