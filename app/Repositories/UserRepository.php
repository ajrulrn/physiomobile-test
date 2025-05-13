<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create($data)
    {
        return User::create($data);
    }

    public function update($id, $data)
    {
        User::find($id)->update($data);
    }

    public function delete($id)
    {
        User::destroy($id);
    }
}