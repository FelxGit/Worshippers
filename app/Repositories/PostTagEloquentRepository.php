<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\PostTagRepositoryInterface;
use App\Models\PostTag;

class PostTagEloquentRepository extends MainEloquentRepository implements PostTagRepositoryInterface
{
    /*======================================================================
     * PROPERTIES
     *======================================================================*/

    /**
     * @var PostTag $Model
     */
    public $Model = PostTag::class;

    /*======================================================================
     * METHODS
     *======================================================================*/

    public function acquireByPopularity(int $count = 10)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCacquireByPopularity($count);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        } catch (\Error $e) {
            \Log::error($e->getMessage());
        }

        return $rtn;
    }

    public function NTCacquireByPopularity(int $count)
    {
        if (!empty($this->Model)) {
            $rtn = $this->Model::groupBy('tag_id')
                ->SELECT(\DB::raw('tag_id as id'))
                ->orderByRaw('COUNT(*) desc')
                ->limit($count)
                ->get();
        }

        return $rtn;
    }

    public function acquire($id)
    {
        return parent::acquire($id);
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
