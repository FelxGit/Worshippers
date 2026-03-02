<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    /**
     * @return Model
     */
    public function acquireAll();

    /**
     * @param Null/Int $id
     * @return Model
     */
    public function acquire($id);

    /**
     * @param array $attributes
     * @param bool $returnCollection
     * @return Model\Collection
     */
    public function acquireByAttributes(array $attributes, bool $returnCollection);

    /**
     *
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
