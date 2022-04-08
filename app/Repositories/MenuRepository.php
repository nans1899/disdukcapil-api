<?php

namespace App\Repositories;

use App\Models\Logs;
use App\Models\MenuRoles;
use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;


class MenuRepository
{
    public function getData(String $id = null)
    {
        $datas = Menus::with('roles')->orderBy('parent_id', 'ASC')->paginate(10);
        if ($id) {
            $data = Menus::with('roles')->whereId($id)->first();
            if (!$data) {
                return [404, 'Data tidak ditemukan!'];
            }
            return [200, $data];
        }

        return [200, $datas];
    }

    public function saveData(Request $request, $id = null)
    {
        DB::beginTransaction();
        try {
            $menu = null;
            if ($id) {
                # code...
                $menu = Menus::with('roles')->whereId($id)->firstOrFail();
                $menu->update([
                    'parent_id'     => $request->parent_id,
                    'site_id'       => $request->site_id,
                    'value'         => $request->value,
                    'name'          => $request->name,
                    'ref'           => $request->ref,
                    'url'           => $request->url,
                    'urlview'       => $request->urlview,
                    'no'            => $request->no,
                    'hide'          => $request->hide,
                    'icon'          => $request->icon,
                ]);

                $menu->roles->menus_id = $menu->id;
                $menu->roles->roles_id = $menu->roles()->sync($request->role);
                Logs::create([
                    'uuid'      => Uuid::uuid4(),
                    'username'  => Auth()->user()->name,
                    'activity'  => 'U',
                    'module'    => 'Menu Management',
                    'url'       => \Request::url(),
                    'from'      => 'Mobile',
                ]);

            } else {
                $menu = Menus::create([
                    'parent_id'     => $request->parent_id ,
                    'site_id'       => $request->site_id,
                    'value'         => $request->value,
                    'name'          => $request->name,
                    'ref'           => $request->ref,
                    'url'           => $request->url,
                    'urlview'       => $request->urlview,
                    'no'            => $request->no,
                    'hide'          => $request->hide,
                    'icon'          => $request->icon,
                ]);

                foreach ($request->role as $roles) {
                    MenuRoles::create([
                        'menus_id'  => $menu->id,
                        'roles_id'  => $roles
                    ]);
                }

                Logs::create([
                    'uuid'      => Uuid::uuid4(),
                    'username'  => Auth()->user()->name,
                    'activity'  => 'C',
                    'module'    => 'Menu Management',
                    'url'       => \Request::url(),
                    'from'      => 'Mobile',
                ]);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();
        return [200, $menu];
    }

    public function deleteData($id)
    {
        $menu = null;
        DB::beginTransaction();
        try {
            $menu = Menus::whereId($id)->firstOrFail();
            $menu->delete();

            Logs::create([
                'uuid'      => Uuid::uuid4(),
                'username'  => Auth()->user()->name,
                'activity'  => 'D',
                'module'    => 'Menu Management',
                'url'       => \Request::url(),
                'from'      => 'Mobile',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();


        return [200, $menu];
    }
}
