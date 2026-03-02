<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    /**
     * @return Model
     */
    public function acquireAll();

    /**
     * @return Model
     */
    public function acquireCountByFilter(array $attributes);

    /**
     * @param Null/Int $id
     * @return Model
     */
    public function acquire($id);

    /**
     * @param Array $attributes
     * @return Bool/Model
     */
    public function add(array $attributes);

    /**
     * @param Int $id
     * @param Array $attributes
     * @return Bool/Model
     */
    public function adjust(int $id, array $attributes);

    /**
     * @param Int $id
     * @return Bool
     */
    public function annul(int $id);
}
