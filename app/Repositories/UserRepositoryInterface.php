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

    /**
     * Make user available for taking reservations.
     *
     * @param int $userId
     * @return void
     */
    public function makeAvailable(int $userId): void;

    /**
     * Make user unavailable for taking reservations.
     *
     * @param int $userId
     * @return void
     */
    public function makeUnavailable(int $userId): void;
}
