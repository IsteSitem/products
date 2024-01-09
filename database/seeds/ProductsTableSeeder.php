<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\Permission;
use IsteSitem\Products\Product;

class ProductsTableSeeder extends Seeder
{
    protected $module = 'products';

    public function run() {
        $this->createDataType();
        $this->createDataRows();
        $this->createPermissions();
        $this->definePermissions();
        $this->createRecords();
    }

    public function createDataType() {
        $dataType = DataType::firstOrNew(['slug' => $this->module]);

        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => $this->module,
                'display_name_singular' => __('products.singular_name'),
                'display_name_plural'   => __('products.plural_name'),
                'icon'                  => 'voyager-file-text',
                'model_name'            => 'IsteSitem\\Products\\Product',
                'policy_name'           => null,
                'controller'            => '\\IsteSitem\\Products\\Http\\Controllers\\ProductController',
                'generate_permissions'  => 1,
                'server_side'           => 1,
                'details'               => [
                    'order_column'         => 'created_at',
                    'order_display_column' => 'order',
                    'order_direction'      => 'desc',
                    'default_search_key'   => 'title',
                    'scope'                => null,
                ],
            ])->save();
        }

        if ($dataType->exists) {
            $dataType->update([
                'model_name' => 'IsteSitem\\Products\\Product',
                'controller' => '\\IsteSitem\\Products\\Http\\Controllers\\ProductController',
            ]);
        }
    }

    public function createDataRows() {
        $rows = [
            'id' => [
                'type'         => 'number',
                'display_name' => __('products.fields.id'),
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
            ],
            'category_id' => [
                'type'         => 'select_dropdown',
                'display_name' => __('products.fields.category_id'),
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 0,
                'details'      => [
                    'options' => [
                        '' => __('products.fields.category_select'),
                    ],
                    'relationship' => [
                        'key'   => 'id',
                        'label' => 'title',
                    ],
                    'validation' => [
                        'rule' => 'required',
                    ],
                ]
            ],
            'title' => [
                'type'         => 'text',
                'display_name' => __('products.fields.title'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'validation'  => [
                        'rule' => 'required',
                    ],
                ],
            ],
            'slug' => [
                'type'         => 'hidden',
                'display_name' => __('products.fields.slug'),
                'required'     => 1,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'slugify' => [
                        'origin' => 'title',
                    ],
                    'validation' => [
                        'rule'  => 'unique:products,slug',
                    ],
                ],
            ],
            'excerpt' => [
                'type'         => 'text_area',
                'display_name' => __('products.fields.excerpt'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'rows'       => '3',
                    'validation' => [
                        'rule' => 'max:180',
                    ],
                ],
            ],
            'content' => [
                'type'         => 'rich_text_box',
                'display_name' => __('products.fields.content'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
            ],
            'image' => [
                'type'         => 'image',
                'display_name' => __('products.fields.image'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
            ],
            'meta_description' => [
                'type'         => 'text_area',
                'display_name' => __('products.fields.meta_description'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'legend' => [
                        'text'  => __('products.fields.meta_legend'),
                        'align' => 'left',
                    ],
                ],
            ],
            'meta_keywords' => [
                'type'         => 'text_area',
                'display_name' => __('products.fields.meta_keywords'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
            ],
            'order' => [
                'type'         => 'number',
                'display_name' => __('products.fields.order'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'default' => 1,
                    'legend'  => [
                        'text'  => __('products.fields.order_legend'),
                        'align' => 'left',
                    ],
                ],
            ],
            'status' => [
                'type'         => 'checkbox',
                'display_name' => __('products.fields.status'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'details'      => [
                    'on'      => __('products.fields.status_on'),
                    'off'     => __('products.fields.status_off'),
                    'checked' => true,
                ],
            ],
            'author_id' => [
                'type'         => 'hidden',
                'display_name' => __('products.fields.author_id'),
                'required'     => 0,
                'browse'       => 0,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
            ],
            'created_at' => [
                'type'         => 'timestamp',
                'display_name' => __('products.fields.created_at'),
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
            ],
            'updated_at' => [
                'type'         => 'timestamp',
                'display_name' => __('products.fields.updated_at'),
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
            ],
        ];
    }

    public function createPermissions() {
        Permission::generateFor('products');
    }

    public function definePermissions()
    {
        $role = Role::where('name', 'admin')->firstOrFail();

        $permissions = Permission::all();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );
    }

    public function createRecords()
    {
        $records = [
            [
                'author_id'        => '0',
                'category_id'      => '1',
                'title'            => 'My First Product',
                'excerpt'          => 'An example blog post',
                'content'          => '<p>Matey yardarm topmast broadside nipper weigh anchor jack quarterdeck crow\'s nest rigging. Topgallant lateen sail line avast me gun Pirate Round strike colors bilge rat take a caulk. Jack six pounders spanker doubloon clipper spirits case shot hang the jib boatswain red ensign.</p>' . "\n" . '<p>Hornswaggle spanker spyglass Yellow Jack mutiny Arr lugger poop deck keel take a caulk. Quarter fire ship run a shot across the bow sheet log draft scallywag gally port skysail. Lugsail gangway draft pink piracy bilge Buccaneer heave to landlubber or just lubber Pieces of Eight.</p>',
                'meta_description' => 'A test product',
                'meta_keywords'    => 'sample, product',
            ],
            [
                'author_id'        => '0',
                'category_id'      => '1',
                'title'            => 'My Second Product',
                'excerpt'          => 'An example blog post',
                'content'          => '<p>Matey yardarm topmast broadside nipper weigh anchor jack quarterdeck crow\'s nest rigging. Topgallant lateen sail line avast me gun Pirate Round strike colors bilge rat take a caulk. Jack six pounders spanker doubloon clipper spirits case shot hang the jib boatswain red ensign.</p>' . "\n" . '<p>Hornswaggle spanker spyglass Yellow Jack mutiny Arr lugger poop deck keel take a caulk. Quarter fire ship run a shot across the bow sheet log draft scallywag gally port skysail. Lugsail gangway draft pink piracy bilge Buccaneer heave to landlubber or just lubber Pieces of Eight.</p>',
                'meta_description' => 'A test product',
                'meta_keywords'    => 'sample, product',
            ],
            [
                'author_id'        => '0',
                'category_id'      => '1',
                'title'            => 'My Third Product',
                'excerpt'          => 'An example blog post',
                'content'          => '<p>Matey yardarm topmast broadside nipper weigh anchor jack quarterdeck crow\'s nest rigging. Topgallant lateen sail line avast me gun Pirate Round strike colors bilge rat take a caulk. Jack six pounders spanker doubloon clipper spirits case shot hang the jib boatswain red ensign.</p>' . "\n" . '<p>Hornswaggle spanker spyglass Yellow Jack mutiny Arr lugger poop deck keel take a caulk. Quarter fire ship run a shot across the bow sheet log draft scallywag gally port skysail. Lugsail gangway draft pink piracy bilge Buccaneer heave to landlubber or just lubber Pieces of Eight.</p>',
                'meta_description' => 'A test product',
                'meta_keywords'    => 'sample, product',
            ],
        ];

        foreach ($records as $record) {
            Product::firstOrCreate($record);
        }
    }

    public function createMenuItems() {
        Menu::firstOrCreate(['name' => 'admin']);

        $menu = Menu::where('name', 'admin')->firstOrFail();

        $menuItem = MenuItem::firstOrNew([
            'menu_id'    => $menu->id,
            'title'      => __('products.menu_title'),
            'url'        => null,
            'target'     => '_self',
            'icon_class' => 'voyager-file-text',
            'color'      => null,
            'parent_id'  => null,
            'order'      => 1,
            'route'      => 'voyager.products.index',
            'parameters' => null,
        ])->save();
    }
}
