<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Hash;
use DB;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
      try {
            $token = JWTAuth::attempt($request->only('userid', 'password'), [
                'exp' => Carbon::now()->addWeek()->timestamp,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not authenticate',
            ], 500);
        }

        if (!$token) {
            return response()->json([
                'error' => 'Could not authenticate',
                'token' => $token
            ], 401);
        } else {
            $data = [];
            $meta = [];

            $data['user'] = $request->user();
            $meta['token'] = $token;

            return response()->json([
                'data' => $data,
                'meta' => $meta
            ])->header('Content-Type', 'application/json');
        }
    }

    public function index(Request $request)
    {
      if($request->has('sort')){
        list($sortCol, $sortDir) = explode('|', $request->sort);
        $query = User::with('roles')->with('stakeholder')->orderBy($sortCol, $sortDir);
      }else{
        $query = User::with('roles')->with('stakeholder')->orderBy('id', 'asc');
      }

      if($request->exists('filter')){
        $query->where(function($q) use($request){
          $value = "%{$request->filter}%";
          $q->where('name', 'like', $value)
            ->orWhere('userid','like',$value);
        });
      }

      $perPage = $request->has('per_page') ? (int) $request->per_page : null;
      $page = $request->has('page') ? (int) $request->page : 1;

      $result = $query->get()->toArray();
      $offset = ($page * $perPage) - $perPage;
      $itemCurrentPage = array_slice($result, $offset, $perPage, true);
      $result = new LengthAwarePaginator($itemCurrentPage, count($result), $perPage, $page);
      $result = $result->toArray();

      return response()->json($result)->header('Content-Type', 'application/json');
    }

    public function store(Request $request)
    {
      $user = new User();
      $user->name = $request->input('name');
      $user->userid = $request->input('userid');
      $user->password = Hash::make($request->input('password'));
      $user->m_stakeholder_id = $request->input('m_stakeholer_id');
      $user->save();

      foreach($request->input('tipe') as $key => $value ){
        $user->roles()->attach($value);
      }

      return response()->json(array('data' => 'success'));
    }

    public function edit($id)
    {
      $user = User::find($id);
      $roles = $user->roles()->get(['id','display_name']);
      $list = $roles->map(
        function($role){
            return[
              'value' => $role->id,
              'label' => $role->display_name
            ];
        }
      );

      return $list;
    }

    public function update(Request $request, $id)
    {
      $user = User::find($id);
      $user->name = $request->input('name');
      $user->userid = $request->input('userid');
      $user->password = Hash::make($request->input('password'));
      $user->m_stakeholder_id = $request->input('m_stakeholer_id');
      $user->update();

      DB::table('role_user')->where("role_user.user_id",$id)->delete();

      foreach($request->input('tipe') as $key => $value ){
        $user->roles()->attach($value);
      }

      return response()->json($user);
    }

    public function delete($id)
    {
      $user = User::find($id);

      return response()->json($user->delete());
    }
}
