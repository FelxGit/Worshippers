<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use DateTime;

class UserEloquentRepository extends MainEloquentRepository implements UserRepositoryInterface
{
    /*======================================================================
     * PROPERTIES
     *======================================================================*/

    /**
     * @var User $Model
     */
    public $Model = User::class;

    /*======================================================================
     * METHODS
     *======================================================================*/

    /**
     * Acquire all user
     *
     * @param int $paginationPerPage
     * @return LengthAwarePaginator $rtn
     */
    public function acquireAll($paginatePerPage = 10)
    {
        $rtn = $this->arrayToPagination([]);

        try {
            $query = $this->Model::whereNotDeleted();
            $rtn = $query->sortDesc()->paginate($paginatePerPage);
        } catch (\Exception $ex) {
            \Log::error('Error acquiring user: ' . $ex->getMessage());
        }

        return $rtn;
    }

    /**
     * @param array $attributes
     *
     * @return array $rtn
     */
    public function acquireCountByFilter(array $attributes)
    {
        $rtn = [];
        $rtn = parent::acquireCountByFilter($attributes);
        return $rtn;
    }

    /**
     * Acquire a list of records base on attributes given
     * call NTC (No Try Catch) method
     *
     * @param Array $attributes
     * @param Bool $returnCollection - either return by BuildQuery or Collection
     * @return BuildQuery|Collection
     */
    public function acquireByAttributes(array $attributes, bool $returnCollection = true)
    {
        if ($returnCollection) {
            $rtn = $this->arrayToCollection([]);
        } else {
            $rtn = $this->Model::query();
        }

        try {
            $rtn = $this->NTCacquireByAttributes($attributes, $returnCollection);
        } catch (\Exception $e) {
            Log::error('Error acquire by user attributes: ' . $e->getMessage());
        }

        return $rtn;
    }

    /**
     * Acquire a list of records base on attributes given
     * NTC (No Try Catch) method
     *
     * @param Array $attributes
     * @param Bool $returnCollection - either return by BuildQuery or Collection
     * @return BuildQuery|Collection
     */
    public function NTCacquireByAttributes(array $attributes, bool $returnCollection = true)
    {
        if ($returnCollection) {
            $rtn = $this->arrayToCollection([]);
        } else {
            $rtn = $this->Model::query();
        }

        //
        return $rtn;
    }

    /**
     * Acquire a list of records by user favorites
     * call NTC (No Try Catch) method
     *
     * @param int $id
     * @param Bool $returnCollection - either return by BuildQuery or Collection
     * @return BuildQuery|Collection
     */
    public function acquireAllByUserFavorites(int $id, bool $returnCollection = true)
    {
        if ($returnCollection) {
            $rtn = $this->arrayToCollection([]);
        } else {
            $rtn = $this->Model::query();
        }

        try {
            $rtn = new $this->Model;
            $user = $this->acquire($id);
            $fav()->guard('api')->user()->favorites;
        } catch (\Exception $e) {
            Log::error('Error acquire by user favorites: ' . $e->getMessage());
        }

        return $rtn;
    }

    /**
     * add a User record
     *
     * @param Array $attributes
     * @return Bool/User
     */
    public function add(array $attributes)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCadd($attributes);
        } catch (\Exception $e) {
            \Log::error('Error adding user: ' . $e->getMessage());
        }

        return $rtn;
    }

    /**
     * add a model record
     * NTC (No Try Catch) method
     *
     * @param Array $attributes
     * @return Bool/Model
     */
    public function NTCadd(array $attributes)
    {
        $rtn = false;

        if (!empty($this->Model) && count($attributes) != 0) {
            $rtn = $this->Model::create($attributes);

            if ($rtn) {
                $rtn = $rtn->fresh();
            }
        }

        return $rtn;
    }

    /**
     * adjust a model record
     * call NTC (No Try Catch) method
     *
     * @param Int $id
     * @param Array $attributes
     * @return Bool/Model
     */
    public function adjust(int $id, array $attributes)
    {
        return parent::adjust($id, $attributes);
    }

    /**
     * Delete one user record
     *
     * @param int $id
     * @return Bool/User
     */
    public function annul(int $id)
    {
        parent::annul($id);
    }

    /**
     * Delete one user record
     *
     * @param array $ids
     * @return Bool/User
     */
    public function annulMany(array $ids)
    {
        parent::annulMany($ids);
    }
}
