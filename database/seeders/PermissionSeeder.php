<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = $this->initialPermissions();

        for($i = 0; $i < count($permissions); $i++){
            Permission::updateOrCreate(['name' => $permissions[$i]["name"]],
                                        [
                                            "name"  => $permissions[$i]["name"]
                                        ]);
        }
    }
    protected function initialPermissions()
    {
        return [
            [
                'name' => 'User_List'
            ],
            [
                'name' => 'Category_List'
            ],
            [
                'name' => 'Product_List'
            ],
            [
                'name' => 'Sale_List'
            ],
            [
                'name' => 'Role_List'
            ],
            [
                'name' => 'Asignar_List'
            ],
            [
                'name' => 'Coin_List'
            ],
            [
                'name' => 'Cashout_List'
            ],
            [
                'name' => 'Report_List'
            ],
            [
                'name' => 'User_Create'
            ],
            [
                'name' => 'User_Search'
            ],
            [
                'name' => 'User_Update'
            ],
            [
                'name' => 'User_Destroy'
            ],
            [
                'name' => 'Role_Create'
            ],
            [
                'name' => 'Role_Search'
            ],
            [
                'name' => 'Role_Update'
            ],
            [
                'name' => 'Role_Destroy'
            ],
            [
                'name' => 'Product_Create'
            ],
            [
                'name' => 'Product_Search'
            ],
            [
                'name' => 'Product_Update'
            ],
            [
                'name' => 'Product_Destroy'
            ],
            [
                'name' => 'Permission_Create'
            ],
            [
                'name' => 'Permission_Search'
            ],
            [
                'name' => 'Permission_Update'
            ],
            [
                'name' => 'Permission_Destroy'
            ],
            [
                'name' => 'Coin_Create'
            ],
            [
                'name' => 'Coin_Update'
            ],
            [
                'name' => 'Coin_Destroy'
            ],
            [
                'name' => 'Category_Create'
            ],
            [
                'name' => 'Category_Search'
            ],
            [
                'name' => 'Category_Update'
            ],
            [
                'name' => 'Category_Destroy'
            ],
            [
                'name' => 'Asignar_Sync'
            ],
        ];
    }

}
