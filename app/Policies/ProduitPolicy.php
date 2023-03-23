<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Produit;
use App\Enums\PermissionType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProduitPolicy
{
    use HandlesAuthorization;

    public function update(User $user , Produit $produit){
        return $user->hasPermissionTo(PermissionType::EDITALLPRODUIT) || $user->id === $produit->user_id ;
    }
    public function delete(User $user, Produit $produit){
        return $user->hasPermissionTo(PermissionType::DELETEALLPRODUIT) || $user->id === $produit->user_id ;
    }
}
