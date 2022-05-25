<?php

namespace App\Http\Controllers\Admin;
use App\Contact;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index()
    {
        $rows = Contact::latest();


        $rows = $rows->paginate(20);

        return view('admin.contact.index', compact('rows'));
    }


    public function create(Contact $model)
    {
        return view('admin.contact.create', compact('model'));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'job' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
        ]);


        $row = Contact::create($request->all());
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The contact item  :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/contact');
    }



    public function edit($id)
    {
        $model = Contact::findOrFail($id);
        return view('admin.contact.edit', compact('model'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'job' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
        ]);
        $row = Contact::findOrFail($id);
        $row->update($request->all());

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The contact item  :subject.name updated');

        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/contact');
    }


    public function destroy($id)
    {
        $row = Contact::findOrFail($id);


        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The contact item  :subject.name deleted');

        toastr()->success(trans('main.delete_done_successfully'));
        return back();
    }
}
