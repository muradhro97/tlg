<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Item;

use App\Payment;
use App\Safe;
use App\SafeTransaction;
use App\SafeTransactionDetail;
use App\PaymentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class SafeTransactionController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:safeTransaction', ['only' => ['index']]);

    }

    public function index(Request $request)
    {
         $rows = SafeTransaction::latest()
            ->where('safe_id', 0)
        ;
        if ($request->filled('type')) {
//            dd($request->type);
//            $rows->where('type', $request->type);
// $query->whereHas('payment', function ($q2) use ($request) {
//            $rows->whereHas('payment', function ($q2) use ($request) {
//                $q2->where('type', 'cashin');
//
//            });



            $rows->where(function($query)use($request){
                $query->whereHas('accounting', function ($q) use ($request) {
                    $q->where('type', $request->type);

                });
                $query->orWhereHas('payment', function ($q2) use ($request) {
                    $q2->where('type', $request->type);

                });
            });

        }
        if ($request->filled('module')) {
            $rows->where('module', $request->module);
        }
//        if ($request->filled('safe')) {
//            $rows->where('safe', $request->safe);
//        }
        if ($request->filled('from')) {
            $rows->where('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $rows->where('created_at', '<=', $request->to);
        }
        $total = $rows->sum('amount');
        $rows = $rows->paginate(100);

        return view('admin.safe_transaction.index', compact('rows','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cashIn(SafeTransaction $model)
    {
        return "asa";
        return view('admin.safe_transaction.cash_in', compact('model'));
    }


    public function storeCashIn(Request $request)
    {
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
            'amount' => 'required|numeric|min:0',
            'organization_id' => 'required|exists:organizations,id',
            'project_id' => 'required|exists:projects,id',
            'employee_id' => 'required|exists:employees,id',


            'details' => 'required',
//            'description' => 'required',
//            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',


        ];

        if ($request->images != null and count(array_filter($request->images)) > 0) {
            $rules['images.*'] = 'image|mimes:jpg,jpeg,bmp,png';
//            dd($request->images);
        }
        $validator = validator()->make($request->all(), $rules);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }


        DB::beginTransaction();
        try {
            $safe = Safe::first();


            $row = SafeTransaction::create([
//            DB::table('client_transactions')->insert([

                'employee_id' => $request->employee_id,
                'amount' => $request->amount,
                'type' => 'cashin',
                'organization_id' => $request->organization_id,
                'project_id' => $request->project_id,
                'details' => $request->details,
//                'description' => $request->description,
                'date' => $request->date,
                'balance' => $safe->balance,
                'new_balance' => $safe->balance + $request->amount,


            ]);
            $safe->balance = $safe->balance + $request->amount;
            $safe->save();
//        $client->roles()->sync($request->input('role'));
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/safetransactions/');

                }
            }

//        $client->roles()->sync($request->input('role'));
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/safe-transaction');


        } catch (\Exception $e) {
            DB::rollBack();
//            dd($e->getMessage());
//            return $e->getMessage();
//            $error = $e->getMessage();
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($e->getMessage());
            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
//            dd(456);
//            $error = $ex->errorInfo[2];
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($ex->errorInfo[2]);

            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
    }

    public function cashOut(SafeTransaction $model)
    {
//        return "asa";
        return view('admin.safe_transaction.cash_out', compact('model'));
    }


    public function storeCashOut(Request $request)
    {
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
            'amount' => 'required|numeric|min:0',
            'organization_id' => 'required|exists:organizations,id',
            'project_id' => 'required|exists:projects,id',
            'employee_id' => 'required|exists:employees,id',
            'category_id' => 'required|exists:categories,id',
            'labors_department_id' => 'required|exists:labors_departments,id',
            'labors_type' => 'required|in:na,all,supervisor,technical,assistant,worker',


            'details' => 'required',
//            'description' => 'required',
//            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',


        ];

        if ($request->images != null and count(array_filter($request->images)) > 0) {
            $rules['images.*'] = 'image|mimes:jpg,jpeg,bmp,png';
//            dd($request->images);
        }
        $validator = validator()->make($request->all(), $rules);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }


        DB::beginTransaction();
        try {
            $safe = Safe::first();
            $row = SafeTransaction::create([
//            DB::table('client_transactions')->insert([

                'employee_id' => $request->employee_id,
                'amount' => $request->amount,
                'organization_id' => $request->organization_id,
                'project_id' => $request->project_id,
                'details' => $request->details,
//                'description' => $request->description,
                'date' => $request->date,
                'type' => 'cashout',
//                'balance' => $safe->balance,
//                'new_balance' => $safe->balance + $request->amount,
                'category_id' => $request->category_id,
                'labors_department_id' => $request->labors_department_id,
                'labors_type' => $request->labors_type,


            ]);
//            $safe->balance = $safe->balance + $request->amount;
//            $safe->save();
//        $client->roles()->sync($request->input('role'));
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/safetransactions/');

                }
            }

//        $client->roles()->sync($request->input('role'));
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/safe-transaction');


        } catch (\Exception $e) {
            DB::rollBack();
//            dd($e->getMessage());
//            return $e->getMessage();
//            $error = $e->getMessage();
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($e->getMessage());
            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
//            dd(456);
//            $error = $ex->errorInfo[2];
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($ex->errorInfo[2]);

            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
    }


    public function custody(SafeTransaction $model)
    {
//        return "asa";
        return view('admin.safe_transaction.custody', compact('model'));
    }


    public function storeCustody(Request $request)
    {
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
            'amount' => 'required|numeric|min:0',
            'organization_id' => 'required|exists:organizations,id',
            'project_id' => 'required|exists:projects,id',
            'employee_id' => 'required|exists:employees,id',


            'details' => 'required',
//            'description' => 'required',
//            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',


        ];

        if ($request->images != null and count(array_filter($request->images)) > 0) {
            $rules['images.*'] = 'image|mimes:jpg,jpeg,bmp,png';
//            dd($request->images);
        }
        $validator = validator()->make($request->all(), $rules);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }


        DB::beginTransaction();
        try {
            $safe = Safe::first();

            if ($request->amount > $safe->balance) {
                DB::rollBack();
                return back()->withErrors(trans('main.amount_bigger_than_safe_balance'))->withInput();
            }
            $row = SafeTransaction::create([
//            DB::table('client_transactions')->insert([

                'employee_id' => $request->employee_id,
                'amount' => $request->amount,
                'organization_id' => $request->organization_id,
                'project_id' => $request->project_id,
                'details' => $request->details,
//                'description' => $request->description,
                'type' => 'custody',
                'status' => 'open',
                'date' => $request->date,
                'balance' => $safe->balance,
                'new_balance' => $safe->balance - $request->amount,


            ]);
            $safe->balance = $safe->balance - $request->amount;
            $safe->save();
//        $client->roles()->sync($request->input('role'));
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/safetransactions/');

                }
            }

//        $client->roles()->sync($request->input('role'));
            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/safe-transaction');


        } catch (\Exception $e) {
            DB::rollBack();
//            dd($e->getMessage());
//            return $e->getMessage();
//            $error = $e->getMessage();
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($e->getMessage());
            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
//            dd(456);
//            $error = $ex->errorInfo[2];
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($ex->errorInfo[2]);

            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
    }

    public function custodyRest($id)
    {
//        return "asa";
        $model = SafeTransaction::where('id', $id)->where('status', 'open')->first();
        return view('admin.safe_transaction.custody_rest', compact('model'));
    }


    public function storeCustodyRest(Request $request)
    {
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [


            'rest' => 'required|numeric|min:0',

//            'images.*' => 'image|mimes:jpg,jpeg,bmp,png',


        ];


        $validator = validator()->make($request->all(), $rules);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();


        }


        DB::beginTransaction();
        try {
            $safe = Safe::first();
            $parent = SafeTransaction::find($request->id);

            $row = SafeTransaction::create([


                'amount' => $request->rest,

                'type' => 'custodyRest',


                'safe_transaction_id' => $parent->id,
                'balance' => $safe->balance,
                'new_balance' => $safe->balance + $request->rest,


            ]);

            $parent->status = 'closed';
            $parent->save();
            $safe->balance = $safe->balance + $request->rest;
            $safe->save();

            DB::commit();
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/safe-transaction');


        } catch (\Exception $e) {
            DB::rollBack();
//            dd($e->getMessage());
//            return $e->getMessage();
//            $error = $e->getMessage();
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($e->getMessage());
            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
//            dd(456);
//            $error = $ex->errorInfo[2];
//            $html = view('partials.errors', compact('error'))->render();
//            $data = [
//                'status' => false,
//                'errors' => $html,
//            ];

//            return response()->json($data, 422);
//            flash()->error($ex->errorInfo[2]);

            return back()->withErrors($ex->errorInfo[2])->withInput();

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
//    public function show($id)
//    {
//
//    }
    public function show($id)
    {
//        return "asa";
        $row = SafeTransaction::find($id);
        return view('admin.safe_transaction.show', compact('row'));
    }

    public function changeStatus(Request $request)
    {
//        return "asa";
        return $request->all();
        $row = SafeTransaction::find($id);
        return view('admin.safe_transaction.show', compact('row'));
    }

    public static function addImage($image, $id, $path)
    {
        $path_thumb = $path . 'thumb_';
        $name = time() . '' . rand(11111, 99999) . '.' . $image->getClientOriginalExtension();
        $img = Image::make($image);

        $img->save($path . $name);

        $img->widen(100, null);

        $img->save($path_thumb . $name);
        $addImage = new PaymentImage;
        $addImage->image = $path . $name;
        $addImage->image_thumb = $path_thumb . $name;
        $addImage->safe_transaction_id = $id;
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


}
