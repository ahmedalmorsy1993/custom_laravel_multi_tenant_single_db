<?php

namespace App\Models;

use App\Concerns\BelongToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use BelongToTenant;

    protected $guarded = [];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
