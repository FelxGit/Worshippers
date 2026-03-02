<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\TagRepositoryInterface;
use App\Models\Tag;
use App\Helpers\Globals;

class TagEloquentRepository extends MainEloquentRepository implements TagRepositoryInterface
{
    /*======================================================================
     * PROPERTIES
     *======================================================================*/

    /**
     * @var Tag $Model
     */
    public $Model = Tag::class;

    /*======================================================================
     * METHODS
     *======================================================================*/

    public function acquireAll($paginationPerPage = 10)
    {
        return parent::acquireAll($paginationPerPage);
    }

    public function acquireAllWithSort(array $ids)
    {
        $rtn = [];

        try {
            $rtn = $this->NTCacquireAllWithSort($ids);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        } catch (\Error $e) {
            \Log::error($e->getMessage());
        }

        return $rtn;
    }

    public function NTCacquireAllWithSort(array $ids)
    {
        $rtn = [];

        $non_asso_ids = [];
        foreach ($ids as $index => $id) {
            $non_asso_ids[$index] = $id['id'];
        }

        $implodedIds = implode(',', array_values($non_asso_ids));
        if (!empty($this->Model)) {
            $rtn = $this->Model::whereIn('id', $ids)
                ->orderByRaw(\DB::raw("FIELD(id, $implodedIds)"))
                ->take(Globals::mTag()::POPULARITY_MAX_COUNT)
                ->get();
        }

        return $rtn;
    }

    public function acquire($id)
    {
        return parent::acquire($id);
    }

    public function NTCaddBulk(array $attributesArray)
    {
        $rtn = [];

        if (!empty($this->Model) && count($attributesArray) != 0) {
            foreach ($attributesArray as $arr) {
                $rtn[] = $this->Model::updateOrCreate($arr);
            }
            // $this->Model::upsert($attributesArray, ['title']);
        }

        return $rtn;
    }

    public function acquireByAttributes(array $attributes, bool $returnCollection = true)
    {
        return parent::acquireByAttributes($attributes);
    }

    public function adjust(int $id, array $attributes)
    {
        return parent::adjust($id, $attributes);
    }

    public function annul(int $id)
    {
        return parent::annul($id);
    }
}
