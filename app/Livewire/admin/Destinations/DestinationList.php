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
    | View Modal
    |--------------------------------------------------------------------------
    */

    public bool $showViewModal = false;

    public array $selectedDestination = [];

    /*
    |--------------------------------------------------------------------------
    | Reset Pagination
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
    | View Destination
    |--------------------------------------------------------------------------
    */

    public function view(int $destinationId): void
    {
        $destination = Destination::with([
            'category',
            'images',
        ])->find($destinationId);

        if (!$destination) {
            session()->flash(
                'error',
                'Destination not found.'
            );

            return;
        }

        $images = $destination->images
            ->map(function ($image) {
                return [
                    'image_url' => $image->image_url,
                    'is_primary' => (bool) $image->is_primary,
                ];
            })
            ->values()
            ->toArray();

        $primaryImage = $destination->images
            ->firstWhere('is_primary', true);

        if (!$primaryImage) {
            $primaryImage = $destination->images->first();
        }

        $this->selectedDestination = [
            'destination_id' => $destination->destination_id,
            'title' => $destination->title,
            'slug' => $destination->slug,
            'description' => $destination->description,
            'things_to_do' => $destination->things_to_do,
            'things_to_prepare' => $destination->things_to_prepare,
            'address' => $destination->address,
            'latitude' => $destination->latitude,
            'longitude' => $destination->longitude,
            'map_link' => $destination->map_link,
            'ticket_price' => $destination->ticket_price,
            'status' => $destination->status,
            'open_time' => $destination->open_time,
            'close_time' => $destination->close_time,

            'category' => $destination->category
                ? $destination->category->name
                : null,

            'primary_image' => $primaryImage
                ? $primaryImage->image_url
                : null,

            'images' => $images,
        ];

        $this->showViewModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Close View Modal
    |--------------------------------------------------------------------------
    */

    public function closeViewModal(): void
    {
        $this->showViewModal = false;
        $this->selectedDestination = [];
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

        $destination->delete();

        session()->flash(
            'success',
            'Destination deleted successfully.'
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

        $totalDestinations = Destination::count();

        $activeDestinations = Destination::where(
            'status',
            'active'
        )->count();

        $inactiveDestinations = Destination::where(
            'status',
            'hidden'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Category Count
        |--------------------------------------------------------------------------
        */

        $categoryCount = Category::count();

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

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'livewire.admin.destinations.destination-list',
            [
                'destinations' => $destinations,
                'categories' => $categories,

                'totalDestinations' => $totalDestinations,
                'activeDestinations' => $activeDestinations,
                'inactiveDestinations' => $inactiveDestinations,
                'categoryCount' => $categoryCount,

                'hasActiveFilters' => $hasActiveFilters,
            ]
        );
    }
}