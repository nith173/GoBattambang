<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

#[Layout('layouts.admin')]
class UserList extends Component
{
    use WithPagination;

    /*
    |--------------------------------------------------------------------------
    | Search & Filters
    |--------------------------------------------------------------------------
    */

    #[Url(as: 'search', except: '')]
    public string $search = '';

    #[Url(as: 'role', except: '')]
    public string $roleFilter = '';

    #[Url(as: 'status', except: '')]
    public string $statusFilter = '';

    /*
    |--------------------------------------------------------------------------
    | View Modal
    |--------------------------------------------------------------------------
    */

    public bool $showViewModal = false;

    public array $selectedUser = [];

    /*
    |--------------------------------------------------------------------------
    | Reset Pagination
    |--------------------------------------------------------------------------
    */

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedRoleFilter(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Clear Filters
    |--------------------------------------------------------------------------
    */

    public function clearFilters(): void
    {
        $this->search = '';
        $this->roleFilter = '';
        $this->statusFilter = '';

        $this->resetPage();
    }

    /**
     * --------------------------------------------------------------------------
     * View User
     * --------------------------------------------------------------------------
     */
    public function view(int $userId): void
    {
        $user = User::find($userId);

        if (!$user) {
            session()->flash(
                'error',
                'User not found.'
            );

            return;
        }

        /*
     * Store selected user.
     */
        $this->selectedUser = [
            'user_id' => $user->user_id,

            'first_name' => $user->first_name,

            'last_name' => $user->last_name,

            'email' => $user->email,

            'phone_number' => $user->phone_number,

            'profile_picture' => $user->profile_picture,

            'role' => $user->role,

            'account_status' => $user->account_status,

            'created_at' => $user->created_at,
        ];

        $this->showViewModal = true;
    }

    /**
     * --------------------------------------------------------------------------
     * Close View Modal
     * --------------------------------------------------------------------------
     */
    public function closeViewModal(): void
    {
        $this->showViewModal = false;

        $this->selectedUser = [];
    }

    /*
    |--------------------------------------------------------------------------
    | Delete User
    |--------------------------------------------------------------------------
    */

    public function delete(int $userId): void
    {
        $user = User::find($userId);

        if (!$user) {
            session()->flash(
                'error',
                'User not found.'
            );

            return;
        }

        /*
     * Prevent an admin from deleting their own account
     * from this screen.
     */
        if (Auth::id() === $user->user_id) {
            session()->flash(
                'error',
                'You cannot delete your own account.'
            );

            return;
        }

        $user->delete();

        session()->flash(
            'success',
            'User deleted successfully.'
        );

        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $activeUsers = User::where(
            'account_status',
            'active'
        )->count();

        $suspendedUsers = User::where(
            'account_status',
            'suspended'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Admin Count
        |--------------------------------------------------------------------------
        */

        $adminCount = User::where(
            'role',
            'admin'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | User Query
        |--------------------------------------------------------------------------
        */

        $users = User::query()
            ->when(
                trim($this->search) !== '',
                function ($query) {
                    $search = trim($this->search);

                    $query->where(function ($q) use ($search) {
                        $q->where(
                            'first_name',
                            'like',
                            '%' . $search . '%'
                        )
                            ->orWhere(
                                'last_name',
                                'like',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'email',
                                'like',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'phone_number',
                                'like',
                                '%' . $search . '%'
                            );
                    });
                }
            )
            ->when(
                $this->roleFilter !== '',
                function ($query) {
                    $query->where(
                        'role',
                        $this->roleFilter
                    );
                }
            )
            ->when(
                $this->statusFilter !== '',
                function ($query) {
                    $query->where(
                        'account_status',
                        $this->statusFilter
                    );
                }
            )
            ->latest('user_id')
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | Active Filter Check
        |--------------------------------------------------------------------------
        */

        $hasActiveFilters =
            trim($this->search) !== ''
            || $this->roleFilter !== ''
            || $this->statusFilter !== '';

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'livewire.admin.users.user-list',
            [
                'users' => $users,

                'totalUsers' => $totalUsers,
                'activeUsers' => $activeUsers,
                'suspendedUsers' => $suspendedUsers,
                'adminCount' => $adminCount,

                'hasActiveFilters' => $hasActiveFilters,
            ]
        );
    }
}