<?php

namespace App\Repositories;

use App\Models\Accounts;
use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserRepository
{

    public function getData(String $id = null)
    {
        $datas = Accounts::with('roles')->orderBy('role_id', 'asc')->paginate(10);
        if ($id) {
            $data = Accounts::with('roles')->whereId($id)->first();
            if (!$data) {
                return [404, [
                    'message' => 'Data tidak ditemukan'
                ]];
        }

            return [200, $data];
        }

        return [200, $datas];
    }

    public function saveData(Request $request, $id = null)
    {
        DB::beginTransaction();
        // testing
        try {
            $account = null;
            if ($id) {
                $account = Accounts::whereId($id)->firstOrFail();
                $account->update([
                    'name'                 => $request->name,
                    'email'                => $request->email,
                    'username'             => $request->username,
                    'password'             => Hash::make($request->password),
                    // 'foto'                 => $request->foto,
                    'whatsapp'             => $request->whatsapp,
                    'slack'                => $request->slack,
                    'role_id'              => $request->role_id,
                    // 'status'               => $data->status
                ]);
            }

            Logs::create([
                'uuid'      => Uuid::uuid4(),
                'username'  => Auth()->user()->name,
                'activity'  => 'U',
                'module'    => 'User Management',
                'url'       => \Request::url(),
                'from'      => 'Mobile',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return [200, $account];
    }

    public function storeData(Request $request)
    {
        DB::beginTransaction();

        try {
            $account = Accounts::create([
                'name'                 => $request->name,
                'email'                => $request->email,
                'username'             => $request->username,
                'password'             => Hash::make(123456),
                'whatsapp'             => $request->whatsapp,
                'slack'                => $request->slack,
                'role_id'              => $request->role_id,
                'status'               => 1
            ]);

            Logs::create([
                'uuid'      => Uuid::uuid4(),
                'username'  => Auth()->user()->name,
                'activity'  => 'C',
                'module'    => 'User Management',
                'url'       => \Request::url(),
                'from'      => 'Mobile',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return [200, $account];
    }

    public function deleteData($id)
    {
        $account = null;
        DB::beginTransaction();
        try {
            $account = Accounts::whereId($id)->firstOrFail();
            $account->delete();

            Logs::create([
                'uuid'      => Uuid::uuid4(),
                'username'  => Auth()->user()->name,
                'activity'  => 'D',
                'module'    => 'User Management',
                'url'       => \Request::url(),
                'from'      => 'Mobile',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return [200, $account];
    }
}
