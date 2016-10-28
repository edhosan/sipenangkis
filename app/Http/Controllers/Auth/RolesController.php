<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Permissions;
use DB;

class RolesController extends Controller
{
  public function store(Request $request)
  {
    $role = new Role();
    $role->name = $request->input('name');
    $role->display_name = $request->input('display_name');
    $role->description = $request->input('description');
    $role->save();


    foreach($request->input('hak_akses') as $key => $value ){
      $role->permissions()->attach($value);
    }

    return response()->json(array('data' => 'success'));
  }

  public function index(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Role::orderBy($sortCol, $sortDir);
    }else{
      $query = Role::orderBy('id', 'asc');
    }

    if($request->exists('filter')){
      $query->where(function($q) use($request){
        $value = "%{$request->filter}%";
        $q->where('name', 'like', $value)
          ->orWhere('display_name','like',$value);
      });
    }

    $perPage = $request->has('per_page') ? (int) $request->per_page : null;
    $page = $request->has('page') ? (int) $request->page : 1;

    $result = $query->get()->toArray();
    $offset = ($page * $perPage) - $perPage;
    $itemCurrentPage = array_slice($result, $offset, $perPage, true);
    $result = new LengthAwarePaginator($itemCurrentPage, count($result), $perPage, $page);
    $result = $result->toArray();

    return $result;
  }

  public function update(Request $request, $id)
  {
    $role = Role::find($id);
    $role->name = $request->input('name');
    $role->display_name = $request->input('display_name');
    $role->description = $request->input('description');
    $role->update();

    DB::table('permissions_role')->where("permissions_role.role_id",$id)->delete();

    foreach($request->input('hak_akses') as $key => $value ){
      $role->permissions()->attach($value);
    }

    return response()->json($role);
  }

  public function delete($id)
  {
    $role = Role::find($id);

    return response()->json($role->delete());
  }

  public function edit($id)
  {
    $role = Role::find($id);
    $permissions = $role->permissions()->get(['id','display_name']);
    $list = $permissions->map(
      function($permission){
          return[
            'value' => $permission->id,
            'label' => $permission->display_name
          ];
      }
    );

    return $list;
  }

  public function getAllRoles()
  {
    $role = Role::all(['id','display_name']);
    $list = $role->map(
      function($role){
          return[
            'value' => $role->id,
            'label' => $role->display_name
          ];
      }
    );

    return $list;
  }
}
