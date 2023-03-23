<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filterByName($request){

        $produit = Produit::with('category')
        ->whereHas('category', function ($query) use ($request) {
            $query->where('name', 'like', "%$request%");
        })->get();

        if (!$produit) {
            return response()->json(['message' => 'produit not found'], 404);
        }
        if ($produit) {
            return response()->json([
                'data' => $produit
            ]);
        }

    }

    public function searchByCategory(Request $request)
    {
        $query = Produit::query();
    
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        $produit = $query->get();
    
        return response()->json([
            'data' => $produit
        ]);
    }
}
