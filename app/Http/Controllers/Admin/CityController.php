<?php

namespace App\Http\Controllers\Admin;

use App\City;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CityController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allCity', ['only' => ['index']]);
        $this->middleware('permission:addCity', ['only' => ['create', 'store']]);
        $this->middleware('permission:editCity', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteCity', ['only' => ['destroy']]);


    }

    public function index(Request $request)
    {
        //
//      return  explode('\\', __CLASS__);
        $rows = City::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.city.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(City $model)
    {
//        return "asa";
        return view('admin.city.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        return $request->all();

        $this->validate($request, [
            'state_id' => 'required|exists:states,id',
            'name' => 'required|unique:cities,name',


        ]);

//return  $images = $request->file('images');

        $row = City::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The city :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/city');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $model = City::findOrFail($id);

        return view('admin.city.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $this->validate($request, [
//            'user_name' => 'required|unique:users,user_name,' . $id,
//            'phone' => 'required|unique:clients,phone',
            'state_id' => 'required|exists:states,id',
            'name' => 'required|unique:cities,name,' . $id,


        ]);

        $row = City::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The city :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/city/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = City::findOrFail($id);


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The city :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
