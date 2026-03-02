<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use App\Traits\ModelCollectionTrait;
use Carbon\Carbon;
use DateTime;

class MainEloquentRepository
{
    use ModelCollectionTrait;

    /**
     * Acquire all model records
     * call NTC (No Try Catch) method
     *
     * @param integer $paginationPerPage
     *
     * @return Collection
     */
    public function acquireAll($paginationPerPage = 10)
    {
        $rtn = [];

        try {
            $rtn = $this->NTCacquireAll();
        } catch (\Error $e) {
            \Log::error($e->getMessage());
        }

        return $rtn;
    }

    /**
     * Acquire all model records
     * NTC (No Try Catch) method
     *
     * @return Collection
     */
    public function NTCacquireAll()
    {
        $rtn = $this->arrayToCollection([]);

        if (!empty($this->Model)) {
            $rtn = $this->Model::all();
        }

        return $rtn;
    }

    /**
     * Acquire the graph records by graph_date
     *
     * @return array $rtn
     */
    public function acquireCountByFilter(array $attributes)
    {
        $rtn = [];

        if ($attributes['graph_date'] == strtolower(\Globals::GRAPH_WEEK)) {
            $rtn = $this->acquireByGraphWeek($attributes['graph_date']);
        } else if ($attributes['graph_date'] == strtolower(\Globals::GRAPH_MONTH)) {
            $rtn = $this->acquireByGraphMonth($attributes['graph_date']);
        } else {
            $rtn = $this->acquireByGraphYear($attributes['graph_date']);
        }

        return $rtn;
    }

    /**
     * Acquire the graph records by year
     *
     * @param String $graph_date
     *
     * @return array $rtn
     */
    public function acquireByGraphYear(String $graph_date)
    {
        $rtn = [];
        $year = $graph_date;

        $counts = $this->Model::select(\DB::raw('MONTH(created_at) as month'), \DB::raw('COUNT(*) as count'))
                    ->whereYear('created_at', $year)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();

        // Initialize the results array with 0 count for each month
        for ($i = 1; $i <= 12; $i++) {
            $month = DateTime::createFromFormat('!m', $i)->format('F');
            $rtn[$month] = 0;
        }

        // Populate the results array with the counts
        foreach ($counts as $count) {
            $month = DateTime::createFromFormat('!m', $count->month)->format('F');
            $rtn[$month] = $count->count;
        }

        return $rtn;
    }

    /**
     * Acquire graph monthly
     *
     * @param String $graph_date
     *
     * @return array $rtn
     */
    public function acquireByGraphMonth(String $graph_date)
    {
        $rtn = [];
        $year = date('Y');
        $month = $graph_date;

        $firstDayOfMonth = new DateTime("{$year}-{$month}-01");
        $daysInMonth = $firstDayOfMonth->format('t');

        $counts = $this->Model::select(\DB::raw('DAY(created_at) as day'), \DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Initialize the results array with 0 count for each day
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $rtn["Day $i"] = 0;
        }

        // Populate the results array with the counts
        foreach ($counts as $count) {
            $day = $count->day;
            $rtn["Day $day"] = $count->count;
        }

        return $rtn;
    }

    /**
     * Acquire the graph records by week
     *
     * @return array $rtn
     */
    public function acquireByGraphWeek()
    {
        $rtn = [];
        $year = date('Y');

        $counts = $this->Model::select(\DB::raw('DAYOFWEEK(created_at) as dayOfWeek'), \DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->where('created_at', '>=', \DB::raw('CURDATE() - INTERVAL 1 WEEK')) // Filter data for the last week
            ->groupBy('dayOfWeek')
            ->orderBy('dayOfWeek')
            ->get();

        // Initialize the results array with 0 count for each day of the week
        for ($i = 1; $i <= 7; $i++) {
            $dayOfWeek = date('l', strtotime("Sunday +{$i} days"));
            $rtn[$dayOfWeek] = 0;
        }

        // Populate the results array with the counts
        foreach ($counts as $count) {
            $dayOfWeek = date('l', strtotime("Sunday +{$count->dayOfWeek} days"));
            $rtn[$dayOfWeek] = $count->count;
        }

        return $rtn;
    }

    /**
     * Acquire model count
     *
     * @return Integer $rtn
     */
    public function acquireCount()
    {
        $rtn = 0;
        $rtn = $this->Model::whereNotDeleted()->count();
        return $rtn;
    }

    /**
     * Acquire a model record
     * call NTC (No Try Catch) method
     *
     * @param Int $id
     * @return Model
     */
    public function acquire($id)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCacquire($id);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        }

        if (empty($rtn)) {
            $rtn = $this->Model::empty();
        }

        return $rtn;
    }

    /**
     * Acquire a model record
     * NTC (No Try Catch) method
     *
     * @param Int $id
     * @return Model
     */
    public function NTCacquire($id)
    {
        $rtn = false;

        if (!empty($this->Model) && !empty($id)) {
            $rtn = $this->Model::find($id);
        }

        if (empty($rtn)) {
            $rtn = $this->Model::empty();
        }

        return $rtn;
    }

    /**
     * Acquire a list of records base on attributes given
     * call NTC (No Try Catch) method
     *
     * @param Array $attributes
     * @param Bool $returnCollection - either return by BuildQuery or Collection
     *
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
            \Log::error('Exception: ' . $e->getMessage());
        }

        return $rtn;
    }

    /**
     * Acquire a list of records base on attributes given
     * NTC (No Try Catch) method
     *
     * @param Array $attributes
     * @param Bool $returnCollection - either return by BuildQuery or Collection
     *
     * @return BuildQuery|Collection
     */
    public function NTCacquireByAttributes(array $attributes, bool $returnCollection = true)
    {
        if ($returnCollection) {
            $rtn = $this->arrayToCollection([]);
        } else {
            $rtn = $this->Model::query();
        }

        if (!empty($this->Model) && count($attributes) != 0) {
            $rtn = $this->Model::where(function ($query) use ($attributes) {
                foreach ($attributes as $key => $value) {
                    if (is_array($value)) {
                        if (is_numeric($key)) {
                            if ($key == 0) {
                                $query->where(function ($query) use ($value) {
                                    foreach ($value as $key2 => $value2) {
                                        $query->where($key2, $value2);
                                    }

                                    return $query;
                                });
                            } else {
                                $query->orWhere(function ($query) use ($value) {
                                    foreach ($value as $key2 => $value2) {
                                        $query->where($key2, $value2);
                                    }

                                    return $query;
                                });
                            }
                        } else {
                            $query->whereIn($key, $value);
                        }
                    } else {
                        $query->where($key, $value);
                    }
                }

                return $query;
            });

            if ($returnCollection) {
                $rtn = $rtn->get();
            }
        }

        return $rtn;
    }

    /**
     * Add a model record
     * call NTC (No Try Catch) method
     *
     * @param Array $attributes
     * @return Bool/Model
     */
    public function add(array $attributes)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCadd($attributes);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        }

        return $rtn;
    }

    /**
     * Add a model record
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
     * Add bulk records
     * call NTC (No Try Catch) method
     *
     * @param Array $attributesArray
     * @return Bool/Model
     */
    public function addBulk(array $attributesArray)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCaddBulk($attributesArray);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        }
        return $rtn;
    }

    /**
     * Add bulk records
     * NTC (No Try Catch) method
     *
     * @param Array $attributesArray
     * @return bool $rtn
     */
    public function NTCaddBulk(array $attributesArray)
    {
        $rtn = $this->arrayToCollection([]);

        if (!empty($this->Model) && count($attributesArray) != 0) {
            $rtn = $this->Model::inserting($attributesArray);
        }

        return $rtn;
    }

    /**
     * Adjust a model record
     * call NTC (No Try Catch) method
     *
     * @param Int $id
     * @param Array $attributes
     *
     * @return Bool
     */
    public function adjust(int $id, array $attributes)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCadjust($id, $attributes);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        }

        return $rtn;
    }

    /**
     * Adjust a model record
     * NTC (No Try Catch) method
     *
     * @param Int $id
     * @param Array $attributes
     *
     * @return Bool\Model $rtn
     */
    public function NTCadjust(int $id, array $attributes)
    {
        $rtn = false;

        if (!empty($this->Model) && count($attributes) != 0) {
            $model = $this->NTCacquire($id);

            $saveModel = $model->toArray();
            if (!$model->isEmpty) {
                $model->update($attributes);
            }

            if ($model->refresh()) {
                $rtn = $model;
            }
        }

        return $rtn;
    }

    /**
     * Adjust a list of records base on attributes given
     * call NTC (No Try Catch) method
     *
     * @param Array $whereAttributes
     * @param Array $adjustAttributes
     * @return Bool
     */
    public function adjustByAttributes(array $whereAttributes, array $adjustAttributes)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCadjustByAttributes($whereAttributes, $adjustAttributes);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        }

        return $rtn;
    }

    /**
     * Adjust a list of records base on attributes given
     * NTC (No Try Catch) method
     *
     * @param Array $whereAttributes
     * @param Array $adjustAttributes
     * @return Bool
     */
    public function NTCadjustByAttributes(array $whereAttributes, array $adjustAttributes)
    {
        $rtn = false;

        if (!empty($this->Model) && count($whereAttributes) != 0 && count($adjustAttributes) != 0) {
            $rtn = $this->Model::where(function ($query) use ($whereAttributes, $adjustAttributes) {
                foreach ($whereAttributes as $key => $value) {
                    if (is_array($value)) {
                        $query->whereIn($key, $value);
                    } else {
                        $query->where($key, $value);
                    }
                }

                return $query;
            })->update($adjustAttributes);

            if ($rtn === 0) {
                $rtn = true;
            }
        }

        return $rtn;
    }

    /**
     * Annul a model record
     * call NTC (No Try Catch) method
     *
     * @param Int $id
     *
     * @return Bool
     */
    public function annul(int $id)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCannul($id);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        }

        return $rtn;
    }

    /**
     * Annul a model record/s
     * NTC (No Try Catch) method
     *
     * @param Int $id
     *
     * @return Bool
     */
    public function NTCannul(int $id)
    {
        $rtn = false;

        if (!empty($this->Model)) {
            $rtn = $this->NTCadjust($id, [
                'deleted_at' => Carbon::now()
            ]);
        }

        return $rtn;
    }

    /**
     * Annul model record/s
     * call NTC (No Try Catch) method
     *
     * @param array $ids
     *
     * @return Bool
     */
    public function annulMany(array $ids)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCannulMany($ids);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        }

        return $rtn;
    }

    /**
     * Annul a model record/s
     * NTC (No Try Catch) method
     *
     * @param array $ids
     * @return Bool
     */
    public function NTCannulMany(array $ids)
    {
        $rtn = false;

        if (!empty($this->Model)) {
            $rtn = $this->Model::whereIn('id', $ids)->update([
                'deleted_at' => Carbon::now()
            ]);
        }

        return $rtn;
    }
}
