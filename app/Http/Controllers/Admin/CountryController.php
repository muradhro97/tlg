<?php

namespace App\Http\Controllers\Admin;

use App\Country;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class CountryController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allCountry', ['only' => ['index']]);
        $this->middleware('permission:addCountry', ['only' => ['create', 'store']]);
        $this->middleware('permission:editCountry', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteCountry', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = Country::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.country.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Country $model)
    {
//        return "asa";
        return view('admin.country.create', compact('model'));
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
//            'user_name' => 'required|unique:users,user_name',
            'name' => 'required|unique:countries,name',
            'nationality' => 'required',


        ]);

//return  $images = $request->file('images');

        $row = Country::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The country  :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/country');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
//        $row = Country::find($id);
//        $orderCount = $row->orders()->count();
//        $orders = $row->orders()->paginate(10);
//        $transactions = $row->transactions()->take(10)->get();
//        return view('admin.country.show', compact('row', 'orderCount', 'orders', 'transactions'));
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
        $model = Country::findOrFail($id);
        return view('admin.country.edit', compact('model'));
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
            'name' => 'required|unique:countries,name,' . $id,
            'nationality' => 'required',



        ]);

        $row = Country::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The country :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/country/' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Country::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The country  :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
