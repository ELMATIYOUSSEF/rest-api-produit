<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Produit;
use GuzzleHttp\Psr7\Message;
use App\Enums\PermissionType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produit = Produit::orderBy('id')->get();

        return response()->json([
            'status' => 'success',
            'produit' => $produit
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProduitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduitRequest $request,User $user)
    {
        // $user =Auth::user();
        $produit = $user->produits()->create($request->all());  
      

      return response()->json([
          'status' => true,
          'message' => "produit Created successfully!",
          'produit' => $produit
      ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        //  $produit->find($produit->id);
        if (!$produit) {
            return response()->json(['message' => 'Produit not found'], 404);
        }
        return response()->json($produit, 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProduitRequest  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduitRequest $request, Produit $produit)
    {
        // $user = Auth::user();
        $this->authorize('update' , $produit);

        // if(!$user->can(PermissionType::EDITALLPRODUIT) && $produit->user_id != $user->id){
        //     return response()->json([
        //         'status' => false,
        //         'message' => "You don't have the permission for edit this Product!"
        //     ], 200);
        // }

        // if (!$produit) {
        //     return response()->json(['message' => 'Product not found'], 404);
        // }

        try {
            $produit->update($request->all());
            return response()->json([
                'status' => true,
                'message' => "Product Updated successfully!",
                'Product' => $produit
            ], 200);
        } catch (Exception $th) {
            Log::error($th->getMessage());
            return response()->json([
                'status'=> false,
                'message'=>'Erorr'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        // $user = Auth::user();
        $this->authorize('delete' , $produit);

        // if(!$user->can(PermissionType::DELETEALLPRODUIT) && $produit->user_id != $user->id){
        //     return response()->json([
        //         'status' => false,
        //         'message' => "You don't have the permission for delete this produit!"
        //     ], 200);
        // }

        // if (!$produit) {
        //     return response()->json(['message' => 'produit not found'], 404);
        // };
        try {
            $produit->delete();
             return response()->json([
            'status' => true,
            'message' => 'produit deleted successfully'
        ], 200);
        } catch (Exception $th) {
            Log::error($th->getMessage());
            return response()->json([
                'status'=> false,
                'message'=>'Erorr'
            ],404);
        }
       
    }
}
