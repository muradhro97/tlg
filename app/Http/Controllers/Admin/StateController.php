<?php

namespace App\Http\Controllers\Admin;

use App\State;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class StateController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allState', ['only' => ['index']]);
        $this->middleware('permission:addState', ['only' => ['create', 'store']]);
        $this->middleware('permission:editState', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteState', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = State::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.state.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(State $model)
    {
//        return "asa";
        return view('admin.state.create', compact('model'));
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
            'country_id' =>  'required|exists:countries,id',
            'name' => 'required|unique:states,name',


        ]);

//return  $images = $request->file('images');

        $row = State::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The state :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/state');
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
        $model = State::findOrFail($id);
        return view('admin.state.edit', compact('model'));
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
            'country_id' =>  'required|exists:countries,id',
            'name' => 'required|unique:states,name,' . $id,



        ]);

        $row = State::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The state :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/state/' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = State::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The state :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
