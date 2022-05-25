<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Item;
use App\Item_quantity;
use App\Library\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allItem', ['only' => ['index']]);
        $this->middleware('permission:addItem', ['only' => ['create', 'store']]);
        $this->middleware('permission:editItem', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteItem', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = Item::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");
        }

        $rows = $rows->paginate(20);

        return view('admin.item.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Item $model)
    {
//        return "asa";
        return view('admin.item.create', compact('model'));
    }


    public function store(Request $request)
    {
        //
//        dd(array_column($request->item,'size'));

        $this->validate($request, [
//            'user_name' => 'required|unique:users,user_name',
            'name' => 'required|unique:items,name',
            'unit_id' => 'required|exists:units,id',
            'type' => 'required',
        ]);
        foreach ($request->item as $item)
        {
            $validator = Validator::make($item, [
                'color' =>  'required|exists:colors,id',
                'size' =>  'required|exists:sizes,id',
                'quantity' => 'required|numeric|min:0',
            ]);
            if ($validator->fails())
            {
                return back()->withErrors($validator->errors());
            }
        }

//return  $images = $request->file('images');

        $row = Item::create($request->all());
        $row->colors()->sync(array_column($request->item,'color'));
        $row->sizes()->sync(array_column($request->item,'size'));

        // save item quantities
        foreach ($request->item as $item)
        {
            $check = Item_quantity::where([
                'color_id'  =>  $item['color'],
                'size_id'  => $item['size'],
                'item_id'   =>  $row->id
            ])->first();
            if (is_null($check))
            {
                $item_quantity = Item_quantity::create([
                    'color_id'  =>  $item['color'],
                    'size_id'  => $item['size'],
                    'quantity'  =>  $item['quantity'],
                    'item_id'   =>  $row->id
                ]);
            }

        }

//        $client->roles()->sync($request->input('role'));
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The item :subject.name created');
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/item');
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
        $model = Item::findOrFail($id);
        return view('admin.item.edit', compact('model'));
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

            'name' => 'required|unique:items,name,' . $id,
            'unit_id' => 'required|exists:units,id',
            'type' => 'required',
        ]);
        foreach ($request->item as $item)
        {
            $validator = Validator::make($item, [
                'color' =>  'required|exists:colors,id',
                'size' =>  'required|exists:sizes,id',
                'quantity' => 'required|numeric|min:0',
            ]);
            if ($validator->fails())
            {
                return back()->withErrors($validator->errors());
            }
        }

        $row = Item::findOrFail($id);
        $row->update($request->all());
        $row->colors()->sync(array_column($request->item,'color'));
        $row->sizes()->sync(array_column($request->item,'size'));

        foreach ($row->item_quantities as $quantity)
        {
            $quantity->delete();
        }
        // save item quantities
        foreach ($request->item as $item)
        {
            $check = Item_quantity::where([
                'color_id'  =>  $item['color'],
                'size_id'  => $item['size'],
                'item_id'   =>  $row->id
            ])->first();
            if (is_null($check))
            {
                $item_quantity = Item_quantity::create([
                    'color_id'  =>  $item['color'],
                    'size_id'  => $item['size'],
                    'quantity'  =>  $item['quantity'],
                    'item_id'   =>  $row->id
                ]);
            }

        }
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The item :subject.name updated');
//        $client->roles()->sync($request->role);
        toastr()->success(trans('main.save_done_successfully'));
        return redirect('admin/item');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Item::findOrFail($id);

        $row->colors()->detach();
        $row->sizes()->detach();
        foreach ($row->item_quantities as $quantity)
        {
            $quantity->delete();
        }

        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The item :subject.name deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }

    public function sizes(Item $item)
    {
        $sizes = $item->sizes->pluck('size', 'id')->toArray();
        return Field::select('size_id' , false,$sizes,trans('main.select_size'));
    }

    public function colors(Item $item)
    {
        $sizes = $item->colors->pluck('color', 'id')->toArray();
        return Field::select('color_id' , false,$sizes,trans('main.select_color'));
    }

}
