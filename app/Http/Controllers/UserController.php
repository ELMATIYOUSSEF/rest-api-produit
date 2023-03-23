<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangeRoleRequest;
use App\Enums\PermissionType;
use Exception;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        //testing logs
        try{

            Log::alert('request for users');
            $users = User::all();
            throw new Exception('users Error');
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'Error',
                'message' => 'Error is occurred',
            ]);
        }
        return response()->json([
            'status' => 'success',
            'length' => count($users),
            'data' => $users,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
               'status' => 'error',
               'message' => 'user not found',
            ], 404);
        }

        if(Auth::user()->cannot(PermissionType::EDITALLProfil) && Auth::user()->id != $user->id){
            return response()->json([
                'status' => 'success',
                'message' => 'user does not have the right permissions'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'user not found',
            ], 404);
        }

        if(Auth::user()->cannot(PermissionType::EDITALLProfil) && Auth::user()->id != $user->id){
            return response()->json([
                'status' => 'success',
                'message' => 'user does not have the right permissions'
            ], 403);
        }

        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully update user information\'s',
            'data' => $user,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update_password(Request $request,  int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'no user found',
            ]);
        }

        if(Auth::user()->cannot(PermissionType::EDITALLProfil) && Auth::user()->id != $user->id){
            return response()->json([
                'status' => 'success',
                'message' => 'user does not have the right permissions'
            ], 403);
        }

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully update password',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'incorrect old password',
            ], 406);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'user not found',
            ], 404);
        }

        if(Auth::user()->cannot(PermissionType::DELETEALLProfil) && Auth::user()->id != $user->id){
            return response()->json([
                'status' => 'success',
                'message' => 'user does not have the right permissions'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully delete user',
            'data' => $user,
        ]);
    }

    public function changeRole(ChangeRoleRequest $request,User $user){

        $user->syncRoles($request->validated());

        return response()->json([
            'status' => true,
            'message' => "UserRoles updated successfully!",
            'data' => $user
        ], 200);
    }
}
