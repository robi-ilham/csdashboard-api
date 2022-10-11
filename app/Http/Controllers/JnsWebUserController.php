<?php

namespace App\Http\Controllers;

use App\Models\JnsWebUser;
use Illuminate\Http\Request;

class JnsWebUserController extends Controller
{
    public function index(Request $request)
    {
        // $users= JnsWebUser::with('group')->paginate(5);
        $search = [];
        if (empty($request)) {
            // echo 'ok';
            $users = JnsWebUser::paginate(10);
        } else {
            if (!empty($request->username)) {
                $filter = ['username', 'like', '%' . $request->username . '%'];
                array_push($search, $filter);
            }
            if (!empty($request->group_id)) {
                $filter = ['group_id', '=', $request->group_id];
                array_push($search, $filter);
            }
            if (!empty($request->client_id)) {
                $filter = ['client_id', '=', $request->client_id];
                array_push($search, $filter);
            }
            if (!empty($request->division_id)) {
                $filter = ['division_id', '=', $request->division_id];
                array_push($search, $filter);
            }
            //return $search;
            $users = JnsWebUser::where($search)->paginate(10);
        }
        return response()->json($users, 200);
    }
    public function indexAjax(Request $request)
    {
        // $users= JnsWebUser::with('group')->paginate(5);
        $search = [];
        if (empty($request)) {
            // echo 'ok';
            $users = JnsWebUser::paginate(10);
        } else {
            if (!empty($request->username)) {
                $filter = ['username', 'like', '%' . $request->username . '%'];
                array_push($search, $filter);
            }
            if (!empty($request->group_id)) {
                $filter = ['group_id', '=', $request->group_id];
                array_push($search, $filter);
            }
            if (!empty($request->client_id)) {
                $filter = ['client_id', '=', $request->client_id];
                array_push($search, $filter);
            }
            if (!empty($request->division_id)) {
                $filter = ['division_id', '=', $request->division_id];
                array_push($search, $filter);
            }
            //return $search;
            $users = JnsWebUser::where($search)->paginate(10);
        }
        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|confirmed|min:8',
            'name' => 'required',
        ]);

        $user = JnsWebUser::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => sha1($request->password),
            'email' => $request->email,
            'status' => 1,
            'expiry_mode_id' => $request->expiry_mode_id,
            'expiry' => $request->expiry,
            'group_id' => $request->group_id,
            'client_id' => $request->client_id,
            'division_id' => $request->division_id,
            'use_sha256' => 0
        ]);

        return response()->json($user);
    }
    public function show($id)
    {
        $division = JnsWebUser::find($id);
        return response()->json($division, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string',
            'name' => 'required',
        ]);

        $user = JnsWebUser::findOrFail($id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'email' => $request->email,
            'status' => 1,
            'expiry_mode_id' => $request->expiry_mode_id,
            'expiry' => $request->expiry,
            'group_id' => $request->group_id,
            'client_id' => $request->client_id,
            'division_id' => $request->division_id,
            'use_sha256' => 0
        ]);

        return response()->json($user);
    }

    public function destroy($user)
    {
        $user = JnsWebUser::findOrFail($user);
        $user->delete();
        return response()->json(['message' => 'data successfully deleted', 200]);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:8',
            'password' => 'required|confirmed|min:8',
        ]);
        $user = JnsWebUser::where([
            ['id', '=', $request->id],
            ['password', '=', $this->encryptPassword($request->old_password)]
        ]);
        if ($user->get()) {
            $user->update(['password' => $this->encryptPassword($request->password)]);
            return response()->json($user);
        }else{
            return response()->json(['message'=>'user not found'],200);
        }
    }
    private function encryptPassword($password)
    {
        return sha1($password);
    }
}
