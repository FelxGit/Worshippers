<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as MyUser;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\PostFavorite;
use App\Models\Post;
use App\Traits\Models\ParentModel;

class User extends MyUser implements Authenticatable
{
    use Notifiable, HasFactory, HasApiTokens;
    use ParentModel;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'google_id',
        'email',
        'username',
        'password',
        'firstname',
        'middlename',
        'lastname',
        'name',
        'nick_name',
        'avatar',
        'birth_date',
        'gender',
        'zip_code',
        'address',
        'tel',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /*======================================================================
     * CONSTANTS
     *======================================================================*/

    const ADMIN_USER = 1;
    const NORMAL_USER = 2;

    const FEMALE = 0;
    const MALE = 1;

    const PASSWORD_DEFAULT = 'password';
    // const AVATAR_DEFAULT = 'storage/tmp/'

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at',
        'deleted_at'
    ];

    /**
     * This method return multiple user relation to post.
     *
     * @return collection
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * This method return mulitple favorites relation to user.
     *
     * @return collection
     */
    public function favorites()
    {
        return $this->hasMany(PostFavorite::class);
    }

    /**
     * The channel to receive the broadcasted notification.
     *
     * @return collection
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'usernotify';
    }

    /*======================================================================
    * SCOPES
    *======================================================================*/

    /**
     * sortDesc
     */
    public function scopeSortDesc($query)
    {
        $query->orderBy('created_at', 'desc');
        return $query;
    }

    /**
     * where not deleted
     */
    public function scopeWhereNotDeleted($query)
    {
        $query->whereNull('deleted_at');
        return $query;
    }
}
