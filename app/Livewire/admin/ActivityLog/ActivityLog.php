<?php

namespace App\Livewire\Admin\ActivityLog;

use App\Models\AuditLog;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class ActivityLog extends Component
{
    use WithPagination;

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    public string $modelFilter = 'all';
    public string $actionFilter = 'all';
    public string $adminFilter = 'all';
    public string $dateFrom = '';
    public string $dateTo = '';

    /*
    |--------------------------------------------------------------------------
    | Details Popup
    |--------------------------------------------------------------------------
    */

    public bool $showDetailsPopup = false;
    public ?int $detailsLogId = null;

    /*
    |--------------------------------------------------------------------------
    | Reset Pagination On Filter Change
    |--------------------------------------------------------------------------
    */

    public function updatingModelFilter(): void
    {
        $this->resetPage();
    }

    public function updatingActionFilter(): void
    {
        $this->resetPage();
    }

    public function updatingAdminFilter(): void
    {
        $this->resetPage();
    }

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | View Details
    |--------------------------------------------------------------------------
    */

    public function viewDetails(int $logId): void
    {
        $this->detailsLogId = $logId;
        $this->showDetailsPopup = true;
    }

    public function closeDetailsPopup(): void
    {
        $this->showDetailsPopup = false;
        $this->detailsLogId = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Clear Filters
    |--------------------------------------------------------------------------
    */

    public function clearFilters(): void
    {
        $this->modelFilter = 'all';
        $this->actionFilter = 'all';
        $this->adminFilter = 'all';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $logs = AuditLog::query()
            ->with('user')
            ->when($this->modelFilter !== 'all', function ($query) {
                $query->where('model_type', $this->modelFilter);
            })
            ->when($this->actionFilter !== 'all', function ($query) {
                $query->where('action', $this->actionFilter);
            })
            ->when($this->adminFilter !== 'all', function ($query) {
                $query->where('user_id', $this->adminFilter);
            })
            ->when($this->dateFrom !== '', function ($query) {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo !== '', function ($query) {
                $query->whereDate('created_at', '<=', $this->dateTo);
            })
            ->orderByDesc('created_at')
            ->paginate(15);

        $detailsLog = $this->detailsLogId
            ? AuditLog::with('user')->find($this->detailsLogId)
            : null;

        $modelTypes = AuditLog::query()
            ->select('model_type')
            ->distinct()
            ->orderBy('model_type')
            ->pluck('model_type');

        $admins = \App\Models\User::query()
            ->whereIn('user_id', AuditLog::query()->whereNotNull('user_id')->distinct()->pluck('user_id'))
            ->get();

        return view('livewire.admin.activity-log.activity-log', [
            'logs' => $logs,
            'detailsLog' => $detailsLog,
            'modelTypes' => $modelTypes,
            'admins' => $admins,
        ]);
    }
}