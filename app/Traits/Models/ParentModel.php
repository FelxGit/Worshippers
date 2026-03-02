<?php

namespace App\Traits\Models;

use Carbon\Carbon;

trait ParentModel
{
    /*======================================================================
     * CUSTOM METHODS
     *======================================================================*/

    /**
     * get valid attribute if exist, if not then return default value
     *
     * @return [ModelProperty] $rtn
     */
    public function getAttr(string $attribute, $default = '')
    {
        $rtn = $default;

        if ($this->isNotEmpty) {
            if (isset($this[$attribute])) {
                $rtn = $this->{$attribute};
            }
        }

        return $rtn;
    }

    /**
     * get valid relationship attribute if exist, if not then return default value
     *
     * @return [ModelProperty] $rtn
     */
    public function getRelAttr(string $relationshipMethodString, string $attribute, $default = '')
    {
        $rtn = $default;

        if (!empty($this->{$relationshipMethodString})) {
            if (isset($this->{$relationshipMethodString}[$attribute])) {
                $rtn = $this->{$relationshipMethodString}->{$attribute};
            }
        }

        return $rtn;
    }


    /*======================================================================
     * CUSTOM STATIC METHODS
     *======================================================================*/

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            if (in_array('created_at', $data->fillable)) {
                if (empty($data->created_at)) {
                    $data->created_at = Carbon::now();
                }
            }

            if (empty($data->updated_at)) {
                $data->updated_at = Carbon::now();
            }

            // if (empty($data->deleted_at)) {
            //     $data->deleted_at = Carbon::now();
            // }

            return $data;
        });

        static::updating(function ($data) {
            // updated_at
            $data->updated_at = Carbon::now();
            return $data;
        });

        // static::deleting(function($data) {
        //     if (empty($data->deleted_at)) {
        //         $data->deleted_at = Carbon::now();
        //     }
        // });
    }

    /**
     * inserting bulk records
     *
     * @param Array $attributesArray
     * @return Bool $rtn
     */
    public static function inserting(array $attributesArray)
    {
        $rtn = false;
        $insertAttributesArray = [];

        foreach ($attributesArray as $arr) {
            if (empty($arr['created_at'])) {
                $arr['created_at'] = Carbon::now();
            }

            if (empty($arr['updated_at'])) {
                $arr['updated_at'] = Carbon::now();
            }

            if (empty($arr['deleted_at'])) {
                $arr['deleted_at'] = null;
            }

            $insertAttributesArray[] = $arr;
        }

        if (!empty($insertAttributesArray)) {
            $rtn = self::insert($insertAttributesArray);
        }

        return $rtn;
    }

    /**
     * empty table column values
     */
    public static function empty()
    {
        return new static();
    }

    /*======================================================================
     * ACCESSORS
     *======================================================================*/

    /**
     * id
     *
     * @return Int
     */
    public function getIdAttribute($value): int
    {
        $rtn = 0;

        if ($this->primaryKey == 'id') {
            if (!is_null($value)) {
                $rtn = $value;
            }
        } else {
            if (isset($this[$this->primaryKey])) {
                $rtn = $this[$this->primaryKey];
            }
        }

        return $rtn;
    }

    /**
     * isEmpty
     *
     * @return Bool
     */
    public function getIsEmptyAttribute()
    {
        return empty($this->id);
    }

    /**
     * isNotEmpty
     *
     * @return Bool
     */
    public function getIsNotEmptyAttribute()
    {
        return !$this->isEmpty;
    }

    /*======================================================================
     * SCOPES
     *======================================================================*/

    /**
     * whereDeleted
     */
    public function scopeWhereDeleted($query)
    {
        $query->where('deleted_at', null);
        return $query;
    }

    /**
     * whereNotDeleted
     */
    public function scopeWhereNotDeleted($query)
    {
        $query->whereNotNull('deleted_at');
        return $query;
    }

    /**
     * sortAsc
     */
    public function scopeSortAsc($query)
    {
        $query->orderBy('updated_at', 'asc');
        return $query;
    }

    /**
     * sortDesc
     */
    public function scopeSortDesc($query)
    {
        $query->orderBy('updated_at', 'desc');
        return $query;
    }
}
