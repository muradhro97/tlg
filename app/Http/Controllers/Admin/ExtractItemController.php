<?php

namespace App\Http\Controllers\Admin;

use App\ExtractItem;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;

class ExtractItemController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allExtractItem', ['only' => ['index']]);
        $this->middleware('permission:addExtractItem', ['only' => ['create', 'store']]);
//        $this->middleware('permission:editExtractItem', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:deleteExtractItem', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = ExtractItem::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.extract_item.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ExtractItem $model)
    {
//        return "asa";
        return view('admin.extract_item.create', compact('model'));
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
            'name' => 'required',
            'unit_id' => 'required|exists:units,id',
//            'details' => 'required',
//            'quantity' => 'required|numeric|min:0',


        ]);

//return  $images = $request->file('images');

        $row = ExtractItem::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The extract item  :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/extract-item');
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
        $model = ExtractItem::findOrFail($id);
        return view('admin.extract_item.edit', compact('model'));
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

            'unit_id' => 'required|exists:units,id',
//            'details' => 'required',
//            'quantity' => 'required|numeric|min:0',
            'name' => 'required',


        ]);

        $row = ExtractItem::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The extract item  :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/extract-item');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = ExtractItem::findOrFail($id);


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The extract item  :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
