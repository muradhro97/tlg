<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $rows = Size::latest();


        $rows = $rows->paginate(20);

        return view('admin.size.index', compact('rows'));
    }

    public function create(Size $model)
    {
        return view('admin.size.create', compact('model'));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'size' => 'required|unique:sizes,size',
        ]);


        $row = Size::create($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The size item  :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/size');
    }



    public function edit($id)
    {
        $model = Size::findOrFail($id);
        return view('admin.size.edit', compact('model'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'size' => 'required|unique:sizes,size,' . $id,
        ]);

        $row = Size::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The size item  :subject.name updated');

        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/size');
    }


    public function destroy($id)
    {
        $row = size::findOrFail($id);


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The size item  :subject.name deleted');

        toastr()->success(trans('main.delete_done_successfully'));
        return back();
    }
}
