<?php namespace App\Http\Controllers\Monitoring;

use Illuminate\Routing\Controller;
use App\Models\ProsesIntervensi;

class MonevIntervensiController extends Controller {

	/**
	 * Display a listing of the resource.
	 * GET /monitoring\monevintervensi
	 *
	 * @return Response
	 */
	public function index()
	{
		$query = ProsesIntervensi::get();

		$result = array();
		foreach ($query as $value) {
			$result['intervensi'] = $value;
			$result['penerima'] = $value->penerima()->get();
		}

		return response()->json($result);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /monitoring\monevintervensi/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /monitoring\monevintervensi
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /monitoring\monevintervensi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /monitoring\monevintervensi/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /monitoring\monevintervensi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /monitoring\monevintervensi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}