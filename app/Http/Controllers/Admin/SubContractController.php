<?php

namespace App\Http\Controllers\Admin;


use App\Contract;
use App\Contract_file;
use App\ContractDetail;
use App\ContractItem;
use App\Library\Field;
use App\Project;
use App\SubContract;
use App\SubContract_file;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth;


class  SubContractController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:allSubContract', ['only' => ['index']]);
        $this->middleware('permission:addSubContract', ['only' => ['create', 'store']]);
        $this->middleware('permission:editSubContract', ['only' => ['edit', 'update']]);
        $this->middleware('permission:deleteSubContract', ['only' => ['destroy']]);


    }

    public function index(Request $request)
    {
        //
//        $rowss = SubContract::all();
//        foreach ($rowss as $row) {
//
//
//            $project = Project::find($row->project_id);
//            $check = SubContract::where('project_id', $project->id)->max('no_helper') ?? 0;
////            dd($check);
//            $no = $check + 1;
//            $row->no = 'SUB-TLG-' . $project->abbreviation . '-' . $no;
//            $row->no_helper = $no;
//            $row->save();
//
//        }
//        return "done";
        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');
        $rows = SubContract::latest();
        $rows->whereIn('project_id',$product_ids);
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


        $total = $rows->sum('price');
        $rows = $rows->paginate(20);

        return view('admin.sub_contract.index', compact('rows','total'));
    }

    public function create(SubContract $model)
    {
        return view('admin.sub_contract.create', compact('model'));
    }

    public function store(Request $request)
    {
        //
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
//            'no' => 'required',
            'organization_id' => 'required|exists:organizations,id',
//            'price' => 'required|numeric|min:0',
//            'duration' => 'required|numeric|min:0',
            'project_id' => 'required|exists:projects,id',
            'type_id' => 'required|exists:contract_types,id',
//            'details' => 'required',
            'city_id' => 'required|exists:cities,id',
            'start_date' => 'required|date|date_format:Y-m-d',
            'finish_date' => 'required|date||date_format:Y-m-d|after:start_date',
//            'lat' => 'required',
//            'lon' => 'required',
            'status' => 'required|in:notStart,active,onhold,closed,extended',
//            'items.*' => 'required',
//            'duration' => 'required|numeric|min:0',


        ];
        if ($request->filled('finish_date')) {
            $rules['finish_date'] = 'required|date|date_format:Y-m-d|after:start_date';
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
//        $project= Project::find($request->project_id);
//        $check= SubContract::where('project_id',$project->id)->max('no_helper') ?? 0;
//        dd($check);
        DB::beginTransaction();
        try {
            $fdate = $request->start_date;
            $tdate = $request->finish_date;
            $datetime1 = new \DateTime($fdate);
            $datetime2 = new \DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');//now do whatever you like with $days

            $project = Project::find($request->project_id);
            $check = SubContract::where('project_id', $project->id)->max('no_helper') ?? 0;
//            dd($check);
            $no = $check + 1;
            $request->merge(['total' => $request->total]);
            $request->merge(['no' => 'SUB-TLG-' . $project->abbreviation . '-' . $no]);
            $request->merge(['no_helper' => $no]);
            $request->merge(['type' => 'sub']);
            $request->merge(['duration' => $days]);

            $row = SubContract::create($request->all());

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
                ->log('The sub contract no :subject.no created');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/sub-contract');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }

    }

    public function show($id)
    {
        $row = SubContract::find($id);
        return view('admin.sub_contract.show', compact('row'));
    }

    public function edit($id)
    {
        $model = SubContract::findOrFail($id);
        $itemsJs = json_encode(json_decode($model->items, false));
        return view('admin.sub_contract.edit', compact('model', 'itemsJs'));
    }

    public function update(Request $request, $id)
    {
        //

        $rules = [
            'date' => 'required|date|date_format:Y-m-d',
//            'no' => 'required',
            'organization_id' => 'required|exists:organizations,id',
//            'price' => 'required|numeric|min:0',
//            'duration' => 'required|numeric|min:0',
            'project_id' => 'required|exists:projects,id',
            'type_id' => 'required|exists:contract_types,id',
//            'details' => 'required',
            'city_id' => 'required|exists:cities,id',
            'start_date' => 'required|date|date_format:Y-m-d',
//            'finish_date' => 'required|date||date_format:Y-m-d|after:start_date',
//            'lat' => 'required',
//            'lon' => 'required',
            'status' => 'required|in:notStart,active,onhold,closed,extended',
//            'items.*' => 'required',
//            'price' => 'required|numeric|min:0',
//            'duration' => 'required|numeric|min:0',
        ];

        if ($request->filled('finish_date')) {
            $rules['finish_date'] = 'required|date|date_format:Y-m-d|after:start_date';
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
            $fdate = $request->start_date;
            $tdate = $request->finish_date;
            $datetime1 = new \DateTime($fdate);
            $datetime2 = new \DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');//now do whatever you like with $days

            $request->merge(['total' => $request->total]);
            $request->merge(['duration' => $days]);
            $row = SubContract::findOrFail($id);
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
                ->log('The sub contract no :subject.no updated');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/sub-contract');


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

        $row = SubContract::findOrFail($id);
        $row->items()->delete();

        $row->delete();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The sub contract no :subject.no deleted');
        toastr()->success(trans('main.delete_done_successfully'));
        return back();

    }
    public function detailsPrint( $id)
    {
        $row = SubContract::find($id);
        return view('admin.sub_contract.details_print', compact('row'));
    }

    public function items(SubContract $sub_contract){

//        $items = $item->where('is_minus' , 0)->latest()->get();
        $html = '<select class="form-control select2" id="item_id" name="item_id">';
        foreach ($sub_contract->items as $detail)
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
