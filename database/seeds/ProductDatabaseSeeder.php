<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Traits\Seedable;

class ProductDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__ . '/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed('ProductsTableSeeder');
        $this->seed('ProductCategoriesDataTypesTableSeeder');
        $this->seed('ProductCategoriesTableSeeder');
    }
}
