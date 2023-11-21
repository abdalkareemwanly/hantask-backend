<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'showUsers' , 'addUser' , 'editUser' , 'archiveUser' , 'showArchivedUser' , 'restoreUser', 'deleteUser' ,
            'showCategories' , 'addCategory' , 'editCategory' , 'changeStatusCategory' , 'deleteCategory',
            'showSubCategories' , 'addSubCategory' , 'editSubCategory' , 'changeStatusSubCategory' , 'deleteSubCategory',
            'showChildCategories' , 'addChildCategory' , 'editChildCategory' , 'changeStatusChildCategory' , 'deleteChildCategory',
            'showCountries' , 'addCountry' , 'editCountry' , 'downloadExcelTemplate' , 'uploadExcelTemplate' , 'deleteCountry',
            'showCities' , 'addCity' , 'editCity' , 'downloadExcelTemplate' , 'uploadExcelTemplate' , 'deleteCity',
            'showAreas' , 'addArea' , 'editArea' , 'downloadExcelTemplate' , 'uploadExcelTemplate' , 'deleteArea',
            'showTaxes' , 'addTax' , 'editTax' , 'deleteTax',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
