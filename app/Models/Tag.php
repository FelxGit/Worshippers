<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends MainModel
{
    use HasFactory;
    
    /**
    * @var $table
    */
    protected $table = 'tags';

    /**
    * @var $primaryKey
    */
    protected $primaryKey = 'id';

    /**
    * @var $fillable
    */
    protected $fillable = [
        'title',
        'plain_description',
        'html_description',
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
    const POPULARITY_MAX_COUNT = 10;

    /*======================================================================
     * ACCESSORS
     *======================================================================*/
    /*======================================================================
     * MUTATORS
     *======================================================================*/
    /*======================================================================
     * RELATIONSHIPS
     *======================================================================*/
    /*======================================================================
     * SCOPES
     *======================================================================*/
}
