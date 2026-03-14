<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
{
	public function findByPhone(string $phone): ?Customer
	{
		return Customer::query()->where('phone', $phone)->first();
	}

	public function findByEmail(string $email): ?Customer
	{
		return Customer::query()->where('email', $email)->first();
	}

	public function firstOrCreate(array $attributes, array $values = []): Customer
	{
		return Customer::query()->firstOrCreate($attributes, $values);
	}
}
