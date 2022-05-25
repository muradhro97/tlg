<?php

namespace App\Http\Controllers\admin;

use App\Accounting;
use App\AccountingImage;
use App\CashInDetail;
use App\Http\Controllers\Controller;
use App\PusherNotification;
use App\Safe;
use App\SafeTransaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class AccountingCashOutController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:allAccountingCashOut', ['only' => ['index']]);
        $this->middleware('permission:addAccountingCashOut', ['only' => ['create', 'store']]);
        $this->middleware('permission:detailsAccountingCashOut', ['only' => ['show']]);
//        $this->middleware('permission:managerAcceptDeclineWorkerLoan', ['only' => ['managerChangeStatus']]);
        $this->middleware('permission:safeAcceptDeclineAccountingCashIn', ['only' => ['changeStatus']]);

    }

    public function index(Request $request)
    {
        //

        $rows = Accounting::latest()->where('type','cashout');


        if ($request->filled('project_id')) {
            $rows->where('project_id', $request->project_id);


        }
        if ($request->filled('organization_id')) {
            $rows->where('organization_id', $request->organization_id);


        }
        if ($request->filled('contract_id')) {
            $rows->where('contract_id', $request->contract_id);


        }

        if ($request->filled('safe_id')) {
            $rows->where('safe_id', $request->safe_id);


        }

        if ($request->filled('manager_status')) {
            $rows->where('manager_status', $request->manager_status);


        }
        if ($request->filled('payment_status')) {
            $rows->where('payment_status', $request->payment_status);


        }

        if ($request->filled('date')) {
            $rows->where('date', $request->date);


        }

        $rows = $rows->paginate(20);

        return view('admin.accounting_cash_out.index', compact('rows'));
    }

    public function create(Accounting $model)
    {
        return view('admin.accounting_cash_out.create', compact('model'));
    }


    public function store(Request $request)
    {
        if (isset($request->total))
        {
            $request->amount = $request->total;
        }
        //
//        return $items = json_decode($request->items);
//        return $request->all();
        $rules = [

            'date' => 'required|date|date_format:Y-m-d',
//            'amount' => 'required|numeric|min:0',
            'organization_id' => 'required|exists:organizations,id',
//            'contract_id' => 'required|exists:contracts,id',
            'safe_id' => 'required|exists:safes,id',
//            'extract_no' => 'required|max:255',
            'employee_id' => 'required|exists:employees,id',
            'transaction_cheque_no' => 'required|max:255',


//            'details' => 'required',
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
            $safe = Safe::find($request->safe_id);

            $row = Accounting::create([

                'date' => $request->date,
                'amount' => $request->amount,
                'organization_id' => $request->organization_id,
                'contract_id' => $request->contract_id,
                'type' => 'cashout',

                'safe_id' => $request->safe_id,
                'transaction_cheque_no' => $request->transaction_cheque_no,
                'extract_no' => $request->extract_no,
                'employee_id' => $request->employee_id,
                'project_id' => $request->project_id,
                'details' => $request->details,
                'payment_status' => "confirmed",


            ]);

            SafeTransaction::create([

                'accounting_id' => $row->id,
                'amount' => $request->amount,
                'module' => 'accounting',
                'balance' => $safe->balance,
                'new_balance' => $safe->balance - $request->amount,
                'safe_id' => $request->safe_id,


            ]);
            $safe->balance = $safe->balance - $request->amount;
            $safe->save();
            $notifiers = User::permission('managerNotification')->get();

            $title = 'Accounting CashOut';

            $message ='New Accounting CashOut # '. $row->id .' Added by ('.auth()->user()->name.')';
            $link = url('admin/accounting-cash-out/' . $row->id);

//            $items = json_decode($request->items);
//            if (!isset($request->total))
//            {
//                foreach ($items as $item) {
//
//                    $d = new CashInDetail();
//                    $d->accounting_id  = $row->id;
//                    $d->item_id = $item->item_id;
//                    $d->price = $item->price;
//                    $d->quantity = $item->quantity;
//                    $d->exchange_ratio = $item->exchange_ratio;
////                $d->total = $item->quantity * $item->price;
//                    $d->save();
//                }
//            }


            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/accounting/');
                }
            }

//        $client->roles()->sync($request->input('role'));
            DB::commit();

            toastr()->success(trans('main.save_done_successfully'));
            PusherNotification::sendAll($notifiers,$title,$message,$link);
            return redirect('admin/accounting-cash-out');


        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }


    }


    public function show(Request $request, $id)
    {

        if ($request->filled('notification')) {
            $notification = auth()->user()->unreadNotifications()->where('id', $request->notification)->first();
            if ($notification) {

                $notification->markAsRead();
            }
        }

        $row = Accounting::find($id);
        return view('admin.accounting_cash_out.show', compact('row'));
    }


    public function changeStatus(Request $request)
    {
//        return "asa";
        DB::beginTransaction();
        try {
            $row = Accounting::find($request->id);
            $row->payment_status = $request->payment_status;
            $row->save();
            if ($request->payment_status == "confirmed") {
                $safe = Safe::find($row->safe_id);

                SafeTransaction::create([

                    'accounting_id' => $row->id,
                    'amount' => $row->amount,
                    'module' => 'accounting',
                    'balance' => $safe->balance,
                    'new_balance' => $safe->balance + $row->amount,
                    'safe_id' => $row->safe_id,


                ]);
                $safe->balance = $safe->balance + $row->amount;
                $safe->save();
                toastr()->success(trans('main.confirm_done_successfully'));
                $notifiers = User::permission(['accountantNotification','managerNotification'])->get();
                $title = 'Accounting CashIn';
                $message = ' Accounting CashIn # ' . $row->id .' accepted by  Safe Employee (' . auth()->user()->name.')';
                $link = url('admin/accounting-cash-in/' . $row->id);
            } elseif ($request->payment_status == "cancel") {
                toastr()->success(trans('main.decline_done_successfully'));
                $notifiers = User::permission('managerNotification')->get();
                $title = 'Accounting CashIn';
                $message = 'Accounting CashIn # ' . $row->id .' Declined by Safe Employee (' . auth()->user()->name.')';
                $link = url('admin/accounting-cash-in/' . $row->id);
            }

            DB::commit();
            PusherNotification::sendAll($notifiers,$title,$message,$link);
            return back();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
//            return back();


        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();


            return back()->withErrors($ex->errorInfo[2])->withInput();

        }

    }


    public static function addImage($image, $id, $path)
    {
        $path_thumb = $path . 'thumb_';
        $name = time() . '' . rand(11111, 99999) . '.' . $image->getClientOriginalExtension();
        $img = Image::make($image);

        $img->save($path . $name);

        $img->widen(100, null);

        $img->save($path_thumb . $name);
        $addImage = new AccountingImage();
        $addImage->image = $path . $name;
        $addImage->image_thumb = $path_thumb . $name;
        $addImage->accounting_id = $id;
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
