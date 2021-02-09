<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get all users.
     *
     * @return User[]
     */
    public function all(): array
    {
        return User::all();
    }

    /**
     * Get all currently available users.
     *
     * @return Collection
     */
    public function available(): Collection
    {
        return User::where('is_available', True)->get();
    }

    /**
     * Get user by id.
     *
     * @param $userId
     * @return User
     */
    public function find($userId): User
    {
        return User::where('id', $userId)->first();
    }

    /**
     * Get reservations assigned for the given user.
     *
     * @param $userId
     * @return Collection
     */
    public function reservations($userId): Collection
    {
        return User::where('id', $userId)->first()->reservations;
    }

    /**
     * Make user available for taking reservations.
     *
     * @param int $userId
     * @return void
     */
    public function makeAvailable(int $userId): void
    {
        $user = User::where('id', $userId)->first();
        if ($user->is_available === False) {
            $user->is_available = True;
            $user->save();
        }
    }

    /**
     * Make user unavailable for taking reservations.
     *
     * @param int $userId
     * @return void
     */
    public function makeUnavailable(int $userId): void
    {
        $user = User::where('id', $userId)->first();
        if ($user->is_available === True) {
            $user->is_available = False;
            $user->save();
        }
    }
}
