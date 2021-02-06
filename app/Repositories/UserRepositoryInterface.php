<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get all users.
     *
     * @return User[]
     */
    public function all(): array;

    /**
     * Get all currently available users.
     *
     * @return Collection
     */
    public function available(): Collection;
}
