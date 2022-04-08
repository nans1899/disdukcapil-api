<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RolesResource;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Repositories\RoleRepository;


class RoleController extends Controller
{
    protected $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        list($code, $data) = $this->repository->getData();
        return ($code == 200) ? RolesResource::collection($data) : response()->json($data, $code);
    }

    public function detail($id)
    {
        list($code,$data) = $this->repository->getData($id);
        return ($code == 200) ? new RolesResource($data) : response()->json($data, $code);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|max:50|unique:roles,name',
        ]);

        list($code, $data) = $this->repository->saveData($request);

        if ($code === 200) {
            return response()->json($data, $code);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'          => 'required|max:50|unique:roles,name',
        ]);

        list($code, $data) = $this->repository->saveData($request, $id);

        if ($code === 200) {
            return ($code == 200) ? new RolesResource($data) : response()->json($data, $code);
        }
    }

    public function destroy($id)
    {
        list($code, $data) = $this->repository->deleteData($id);

        if ($code == 200) {
            return [200, 'message' => 'User berhasil dihapus!'];
        }
    }
}
