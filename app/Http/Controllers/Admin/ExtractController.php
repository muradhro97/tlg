<?php

namespace App\Http\Controllers\Admin;

use App\AccountingImage;
use App\Contract;
use App\Extract;
use App\ExtractDetail;
use App\ExtractImage;
use App\Http\Controllers\Controller;
use App\Accounting;
use App\Safe;
use App\SafeTransaction;
use App\SubContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Auth;

class ExtractController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:allExtract', ['only' => ['index']]);
        $this->middleware('permission:allMainExtract', ['only' => ['mainIndex']]);
        $this->middleware('permission:addExtract', ['only' => ['create', 'store']]);
        $this->middleware('permission:addMainExtract', ['only' => ['mainCreate', 'mainStore']]);
        $this->middleware('permission:editExtract', ['only' => ['edit', 'update']]);
        $this->middleware('permission:editMainExtract', ['only' => ['editMain', 'updateMain']]);
//        $this->middleware('permission:editExtract', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:deleteExtract', ['only' => ['destroy']]);


    }

    public function index(Request $request)
    {
        //
        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');

        $rows = Extract::whereHas('organization', function ($q) {
            return $q->where('type', 'subContractor');
        })->whereIn('project_id',$product_ids)->latest();

        if ($request->filled('project_id')) {
            $rows->where('project_id', $request->project_id);
        }

        if ($request->filled('organization_id')) {
            $rows->where('organization_id', $request->organization_id);
        }

        if ($request->filled('type_id')) {
            $rows->where('type_id', $request->type_id);
        }

        if ($request->filled('sub_contract_id')) {
            $rows->where('sub_contract_id', $request->sub_contract_id);
        }

        if ($request->filled('date')) {
            $rows->where('date', $request->date);
        }

        if ($request->filled('total')) {
            $rows->where('total', $request->total);
        }

        if($request->filled('amount_from'))
        {
             $rows->where('total','>=', $request->amount_from);
        }

        if($request->filled('amount_to'))
        {
             $rows->where('total','<=', $request->amount_to);
        }

        $rows = $rows->paginate(20);

        return view('admin.extract.index', compact('rows'));
    }

    public function mainIndex(Request $request)
    {
        //
        $user=Auth::user();
        $product_ids=$user->projects()->select('project_id');

        $rows = Extract::whereHas('organization', function ($q) {
            return $q->where('type', 'mainContractor');
        })->whereIn('project_id',$product_ids)->latest();

        if ($request->filled('project_id')) {
            $rows->where('project_id', $request->project_id);
        }

        if ($request->filled('organization_id')) {
            $rows->where('organization_id', $request->organization_id);
        }

        if ($request->filled('type_id')) {
            $rows->where('type_id', $request->type_id);
        }

        if ($request->filled('contract_id')) {
            $rows->where('contract_id', $request->contract_id);
        }

        if ($request->filled('date')) {
            $rows->where('date', $request->date);
        }

        if ($request->filled('total')) {
            $rows->where('total', $request->total);
        }
        if($request->filled('amount_from'))
        {
            $rows->where('total','<=', $request->amount_from);
        }

        if($request->filled('amount_to'))
        {
            $rows->where('total','>=', $request->amount_to);
        }

        $rows = $rows->paginate(20);

        return view('admin.extract.main_index', compact('rows'));
    }


    public function create(Accounting $model)
    {
        return view('admin.extract.create_extract', compact('model'));
    }

    public function mainCreate(Accounting $model)
    {
//        return "asa";
        return view('admin.extract.create_main_extract', compact('model'));
    }


    public function store(Request $request)
    {
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
//            'project_id' => 'required|exists:projects,id',
            'sub_contract_id' => 'required',
            'number' => 'required',
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
            $parent_id = $request->sub_contract_id;
            $project_id = SubContract::findOrFail($parent_id)->project->id;
            $last_no = Extract::where('sub_contract_id', $parent_id)
                ->where('project_id', $request->project_id)
                ->where('organization_id', $request->organization_id)
                ->first();
            if ($last_no) {
                $extract_no = $last_no->extract_no + 1;
            } else {
                $extract_no = 1;
            }
            $row = Extract::create([

                'date' => $request->date,
                'number'=>$request->number,
                'sub_contract_id' => $parent_id,
                'organization_id' => $request->organization_id,
                'project_id' => $project_id,
                'period_from' => $request->period_from,
                'period_to' => $request->period_to,
                'details' => $request->details,
                'total' => $request->total,
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

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/extracts/');
                }
            }

            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The contract id :subject.id created');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/extract');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }


    }


    public function mainStore(Request $request)
    {
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
//            'project_id' => 'required|exists:projects,id',
            'contract_id' => 'required|exists:contracts,id',
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
            $parent_id = $request->contract_id;
            $project_id = Contract::findOrFail($parent_id)->project->id;
            $last_no = Extract::where('contract_id', $parent_id)
                ->where('project_id', $request->project_id)
                ->where('organization_id', $request->organization_id)
                ->first();
            if ($last_no) {
                $extract_no = $last_no->extract_no + 1;
            } else {
                $extract_no = 1;
            }
            $row = Extract::create([

                'date' => $request->date,

                'contract_id' => $parent_id,
                'organization_id' => $request->organization_id,
                'project_id' => $project_id,
                'period_from' => $request->period_from,
                'period_to' => $request->period_to,
                'details' => $request->details,
                'total' => $request->total,
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

            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/extracts/');
                }
            }

            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The contract id :subject.id created');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/main_extract');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }


    }


    public function show($id)
    {
//        return "asa";
        $row = Extract::find($id);
        return view('admin.extract.show', compact('row'));
    }


    public static function addImage($image, $id, $path)
    {
        $path_thumb = $path . 'thumb_';
        $name = time() . '' . rand(11111, 99999) . '.' . $image->getClientOriginalExtension();
        $img = Image::make($image);

        $img->save($path . $name);

        $img->widen(100, null);

        $img->save($path_thumb . $name);
        $addImage = new ExtractImage();
        $addImage->image = $path . $name;
        $addImage->image_thumb = $path_thumb . $name;
        $addImage->extract_id = $id;
        $addImage->save();
    }

    public static function deleteImage($name)
    {
        $deletepath = base_path($name);
        if (file_exists($deletepath) and $name != '') {
            unlink($deletepath);
        }

        return true;
    }

    public function detailsPrint($id)
    {
        $row = Extract::find($id);
        return view('admin.extract.details_print', compact('row'));
    }

    public function edit(Extract $extract){
        $model = $extract;
        $itemsJs = json_encode(json_decode($model->items, false));

        return view('admin.extract.edit_extract', compact('model','itemsJs'));
    }
    public function update(Request $request , Extract $extract)
    {
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
//            'project_id' => 'required|exists:projects,id',
            'sub_contract_id' => 'required',
            'organization_id' => 'required|exists:organizations,id',
            'period_from' => 'required|date|date_format:Y-m-d',
            'period_to' => 'required|date||date_format:Y-m-d|after:period_from',


        ];


        $validator = validator()->make($request->all(), $rules);

        $validator->after(function ($validator) use ($request) {
            if (count(json_decode($request->items)) < 1) {
                $validator->errors()->add('items', trans('main.please_add_item'));
            }
        });
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $parent_id = $request->sub_contract_id;
            $project_id = SubContract::findOrFail($parent_id)->project->id;
            $last_no = Extract::where('sub_contract_id', $parent_id)
                ->where('project_id', $request->project_id)
                ->where('organization_id', $request->organization_id)
                ->first();
            if ($last_no) {
                $extract_no = $last_no->extract_no + 1;
            } else {
                $extract_no = 1;
            }
            $row = $extract;
            $row->update([

                'date' => $request->date,

                'sub_contract_id' => $parent_id,
                'organization_id' => $request->organization_id,
                'project_id' => $project_id,
                'period_from' => $request->period_from,
                'period_to' => $request->period_to,
                'details' => $request->details,
                'total' => $request->total,
                'extract_no' => $extract_no,
            ]);

            $row->items()->delete();
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

            if ($request->hasFile('images')) {
                $row->images()->delete();
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/extracts/');
                }
            }

            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The contract id :subject.id created');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/extract');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }


    }

    public function mainEdit(Extract $extract){
        $model = $extract;
        $itemsJs = json_encode(json_decode($model->items, false));
        return view('admin.extract.edit_main_extract', compact('model','itemsJs'));
    }

    public function mainUpdate(Request $request , Extract $extract)
    {
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
//            'project_id' => 'required|exists:projects,id',
            'contract_id' => 'required|exists:contracts,id',
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
            $parent_id = $request->contract_id;
            $project_id = Contract::findOrFail($parent_id)->project->id;
            $last_no = Extract::where('contract_id', $parent_id)
                ->where('project_id', $request->project_id)
                ->where('organization_id', $request->organization_id)
                ->first();
            if ($last_no) {
                $extract_no = $last_no->extract_no + 1;
            } else {
                $extract_no = 1;
            }
            $row = $extract;
            $row->update([

                'date' => $request->date,

                'contract_id' => $parent_id,
                'organization_id' => $request->organization_id,
                'project_id' => $project_id,
                'period_from' => $request->period_from,
                'period_to' => $request->period_to,
                'details' => $request->details,
                'total' => $request->total,
                'extract_no' => $extract_no,
            ]);

            $row->items()->delete();
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

            if ($request->hasFile('images')) {
                $row->images()->delete();
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/extracts/');
                }
            }

            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The contract id :subject.id created');
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/main_extract');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
    }
}
