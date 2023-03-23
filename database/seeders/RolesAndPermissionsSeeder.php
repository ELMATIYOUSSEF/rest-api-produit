<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Enums\PermissionType;



class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        

        // create permissions for Product 
        Permission::create(['name' => PermissionType::VIEWPRODUIT]);
        Permission::create(['name' => PermissionType::CREATEPRODUIT]);
        Permission::create(['name' => PermissionType::DELETEALLPRODUIT]);
        Permission::create(['name' => PermissionType::DELETEMYPRODUIT]);
        Permission::create(['name' => PermissionType::EDITMYPRODUIT]);
        Permission::create(['name' => PermissionType::EDITALLPRODUIT]);

        // create permissions for Category 
        Permission::create(['name' =>  PermissionType::VIEWCATEGORY]);
        Permission::create(['name' =>  PermissionType::CREATECATEGORY]);
        Permission::create(['name' =>  PermissionType::DELETECATEGORY]);
        Permission::create(['name' =>  PermissionType::EDITCATEGORY]);

         // create permissions for Profile 
        Permission::create(['name' => PermissionType::VIEWProfil]);
        Permission::create(['name' => PermissionType::CREATEProfil]);
        Permission::create(['name' => PermissionType::DELETEALLProfil]);
        Permission::create(['name' => PermissionType::DELETEMYProfil]);
        Permission::create(['name' => PermissionType::EDITALLProfil]);
        Permission::create(['name' => PermissionType::EDITMYProfil]);

        // create roles and assign created permissions

        $role = Role::create(['name' => UserType::CLIENT]);
        $role->givePermissionTo([
            PermissionType::VIEWCATEGORY,
            PermissionType::VIEWPRODUIT,
            PermissionType::VIEWProfil,
            PermissionType::CREATEProfil,
            PermissionType::EDITMYProfil,
            PermissionType::DELETEMYProfil,
        ]);

        // or may be done by chaining
        $role = Role::create(['name' => UserType::SELLER])
            ->givePermissionTo([
                PermissionType::VIEWCATEGORY,
                PermissionType::VIEWPRODUIT,
                PermissionType::CREATEPRODUIT,
                PermissionType::EDITMYPRODUIT,
                PermissionType::DELETEMYPRODUIT,
                PermissionType::VIEWProfil,
                PermissionType::CREATEProfil,
                PermissionType::EDITMYProfil,
                PermissionType::DELETEMYProfil,
                ]);

        $role = Role::create(['name' => UserType::ADMIN]);
        $role->givePermissionTo(Permission::all());
    }
}
