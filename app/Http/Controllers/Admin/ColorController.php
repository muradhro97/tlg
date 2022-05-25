<?php

namespace App\Http\Controllers\admin;

use App\Color;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    public function index()
    {
        $rows = Color::latest();


        $rows = $rows->paginate(20);

        return view('admin.color.index', compact('rows'));
    }

    public function create(Color $model)
    {
        return view('admin.color.create', compact('model'));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'color' => 'required|unique:colors,color',
        ]);


        $row = Color::create($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The color item  :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/color');
    }



    public function edit($id)
    {
        $model = Color::findOrFail($id);
        return view('admin.color.edit', compact('model'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'color' => 'required|unique:colors,color,'.$id,
        ]);
        $row = Color::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The color item  :subject.name updated');

        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/color');
    }


    public function destroy($id)
    {
        $row = Color::findOrFail($id);


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The color item  :subject.name deleted');

        toastr()->success(trans('main.delete_done_successfully'));
        return back();
    }
}
