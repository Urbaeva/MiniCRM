<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
	use HasFactory;
	use InteractsWithMedia;

	protected $fillable = [
		'customer_id',
		'subject',
		'body',
		'status',
		'manager_responded_at',
	];

	protected $attributes = [
		'status' => 'new',
	];

	protected $casts = [
		'manager_responded_at' => 'datetime',
	];

	public function customer(): BelongsTo
	{
		return $this->belongsTo(Customer::class);
	}

	public function scopeCreatedLastDays(Builder $query, int $days): Builder
	{
		return $query->where('created_at', '>=', now()->subDays($days));
	}

	public function scopeByStatus(Builder $query, string $status): Builder
	{
		return $query->where('status', $status);
	}

	public function scopeFilterByEmail(QueryBuilder $query, string $email): Builder
	{
		return $query->whereHas('customer', fn(Builder $q) => $q->where('email',  'LIKE', '%' . $email . '%'));
	}

	public function scopeFilterByPhone(Builder $query, string $phone): Builder
	{
		return $query->whereHas('customer', fn (Builder $q) => $q->where('phone', 'LIKE', '%' . $phone . '%'));
	}

}
