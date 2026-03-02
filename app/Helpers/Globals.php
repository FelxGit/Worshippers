<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Tag;

class Globals
{
    /*======================================================================
     * CONSTANTS
     *======================================================================*/

     const FILETYPE_IMAGE = 'image';
     const FILETYPE_CSV = 'csv';

     const GRAPH_YEAR = 'Year';
     const GRAPH_MONTH = 'Month';
     const GRAPH_WEEK = 'Week';

     const MODEL_USER = 'User';
     const MODEL_POST = 'Post';

     const IMG_ACCEPTEDEXTENSION = ['jpg', 'jpeg', 'png'];
    //  const CONVERSION_BYTETOKILOBYTE = 1024;

    CONST NOTIFIABLE_TYPE = [
        'post_likes' => 'App\\Models\\PostLike',
        'post_favorites' => 'App\\Models\\PostFavorite',
    ];

    /*======================================================================
     * STATIC METHODS
     *======================================================================*/

    /**
     * Globals::__()
     * return a concatenated by lang/locale by space (" ")
     *
     * @param Strin/Int/Object/Array $trans
     * @return String $rtn
     */
    public static function __($trans)
    {
        $rtn = '';

        if (!is_array($trans)) {
            $trans = [$trans];
        }

        foreach ($trans as $ind => $tran) {
            if ($ind != 0) {
                $rtn .= ' ';
            }

            $rtn .= __($tran);
        }

        return $rtn;
    }

    /**
     * Globals::__values()
     * return an array with translated values
     *
     * @param Array $data
     * @return Array $rtn
     */
    public static function __values(array $data)
    {
        $rtn = $data;

        foreach ($data as $key => $val) {
            $rtn[$key] = __($val);
        }

        return $rtn;
    }

    /**
     * Globals::mUser()
     * return a model class (User)
     *
     * @return User
     */
    public static function mUser()
    {
        return User::class;
    }

    /**
     * Globals::mTag()
     * return a model class (Tag)
     *
     * @return Tag
     */
    public static function mTag()
    {
        return Tag::class;
    }
}
