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
            'allAdmin' , 'profileAdmin' , 'updateProfileAdmin' , 'updatePasswordAdmin' , 'storeAdmin',
            'home' , 'showRoles' , 'addRole' , 'showRole' , 'Permission' , 'updateRole' , 'deleteRole',
            'showUsers' , 'addUser' , 'editUser' , 'archiveUser' , 'showArchivedUser' , 'restoreUser', 'deleteUser' ,
            'showCategories' , 'addCategory' , 'editCategory' , 'changeStatusCategory' , 'deleteCategory',
            'showSubCategories' , 'addSubCategory' , 'editSubCategory' , 'changeStatusSubCategory' , 'deleteSubCategory',
            'showChildCategories' , 'addChildCategory' , 'editChildCategory' , 'changeStatusChildCategory' , 'deleteChildCategory',
            'showCountries' , 'addCountry' , 'editCountry' , 'downloadCountryExcelTemplate' , 'uploadCountryExcelTemplate' , 'deleteCountry',
            'showCities' , 'addCity' , 'editCity' , 'downloadCityExcelTemplate' , 'uploadCityExcelTemplate' , 'deleteCity',
            'showAreas' , 'addArea' , 'editArea' , 'downloadAreaExcelTemplate' , 'uploadAreaExcelTemplate' , 'deleteArea',
            'showTaxes' , 'addTax' , 'editTax' , 'deleteTax',
            'showServices' , 'addService' , 'updateService' , 'changeStatusService' ,'deleteSerivce',
            'showSubscriptions' , 'storeSubscription' , 'changeStatusSubscription' , 'updateSubscription' , 'deleteSubscription',
            'showSubscriptionCoupons' , 'storeCoupon' , 'changeStatusCoupon' , 'updateCoupon' , 'deleteCoupon',
            'showSellers' , 'addSeller' , 'editSeller' , 'archiveSeller' , 'showArchivedSeller' , 'restoreSeller', 'deleteSeller' ,
            'showPosts' , 'changeStatusPost' , 'deletePost',
            'showLanguages' , 'addLanguage' , 'updateLanguage' , 'defaultLanguage' , 'deleteLanguage',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
