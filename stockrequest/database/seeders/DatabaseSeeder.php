<?php

namespace Database\Seeders;

use App\Models\Counter;
use App\Models\Department;
use App\Models\Location;
use App\Models\LocationHasProduct;
use App\Models\Product;
use App\Models\Role;
use App\Models\StockRequestHeader;
use App\Models\StockRequestLine;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Counter::factory(1)->create();
        Department::factory(10)->create();
        Location::factory(10)->create();
        Role::factory(10)->create();
        Unit::factory(10)->create();
        User::factory(10)->create();
        Product::factory(10)->create();
        StockRequestHeader::factory(10)->create();
        StockRequestLine::factory(10)->create();
    }
}
