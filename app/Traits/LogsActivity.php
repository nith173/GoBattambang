<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /*
    |--------------------------------------------------------------------------
    | Boot The Trait
    |--------------------------------------------------------------------------
    |
    | Hooks into created/updated/deleted model events and automatically
    | writes an entry to audit_logs. Attach this trait to any Eloquent
    | model you want tracked (e.g. Destination, User, Category).
    |
    | Optional: define a $auditExclude array on the model to skip
    | certain columns from being logged (e.g. ['updated_at']).
    |
    */

    public static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            $model->writeAuditLog('created', $model->getFilteredAttributesForAudit());
        });

        static::updated(function ($model) {
            $changes = $model->getChangedAttributesForAudit();

            if (!empty($changes)) {
                $model->writeAuditLog('updated', $changes);
            }
        });

        static::deleted(function ($model) {
            $model->writeAuditLog('deleted', null);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Get Filtered Attributes (for created event)
    |--------------------------------------------------------------------------
    */

    private function getFilteredAttributesForAudit(): array
    {
        $excluded = property_exists($this, 'auditExclude')
            ? $this->auditExclude
            : [];

        $excluded = array_merge($excluded, ['updated_at', 'created_at']);

        return array_diff_key(
            $this->getAttributes(),
            array_flip($excluded)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Get Changed Attributes (old => new)
    |--------------------------------------------------------------------------
    */

    private function getChangedAttributesForAudit(): array
    {
        $excluded = property_exists($this, 'auditExclude')
            ? $this->auditExclude
            : [];

        $excluded = array_merge($excluded, ['updated_at', 'created_at']);

        $changes = [];

        foreach ($this->getChanges() as $key => $newValue) {
            if (in_array($key, $excluded, true)) {
                continue;
            }

            $changes[$key] = [
                'old' => $this->getOriginal($key),
                'new' => $newValue,
            ];
        }

        return $changes;
    }

    /*
    |--------------------------------------------------------------------------
    | Write Audit Log Entry
    |--------------------------------------------------------------------------
    */

    private function writeAuditLog(string $action, ?array $changes): void
    {
        $primaryKey = $this->getKeyName();

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => class_basename($this),
            'model_id' => $this->getAttribute($primaryKey) ?? 0,
            'changes' => $changes,
        ]);
    }
}