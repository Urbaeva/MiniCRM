<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;

class CustomerService
{
	public function __construct(
		private readonly CustomerRepository $customerRepository
	) {}

	public function findOrCreate(string $name, ?string $phone, ?string $email): Customer
	{
		if ($email) {
			$customer = $this->customerRepository->findByEmail($email);
			if ($customer) {
				return $customer;
			}
		}

		if ($phone) {
			$customer = $this->customerRepository->findByPhone($phone);
			if ($customer) {
				return $customer;
			}
		}

		return $this->customerRepository->firstOrCreate(
			array_filter([
				'email' => $email,
				'phone' => $phone,
			]),
			[
				'name' => $name,
				'phone' => $phone,
				'email' => $email,
			]
		);
	}

}