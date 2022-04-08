<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Accounts;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        list($code, $data) = $this->repository->getData();
        return ($code == 200) ? UserResource::collection($data) : response()->json($data, $code);
    }

    public function detail($id)
    {
        list($code, $data) = $this->repository->getData($id);
        return ($code == 200) ? new UserResource($data) : response()->json($data, $code);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|max:50',
            'email'         => 'required|email|max:45',
            'username'      => 'required',
            'role_id'       => 'required',
        ]);
        list($code, $data) = $this->repository->storeData($request);

        return response()->json($data, $code);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'          => 'required|max:50',
            'email'         => 'required|email|max:45',
            'username'      => 'required',
            'role_id'       => 'required',
        ]);
        list($code, $data) = $this->repository->saveData($request, $id);

        return ($code == 200) ? new UserResource($data) : response()->json($data, $code);
    }

    public function destroy(Request $request, $id)
    {
        list($code, $data) = $this->repository->deleteData($id);
        if ($code == 200) {
            # code...
            return response()->json([200, 'message' => 'User berhasil dihapus!']);
        }
        return response()->json(['code' => 400, 'message' => 'User berhasil dihapus!']);


        // return response()->json(404, ['message' => 'No Content!']);
    }

    // public function storeuser(Request $request)
    // {
    //     DB::beginTransaction()
    //     $account = Accounts::create([
    //         'name'                 => $request->name,
    //         'email'                => $request->email,
    //         'username'             => $request->username,
    //         'password'             => Hash::make(123456),
    //         'whatsapp'             => $request->whatsapp,
    //         'slack'                => $request->slack,
    //         'role_id'              => $request->role_id,
    //         'status'               => 1
    //     ]);

    //     return response()->json([
    //         'success'   => true,
    //         'data'      => $account
    //     ], 200);
    // }
}
