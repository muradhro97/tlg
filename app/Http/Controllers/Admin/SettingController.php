<?php

namespace App\Http\Controllers\Admin;

use App\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    //

    public function __construct()
    {

        $this->middleware('permission:saveSettings', ['only' => ['view', 'save']]);



    }
    public function view()
    {
        //

        $model = $settings = Setting::findOrNew(1);

        return view('admin.setting.view', compact('model'));
    }

    public function save(Request $request)
    {
        $rules = [

            'name' => 'required|max:20',
            'phone' => 'required',
            'address' => 'required',



        ];

        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpg,jpeg,bmp,png';

        }
        $this->validate($request, $rules);

//        $row = Setting::updateOrCreate(['id' => 1], ['id' => 1,'aboutus' => $request->aboutus, 'rules' => $request->rules]); // ? obj : null

        $row = Setting::find(1);
        if ($row) {
            $row->name = $request->name;
            $row->phone = $request->phone;
            $row->address = $request->address;

            $row->image = $request->image;
            $row->save();
        } else {
            $row = new Setting();
            $row->id = 1;
            $row->name = $request->name;
            $row->phone = $request->phone;
            $row->address = $request->address;

            $row->image = $request->image;
            $row->save();
        }

        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('settings updated');
        toastr()->success(trans('main.save_done_successfully'));

        return redirect('admin/setting');

    }


}
