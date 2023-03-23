<?php

namespace App\Enums;

class PermissionType
{
    // declare all permission for Product 
    const EDITMYPRODUIT = 'edit my Produit';
    const EDITALLPRODUIT = 'edit all Produit';
    const DELETEMYPRODUIT = 'delete my Produit';
    const DELETEALLPRODUIT = 'delete all Produit';
    const VIEWPRODUIT = 'view Produit';
    const CREATEPRODUIT = 'create Produit';

    // declare all permission for Profil 
    const EDITMYProfil = 'edit my Profil';
    const EDITALLProfil = 'edit all Profil';
    const DELETEMYProfil = 'delete my Profil';
    const DELETEALLProfil = 'delete all Profil';
    const VIEWProfil = 'view Profil';
    const CREATEProfil = 'create Profil';

    // declare all permission for Category 
    const EDITCATEGORY = 'edit Category';
    const DELETECATEGORY = 'delete Category';
    const VIEWCATEGORY = 'view Category';
    const CREATECATEGORY = 'create Category';
   
}
