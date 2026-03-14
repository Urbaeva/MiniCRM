<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
	use HasFactory;

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
}
