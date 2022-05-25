<?php

namespace App\Http\Controllers\Admin;

use App\AccountingImage;
use App\Extract;
use App\ExtractDetail;

use App\Http\Controllers\Controller;
use App\Accounting;
use App\Safe;
use App\SafeTransaction;
use App\SubContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ContractExtractController extends Controller
{
    //

    public function index(Request $request)
    {
        //

        $rows = Accounting::latest();
        if ($request->filled('name')) {
            $rows->where('name', 'like', "%$request->name%");


        }

        $rows = $rows->paginate(20);

        return view('admin.extract.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Extract $model, $parent_id)
    {
//        return "asa";

        $parent = SubContract::find($parent_id);
//        return $parent;
        return view('admin.extract.create', compact('model', 'parent'));
    }


    public function store(Request $request, $parent_id)
    {
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',


//            'project_id' => 'required|exists:projects,id',
            'organization_id' => 'required|exists:organizations,id',
            'period_from' => 'required|date|date_format:Y-m-d',
            'period_to' => 'required|date||date_format:Y-m-d|after:period_from',


        ];


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
            $last_no = Extract::where('sub_contract_id', $parent_id)
                ->where('project_id', $request->project_id)
                ->where('organization_id', $request->organization_id)
                ->first();
            if($last_no){
                $extract_no= $last_no->extract_no+1;
            }else{
                $extract_no= 1;
            }
            $project_id = SubContract::findOrFail($parent_id)->project->id;
            $row = Extract::create([

                'date' => $request->date,

                'sub_contract_id' => $parent_id,
                'organization_id' => $request->organization_id,
                'project_id' => $project_id,
                'period_from' => $request->period_from,
                'period_to' => $request->period_to,

                'details' => $request->details,
                'extract_no' => $extract_no,


            ]);


            $items = json_decode($request->items);
            foreach ($items as $item) {

                $d = new ExtractDetail();
                $d->extract_id = $row->id;
                $d->item_id = $item->item_id;
                $d->price = $item->price;
                $d->quantity = $item->quantity;
                $d->exchange_ratio = $item->exchange_ratio;
//                $d->total = $item->quantity * $item->price;
                $d->save();
            }
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The contract id :subject.id created');

            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/sub-contract/'.$parent_id);


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }


    }


    public function show($parent_id,$id)
    {
        return $parent_id;
        $row = Extract::find($parent_id);
        return view('admin.extract.show', compact('row'));
    }






}
