<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'starts_at', 'ends_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function plan() {
        return $this->belongsTo(Plan::class);
    }
     public function uploads()
    {
        return $this->user
            ->uploads()
            ->whereBetween('created_at', [$this->starts_at, $this->ends_at]);
    }

    // 👇 How many uploads allowed total
    public function totalLimit(): int
    {
        return $this->plan->limit ?? 0;
    }

    // 👇 How many uploads made during subscription period
    public function usedUploads(): int
    {
        return $this->uploads()->count();
    }

    // 👇 How many uploads left
    public function remainingQuota(): int
    {
        return max(0, $this->totalLimit() - $this->usedUploads());
    }

    // 👇 Can the user upload more?
    public function canUpload(): bool
    {
        return $this->remainingQuota() > 0;
    }
}
