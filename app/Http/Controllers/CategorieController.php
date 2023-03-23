<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $categorie = Categorie::orderBy('id')->get();

        return response()->json([
            'status' => 'success',
            'categorie' => $categorie
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategorieRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategorieRequest $request)
    {
        
        $categorie =Categorie::create($request->all());  
      

      return response()->json([
          'status' => true,
          'message' => "categorie Created successfully!",
          'categorie' => $categorie
      ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categorie $categorie)
    {
        $categorie->find($categorie->id);
        if (!$categorie) {
            return response()->json([
                'status' => false,
                'message' => 'categorie not found' 
            ], 404);
        }
        return response()->json(
           ['status' => true,
            $categorie], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategorieRequest  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategorieRequest $request, Categorie $categorie)
    {
        if (!$categorie) {
            return response()->json(['message' => 'categorie not found'], 404);
        }

        $categorie->update($request->all());

        return response()->json([
            'status' => true,
            'message' => "categorie Updated successfully!",
            'categorie' => $categorie
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {

        if (!$categorie) {
            return response()->json([
                'message' => 'categorie not found'
            ], 404);
        }

        $categorie->delete();

        return response()->json([
            'status' => true,
            'message' => 'categorie deleted successfully'
        ], 200);
    }
}
