<?php

namespace App\Repositories;

use App\Models\Logs;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Roles;
use Ramsey\Uuid\Uuid;

class RoleRepository
{
    public function getData(String $id = null)
    {
        $datas = Roles::paginate(10);

        if ($id) {
            $data = Roles::whereId($id)->first();
            if (!$data) {
                return[404, 'Data tidak ditemukan'];
            }

            return [200, $data];
        }

        return [200, $datas];
    }

    public function saveData(Request $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $role = null ;
            if ($id) {
                $role = Roles::whereId($id)->firstOrFail();
                $role->update([
                    'name'  => $request->name
                ]);
                Logs::create([
                    'uuid'      => Uuid::uuid4(),
                    'username'  => Auth()->user()->name,
                    'activity'  => 'U',
                    'module'    => 'Role Management',
                    'url'       => \Request::url(),
                    'from'      => 'Mobile',
                ]);
            } else {
                $role = Roles::create([
                    'name'  => $request->name
                ]);
                Logs::create([
                    'uuid'      => Uuid::uuid4(),
                    'username'  => Auth()->user()->name,
                    'activity'  => 'C',
                    'module'    => 'Role Management',
                    'url'       => \Request::url(),
                    'from'      => 'Mobile',
                ]);
            }

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();
        return[200, $role];
    }

    public function deleteData($id)
    {
        $role = null;
        DB::beginTransaction();
        try {
            $role = Roles::whereId($id)->firstOrFail();
            $role->delete();

            Logs::create([
                'uuid'      => Uuid::uuid4(),
                'username'  => Auth()->user()->name,
                'activity'  => 'D',
                'module'    => 'Role Management',
                'url'       => \Request::url(),
                'from'      => 'Mobile',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();


        return [200, $role];
    }
}
