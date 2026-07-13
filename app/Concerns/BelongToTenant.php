<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongToTenant
{
    public static function bootBelongToTenant(): void
    {
        static::creating(function (Model $model): void {
            if (auth()->check() && empty($model->tenant_id)) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });

        // qualifyColumn this method will prefix the table name to the column its better for checking the tenant_id column in case of joins with other tables that have a tenant_id column for example if we have a posts table and a comments table both have a tenant_id column and we want to get the posts with their comments for the current tenant we can use the qualifyColumn method to avoid ambiguity in the query like posts.tenant_id and comments.tenant_id

        static::addGlobalScope('tenant', function (Builder $builder): void {
            if (auth()->check()) {
                $builder->where(
                    $builder->getModel()->qualifyColumn('tenant_id'),
                    auth()->user()->tenant_id,
                );
            }
        });
    }
}
