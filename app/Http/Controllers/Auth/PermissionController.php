<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Permissions;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class PermissionController extends Controller
{
  public function store(Request $request)
  {
    $permission = new Permissions();
    $permission->name = $request->input('name');
    $permission->display_name = $request->input('display_name');
    $permission->description = $request->input('description');
    $permission->save();

    return response()->json(array('data' => 'success' ));
  }

  public function index(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Permissions::orderBy($sortCol, $sortDir);
    }else{
      $query = Permissions::orderBy('id', 'asc');
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
    $permission = Permissions::find($id);
    $permission->name = $request->input('name');
    $permission->display_name = $request->input('display_name');
    $permission->description = $request->input('description');
    $permission->update();

    return response()->json($permission);
  }

  public function delete($id)
  {
    $permission = Permissions::find($id);
    return response()->json($permission->delete());
  }

  public function getAllPermission()
  {
    $permissions = Permissions::all(['id','display_name']);
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
}
