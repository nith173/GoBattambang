<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class UserList extends Component
{
    public function render()
    {
        $users = User::orderBy('user_id')->get();

        return view(
            'livewire.admin.users.user-list',
            [
                'users' => $users,
            ]
        );
    }
}