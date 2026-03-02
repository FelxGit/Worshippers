<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends MainModel
{
    use HasFactory;
    
    /**
    * @var $table
    */
    protected $table = 'categories';

    /**
    * @var $primaryKey
    */
    protected $primaryKey = 'id';

    /**
    * @var $fillable
    */
    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
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
     * This method return mulitple Category relation to post.
     *
     * @return collection
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'post_id');
    }
    /*======================================================================
     * SCOPES
     *======================================================================*/
}
