<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Menus;
use App\Models\Roles;
use App\Repositories\MenuRepository;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MenuManagementController extends Controller
{
    //

    protected $repository;

    public function __construct(MenuRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        // $roles = Roles::get();
        list($code, $data) = $this->repository->getData();

        return ($code == 200) ?  MenuResource::collection($data) : response()->json($data, $code);
    }

    public function detail($id)
    {
        list($code,$data) = $this->repository->getData($id);
        return ($code == 200) ? new MenuResource($data) : response()->json($data, $code);

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'parent_id'  => 'required',
            'site_id'    => 'required',
            'value'      => 'required',
            'name'       => 'required',
            'ref'        => 'required',
            'url'        => 'required',
            'urlview'    => 'required',
            'no'         => 'required',
            'hide'       => 'required',
            'icon'       => 'max:45',
        ]);

        list($code, $data) = $this->repository->saveData($request);

        return response()->json($data, $code);
        // if ($code === 200) {
        // }
    }

    public function edit($id)
    {
        $menu   = Menus::with('roles')->whereId($id)->firstOrFail();
        $parent = Menus::select('id', 'name')->get();
        $roles  = Roles::get();

        return view('layouts.pages.menu.edit', compact('menu', 'parent', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'parent_id'  => 'required',
            'site_id'    => 'required',
            'value'      => 'required',
            'name'       => 'required',
            'ref'        => 'required',
            'url'        => 'required',
            'urlview'    => 'required',
            'no'         => 'required',
            'hide'       => 'required',
            'icon'       => 'max:45',
        ]);

        list($code, $data) = $this->repository->saveData($request, $id);


        if ($code === 200) {
            return ($code == 200) ? new MenuResource($data) : response()->json($data, $code);
        }
    }

    public function destroy($id)
    {
        list($code, $data) = $this->repository->deleteData($id);

        if ($code === 200) {
            return response()->json([200, 'Menu berhasil dihapus!']);

        }
    }
}
