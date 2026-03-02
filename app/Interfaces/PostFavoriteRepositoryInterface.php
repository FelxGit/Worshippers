<?php

namespace App\Interfaces;

interface PostFavoriteRepositoryInterface
{
    /**
     * @param Array $attributes
     * @return Bool/Model
     */
    public function add(array $attributes);

    /**
     * @param Int $id
     * @return Bool
     */
    public function annul(int $id);
}
