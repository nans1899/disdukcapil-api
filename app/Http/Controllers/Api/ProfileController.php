<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Accounts;
use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = Accounts::whereId(Auth()->user()->id)->first();

        if (!$user) {
            return response()->json([
                'message'   => 'No Content!',
            ], 204);
        }

        return response()->json([
            'status'    => true,
            'message'   => 'Data berhasil diambil!',
            'data'      => new UserResource($user)
        ], 200);

    }

    public function profile(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:100',
            'email'     => 'required|max:100',
            'username'  => 'required|max:100',
            'foto'      => 'mimes:jpg,png,jpeg|max:4096',
        ]);

        DB::beginTransaction();
        try {

            $user = Accounts::whereId(Auth()->user()->id)->first();

            if ($request->hasFile('foto')) {
                # code...
                Storage::disk('public')->delete('public/users/' . Auth()->user()->id . '/' . basename($user->foto));

                $foto = $request->file('foto');
                $foto->storeAs('public/users/' . Auth()->user()->id , $foto->hashName());
                $user->foto = $foto->hashName();
            }
            $user->update([
                'name'          => $request->name,
                'email'         => $request->email,
                'username'      => $request->username,
                'whatsapp'      => $request->whatsapp,
                'slack'         => $request->slack,
            ]);

            $user->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();
        return response()->json([
            'success'   => true,
            'message'   => 'Data User Berhasil diupdate!',
            'data'      => $user,
        ], 201);
    }

    public function changePhoto(Request $request)
    {
        # code...
        $this->validate($request, [
            'foto'      => 'mimes:jpg,png,jpeg|max:4096',
        ]);


        DB::beginTransaction();
        try {

            $user = Accounts::whereId(Auth()->user()->id)->first();

            if ($request->hasFile('foto')) {
                # code...
                Storage::disk('public')->delete('public/users/' . Auth()->user()->id . '/' . basename($user->foto));

                $foto = $request->file('foto');
                $foto->storeAs('public/users/' . Auth()->user()->id , $foto->hashName());
                $user->foto = $foto->hashName();
            }

            Logs::create([
                'uuid'      => Uuid::uuid4(),
                'username'  => Auth()->user()->name,
                'activity'  => 'Cp',
                'module'    => 'User Profile',
                'url'       => \Request::url(),
                'from'      => 'Mobile',
            ]);
            $user->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();
        return response()->json([
            'success'   => true,
            'message'   => 'Foto Profile Berhasil diubah!',
            'data'      => $user,
        ], 201);
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:100',
            'email'     => 'required|max:100',
            'username'  => 'required|max:100',
        ]);
        DB::beginTransaction();
        try {
            $user = Accounts::whereId(Auth()->user()->id)->first();
            $user->update([
                'name'                 => $request->name,
                'email'                => $request->email,
                'username'             => $request->username,
                'whatsapp'             => $request->whatsapp,
                'slack'                => $request->slack,
            ]);
            $user->save();
            Logs::create([
                'uuid'      => Uuid::uuid4(),
                'username'  => Auth()->user()->name,
                'activity'  => 'U',
                'module'    => 'User Profile',
                'url'       => \Request::url(),
                'from'      => 'Mobile',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        DB::commit();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Profile Berhasil diubah!',
            'data'      => $user,
        ], 201);
    }


    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password'              => 'required|min:6',
            'new_password'          => 'required|min:6',
            'confirm_password'      => 'required|min:6|required_with:confirm_password|same:confirm_password'
        ]);

        DB::beginTransaction();

        try {
            $pass = Hash::make($request->password);
            $data = Hash::check($request->password, auth()->user()->password);

            if (!$data) {
                # code...
                return response()->json([
                    'success'   => false,
                    'message'   => 'Password tidak sama!',
                ], 400);
            }

            if (strcmp($request->new_password, $request->confirm_password) != 0) {
                # code...
                return response()->json([
                    'success'   => false,
                    'message'   => 'Password baru dan konfirmasi password tidak sama!',
                ], 400);
            }

            if (strcmp($request->get('password'), $request->get('new_password')) == 0) {
                # code...
                return response()->json([
                    'success'   => false,
                    'message'   => 'Password tidak boleh sama!',
                ], 400);
            }

            //code...
            $user               = Auth::user();
            $user->password     = bcrypt($request->new_password);
            $user->save();

            Logs::create([
                'uuid'      => Uuid::uuid4(),
                'username'  => Auth()->user()->name,
                'activity'  => 'CP',
                'module'    => 'Change Password',
                'url'       => \Request::url(),
                'from'      => 'Website',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        DB::commit();
        return response()->json([
            'success'   => true,
            'message'   => 'Password berhasil diubah!',
        ], 200);
        // Alert::success('Password berhasil diubah!');
    }
}
