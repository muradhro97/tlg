<?php

namespace App\Http\Controllers\Admin;

use App\Contract;


use App\Contract_file;
use App\ContractDetail;
use App\ContractItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class  ContractController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:allContract', ['only' => ['index']]);
        $this->middleware('permission:addContract', ['only' => ['create', 'store']]);
        $this->middleware('permission:editContract', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteContract', ['only' => ['destroy']]);


    }
    public function index(Request $request)
    {
        //
        $rows = Contract::latest();
        if ($request->filled('project_id')) {
            $rows->where('project_id', $request->project_id);


        }
        if ($request->filled('organization_id')) {
            $rows->where('organization_id', $request->organization_id);


        }
        if ($request->filled('type_id')) {
            $rows->where('type_id', $request->type_id);


        }
        if ($request->filled('status')) {
            $rows->where('status', $request->status);


        }

        if ($request->filled('from')) {
            $rows->where('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $rows->where('date', '<=', $request->to);
        }

        $rows = $rows->paginate(20);

        return view('admin.contract.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Contract $model)
    {
//        return "asa";
        return view('admin.contract.create', compact('model'));
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

        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
            'no' => 'required',
            'organization_id' => 'required|exists:organizations,id',
//            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:0',
            'project_id' => 'required|exists:projects,id',
            'type_id' => 'required|exists:contract_types,id',
//            'details' => 'required',
            'city_id' => 'required|exists:cities,id',
            'start_date' => 'required|date|date_format:Y-m-d',
//            'finish_date' => 'required|date|date_format:Y-m-d|after:start_date',
//            'lat' => 'required',
//            'lon' => 'required',
            'status' => 'required|in:notStart,active,onhold,closed,extended',
//            'items.*' => 'required',

        ];
        if($request->filled('finish_date')){
            $rules['finish_date']=   'required|date|date_format:Y-m-d|after:start_date';
        }
        $validator = validator()->make($request->all(), $rules);
        $validator->after(function ($validator) use ($request) {
//          return  $request->items;
            if (count(json_decode($request->items)) < 1) {
//            if (count(array_filter($request->items)) < 1) {

                $validator->errors()->add('items', trans('main.please_add_item'));
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }

        DB::beginTransaction();
        try {
            $request->merge(['total' => $request->total]);
            $request->merge(['type' => 'main']);
            $row = Contract::create($request->all());
            $items = json_decode($request->items);
            $sum = 0;
            foreach ($items as $item) {
                $d = new ContractDetail();
                $d->contract_id = $row->id;
                $d->item_id = $item->item_id;
                $d->price = $item->price;
                $d->quantity = $item->quantity;
//                $d->total = $item->quantity * $item->price;
                $d->save();
                $plus_total = $item->price * $item->quantity;
                $sum+= $plus_total;
            }
            $row->price = $sum;
            $row->save();

            if($request->hasFile('images'))
            {
                $files = $request->file('images');
                foreach ($files as $file) {
                    $name = time() . '' . rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
                    $file->move('uploads/contracts', $name);
                    $contract_file = new Contract_file([
                        'file' => $name,
                        'contract_id'=>$row->id
                    ]);
                    $contract_file->save();
                }
            }

            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The contract no :subject.no created');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/contract');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
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
        $row = Contract::find($id);

        return view('admin.contract.show', compact('row'));
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
        $model = Contract::findOrFail($id);
//     return   $items=   $model->items;
//        foreach ($items as $item){
////            $it= Item
////            $item->item_name= $
//        }
        $itemsJs = json_encode(json_decode($model->items, false));
        return view('admin.contract.edit', compact('model', 'itemsJs'));
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


        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
            'no' => 'required',
            'organization_id' => 'required|exists:organizations,id',
//            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:0',
            'project_id' => 'required|exists:projects,id',
            'type_id' => 'required|exists:contract_types,id',
//            'details' => 'required',
            'city_id' => 'required|exists:cities,id',
            'start_date' => 'required|date|date_format:Y-m-d',
//            'finish_date' => 'required|date|date_format:Y-m-d|after:start_date',
//            'lat' => 'required',
//            'lon' => 'required',
            'status' => 'required|in:notStart,active,onhold,closed,extended',
//            'items.*' => 'required',


        ];
        if($request->filled('finish_date')){
            $rules['finish_date']=   'required|date|date_format:Y-m-d|after:start_date';
        }
        $validator = validator()->make($request->all(), $rules);
        $validator->after(function ($validator) use ($request) {
//          return  $request->items;
//            if (count(array_filter($request->items)) < 1) {
//
//                $validator->errors()->add('items', trans('main.please_add_item'));
//            }
            if (count(json_decode($request->items)) < 1) {


                $validator->errors()->add('items', trans('main.please_add_item'));
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }
        DB::beginTransaction();
        try {
            $request->merge(['total' => $request->total]);
            $row = Contract::findOrFail($id);
            $row->update($request->all());
            $row->items()->delete();


            $items = json_decode($request->items);
            $sum = 0;
            foreach ($items as $item) {

                $d = new ContractDetail();
                $d->contract_id = $row->id;
                $d->item_id = $item->item_id;
                $d->price = $item->price;
                $d->quantity = $item->quantity;
//                $d->total = $item->quantity * $item->price;
                $d->save();
                $plus_total = $item->price * $item->quantity;
                $sum+= $plus_total;
            }
            $row->price = $sum;
            $row->save();
//        $client->roles()->sync($request->role);
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The contract no :subject.no updated');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/contract');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $row = Contract::findOrFail($id);
        $row->items()->delete();

        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The contract no :subject.no deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }
    public function detailsPrint( $id)
    {



        $row = Contract::find($id);
        return view('admin.contract.details_print', compact('row'));
    }

    public function items(Contract $contract){

//        $items = $item->where('is_minus' , 0)->latest()->get();
        $html = '<select class="form-control select2" id="item_id" name="item_id">';
        foreach ($contract->items as $detail)
        {
            $item = $detail->item;
            $new_items[$item->id]= $item->name  .' | '.$item->unit->name ?? '';
            $html.='<option data-price="'.$detail->price.'" value="'.$item->id.'">'.$item->name  .' | '.$item->unit->name ?? ''.'</option>';
        }
        $html.= '</select>';

        return $html;
    }

    public function download($file_name) {
        $file_path = 'uploads/contracts/'.$file_name;
        return response()->download($file_path);
    }

}
