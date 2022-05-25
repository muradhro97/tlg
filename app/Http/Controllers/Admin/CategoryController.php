<?php

namespace App\Http\Controllers\Admin;

use App\Category;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;




class CategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allCategory', ['only' => ['index']]);
        $this->middleware('permission:addCategory', ['only' => ['create', 'store']]);
        $this->middleware('permission:editCategory', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteCategory', ['only' => ['destroy']]);


    }

    public function index(Request $request)
    {
        //
//        $aa= Category::find(1);
//        dd($aa->main);
        $rows = Category::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }
        if ($request->filled('main_category')) {
            $rows->where('main_category',  $request->main_category);


        }

        $rows = $rows->paginate(20);

        return view('admin.category.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $model)
    {
//        return "asa";
        return view('admin.category.create', compact('model'));
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
            'main_category' => 'required',
            'name' => 'required|unique:categories,name',


        ]);

//return  $images = $request->file('images');

        $row = Category::create($request->all());
//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The category  :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/category');
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
        $model = Category::findOrFail($id);
        return view('admin.category.edit', compact('model'));
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
            'main_category' => 'required',
            'name' => 'required|unique:categories,name,' . $id,



        ]);

        $row = Category::findOrFail($id);
        $row->update($request->all());
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The category  :subject.name updated');

//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/category/' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Category::findOrFail($id);



        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The category  :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }


}
