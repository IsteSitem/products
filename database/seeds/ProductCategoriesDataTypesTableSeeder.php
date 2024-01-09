<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;

class ProductCategoriesDataTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $dataType = $this->dataType('slug', 'product_categories');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'product_categories',
                'display_name_singular' => __('product_category.singular_name'),
                'display_name_plural'   => __('product_category.plural_name'),
                'icon'                  => 'voyager-categories',
                'model_name'            => 'IsteSitem\\Products\\ProductCategory',
                'controller'            => '\\TCG\\Voyager\\Http\\Controllers\\VoyagerBaseController',
                'controller'            => null,
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        if ($dataType->exists) {
            $dataType->update([
                'model_name' => 'IsteSitem\\Products\\ProductCategory',
                'controller' => '\\TCG\\Voyager\\Http\\Controllers\\VoyagerBaseController',
            ]);
        }
    }

    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }
}
