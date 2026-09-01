<?php

namespace App\Livewire\Admin\Destinations;

use App\Models\Destination;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class DestinationList extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $statusFilter = '';

    public $showViewModal = false;
    public $selectedDestination = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->statusFilter = '';
        $this->resetPage();
    }

    public function openViewModal($id)
    {
        $this->selectedDestination = Destination::with(['category', 'images'])->find($id);
        $this->showViewModal = true;
    }

    public function deleteDestination($id)
    {
        $destination = Destination::find($id);

        if ($destination) {
            $destination->delete();
            session()->flash('success', 'Destination deleted successfully.');
        } else {
            session()->flash('error', 'Destination not found.');
        }
    }

    public function render()
    {
        $query = Destination::with(['category', 'images']);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->categoryFilter)) {
            $query->where('category_id', $this->categoryFilter);
        }

        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        $destinations = $query->latest()->paginate(10);

        $totalDestinations = Destination::count();
        $activeDestinations = Destination::where('status', 'active')->count();
        $inactiveDestinations = Destination::where('status', 'hidden')->count();
        $categoryCount = Category::count();
        $categories = Category::all();

        $hasActiveFilters = !empty($this->search) || !empty($this->categoryFilter) || !empty($this->statusFilter);

        return view('livewire.admin.destinations.destination-list', [
            'destinations' => $destinations,
            'totalDestinations' => $totalDestinations,
            'activeDestinations' => $activeDestinations,
            'inactiveDestinations' => $inactiveDestinations,
            'categoryCount' => $categoryCount,
            'categories' => $categories,
            'hasActiveFilters' => $hasActiveFilters,
        ]);
    }
}
