<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
	    $customers = Customer::all();

	    $customers->each(function (Customer $customer) {
		    Ticket::factory()
			    ->count(rand(1, 3))
			    ->for($customer)
			    ->create();
	    });
    }
}
