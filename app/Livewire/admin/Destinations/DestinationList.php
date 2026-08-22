<?php

namespace App\Livewire\Admin\Destinations;

use App\Models\Category;
use App\Models\Destination;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

#[Layout('layouts.admin')]
class DestinationList extends Component
{
    use WithPagination;

    /*
    |--------------------------------------------------------------------------
    | Search & Filters
    |--------------------------------------------------------------------------
    */

    #[Url(as: 'search', except: '')]
    public string $search = '';

    #[Url(as: 'category', except: '')]
    public string $categoryFilter = '';

    #[Url(as: 'status', except: '')]
    public string $statusFilter = '';

    /*
    |--------------------------------------------------------------------------
    | Reset Pagination When Filters Change
    |--------------------------------------------------------------------------
    */

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
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
        $this->categoryFilter = '';
        $this->statusFilter = '';

        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Destination
    |--------------------------------------------------------------------------
    */

    public function delete(int $destinationId): void
    {
        $destination = Destination::find($destinationId);

        if (!$destination) {
            session()->flash(
                'error',
                'Destination not found.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Destination
        |--------------------------------------------------------------------------
        |
        | If your database has ON DELETE CASCADE configured,
        | related records will also be deleted automatically.
        |
        */

        $destination->delete();

        session()->flash(
            'success',
            'Destination deleted successfully.'
        );

        /*
        |--------------------------------------------------------------------------
        | Make sure current page still exists
        |--------------------------------------------------------------------------
        */

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

        $totalDestinations = Destination::count();

        $activeDestinations = Destination::where(
            'status',
            'active'
        )->count();

        $inactiveDestinations = Destination::where(
            'status',
            'inactive'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Destination Query
        |--------------------------------------------------------------------------
        */

        $destinations = Destination::with([
            'category',
            'images',
        ])
            ->when(
                trim($this->search) !== '',
                function ($query) {
                    $search = trim($this->search);

                    $query->where(function ($q) use ($search) {
                        $q->where(
                            'title',
                            'like',
                            '%' . $search . '%'
                        )
                            ->orWhere(
                                'address',
                                'like',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'description',
                                'like',
                                '%' . $search . '%'
                            );
                    });
                }
            )
            ->when(
                $this->categoryFilter !== '',
                function ($query) {
                    $query->where(
                        'category_id',
                        $this->categoryFilter
                    );
                }
            )
            ->when(
                $this->statusFilter !== '',
                function ($query) {
                    $query->where(
                        'status',
                        $this->statusFilter
                    );
                }
            )
            ->latest('destination_id')
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::orderBy('name')->get();

        /*
        |--------------------------------------------------------------------------
        | Active Filter Check
        |--------------------------------------------------------------------------
        */

        $hasActiveFilters =
            trim($this->search) !== ''
            || $this->categoryFilter !== ''
            || $this->statusFilter !== '';

        return view(
            'livewire.admin.destinations.destination-list',
            [
                'destinations' => $destinations,
                'categories' => $categories,
                'totalDestinations' => $totalDestinations,
                'activeDestinations' => $activeDestinations,
                'inactiveDestinations' => $inactiveDestinations,
                'hasActiveFilters' => $hasActiveFilters,
            ]
        );
    }
}