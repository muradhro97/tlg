<?php

namespace App\Http\Controllers\Admin;

use App\Accounting;
use App\Http\Controllers\Controller;


use App\PusherNotification;
use App\Safe;
use App\Payment;

use App\PaymentImage;
use App\SafeTransaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class PaymentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('permission:payment', ['only' => ['index']]);
        $this->middleware('permission:cashIn', ['only' => ['cashIn', 'storeCashIn']]);
        $this->middleware('permission:cashOut', ['only' => ['cashOut', 'storeCashOut']]);
        $this->middleware('permission:custody', ['only' => ['custody', 'storeCustody']]);
        $this->middleware('permission:custodyRest', ['only' => ['custodyRest', 'storeCustodyRest']]);
        $this->middleware('permission:custodyToLoan', ['only' => ['custodyToLoan']]);
        $this->middleware('permission:detailsPayment', ['only' => ['show']]);
        $this->middleware('permission:acceptPayment', ['only' => ['paymentAccept']]);
        $this->middleware('permission:declinePayment', ['only' => ['paymentDecline']]);
        $this->middleware('permission:payPayment', ['only' => ['cashOutPay']]);


    }

    public function index(Request $request)
    {
        //

        $rows = Payment::latest();
        if ($request->filled('project_id')) {
            $rows->where('project_id', $request->project_id);


        }
        if ($request->filled('organization_id')) {
            $rows->where('organization_id', $request->organization_id);


        }

        if ($request->filled('employee_id')) {
            $rows->where('employee_id', $request->employee_id);


        }

        if ($request->filled('type')) {
            $rows->where('type', $request->type);


        }

        $rows = $rows->paginate(20);

        return view('admin.payment.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cashIn(Payment $model)
    {
//        return "asa";
        return view('admin.payment.cash_in', compact('model'));
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
            $safe = Safe::first();


            $row = Payment::create([
//            DB::table('client_transactions')->insert([

                'employee_id' => $request->employee_id,
                'amount' => $request->amount,
                'type' => 'cashin',
                'organization_id' => $request->organization_id,
                'project_id' => $request->project_id,
                'details' => $request->details,
//                'description' => $request->description,
                'date' => $request->date,
//                'balance' => $safe->balance,
//                'new_balance' => $safe->balance + $request->amount,


            ]);

            SafeTransaction::create([
                'safe_id' => $safe->id,
                'payment_id' => $row->id,
                'amount' => $request->amount,

                'balance' => $safe->balance,
                'new_balance' => $safe->balance + $request->amount,


            ]);
            $safe->balance = $safe->balance + $request->amount;
            $safe->save();
//        $client->roles()->sync($request->input('role'));
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/payments/');

                }
            }

//        $client->roles()->sync($request->input('role'));
            DB::commit();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('new cash in id :subject.id ');

            $notifiers = User::permission('managerNotification')->get();

            $title = 'Payment';
            $message = 'New Safe Cash in # ' . $row->id . ' Added by (' . auth()->user()->name . ') ';
            $link = url('admin/payment/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/payment');


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

    public function cashOut(Payment $model)
    {
//        return "asa";
        return view('admin.payment.cash_out', compact('model'));
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
//            'category_id' => 'required|exists:categories,id',
//            'labors_department_id' => 'required|exists:labors_departments,id',
//            'labors_type' => 'required|in:na,all,supervisor,technical,assistant,worker',


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
            $safe = Safe::first();
            $row = Payment::create([
//            DB::table('client_transactions')->insert([

                'employee_id' => $request->employee_id,
                'amount' => $request->amount,
                'organization_id' => $request->organization_id,
                'project_id' => $request->project_id,
                'details' => $request->details,
//                'description' => $request->description,
                'date' => $request->date,
                'type' => 'cashout',
                'payment_status' => 'review',
//                'balance' => $safe->balance,
//                'new_balance' => $safe->balance + $request->amount,
//                'category_id' => $request->category_id,
//                'labors_department_id' => $request->labors_department_id,
//                'labors_type' => $request->labors_type,


            ]);
//            $safe->balance = $safe->balance + $request->amount;
//            $safe->save();
//        $client->roles()->sync($request->input('role'));
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/payments/');

                }
            }

//        $client->roles()->sync($request->input('role'));
            DB::commit();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('new cash out request id :subject.id ');


            $notifiers = User::permission('managerNotification')->get();
            $title = 'Payment';
            $message = 'New Safe Cash out # ' . $row->id . ' Added by (' . auth()->user()->name . ')  and needs your Approval';
            $link = url('admin/payment/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/payment');


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


    public function custody(Payment $model)
    {
//        return "asa";
        return view('admin.payment.custody', compact('model'));
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
            $safe = Safe::first();

            if ($request->amount > $safe->balance) {
                DB::rollBack();
                return back()->withErrors(trans('main.amount_bigger_than_safe_balance'))->withInput();
            }
            $row = Payment::create([
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
                'payment_status' => 'review',
//                'balance' => $safe->balance,
//                'new_balance' => $safe->balance - $request->amount,


            ]);

//            SafeTransaction::create([
//                'safe_id' => $safe->id,
//                'payment_id' => $row->id,
//
//                'amount' => $request->amount,
//
//                'balance' => $safe->balance,
//                'new_balance' => $safe->balance - $request->amount,
//
//
//            ]);
//            $safe->balance = $safe->balance - $request->amount;
//            $safe->save();
//        $client->roles()->sync($request->input('role'));
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $this->addImage($image, $row->id, 'uploads/payments/');

                }
            }
            DB::commit();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('new custody id :subject.id ');
            $notifiers = User::permission('managerNotification')->get();
            $title = 'Payment';
            $message = 'New Safe Custody # ' . $row->id . ' Added by (' . auth()->user()->name . ')  and needs your Approval';
            $link = url('admin/payment/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
//        $client->roles()->sync($request->input('role'));
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/payment');


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
        $model = Payment::where('id', $id)->where('status', 'open')->first();
        if ($model->payment_status != 'paid') {
//            dd($model->payment_status);
            return back();
        }

        return view('admin.payment.custody_rest', compact('model'));
    }

    public function custodyToLoan($id)
    {
        $custody = Payment::where('id', $id)->where('status', 'open')->first();
        if ($custody->payment_status != 'paid') {
            return back();
        }
        DB::beginTransaction();
        try {

            $custody->update([
                'status'    =>  'closed',
                'is_to_loan'    =>  1,
            ]);

            $row = Accounting::create([

                'date' => now(),
                'amount' => $custody->amount,
                'type' => 'employeeLoan',
                'safe_id' => 0,
                'employee_id' => $custody->employee_id,
                'details' => $custody->details,
                'payment_status' => "confirmed",
                'manager_status' => "accept",
                'is_was_custody' => 1,

            ]);


            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('Employee Custody to Loan request id :subject.id  ');


            DB::commit();

            toastr()->success(trans('main.save_done_successfully'));
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
            $parent = Payment::find($request->id);

            $row = Payment::create([


                'amount' => $request->rest,

                'type' => 'custodyRest',


                'payment_id' => $parent->id,
//                'balance' => $safe->balance,
//                'new_balance' => $safe->balance + $request->rest,


            ]);
            SafeTransaction::create([

                'safe_id' => $safe->id,
                'payment_id' => $row->id,
                'amount' => $request->rest,

                'balance' => $safe->balance,
                'new_balance' => $safe->balance + $request->rest,


            ]);
            $parent->status = 'closed';
            $parent->save();
            $safe->balance = $safe->balance + $request->rest;
            $safe->save();
            DB::commit();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('new custody rest id :subject.id ');
            $notifiers = User::permission(['accountantNotification', 'managerNotification'])->get();
            $title = 'Payment';
            $message = 'New Safe Custody Rest # ' . $row->id . ' Added by (' . auth()->user()->name . ') ';
            $link = url('admin/payment/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
            toastr()->success(trans('main.save_done_successfully'));
            return redirect('admin/payment');


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
    /**
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {

        if ($request->filled('notification')) {
            $notification = auth()->user()->unreadNotifications()->where('id', $request->notification)->first();
            if ($notification) {

                $notification->markAsRead();
            }
        }
//        return "asa";
        $row = Payment::find($id);
        return view('admin.payment.show', compact('row'));
    }


    public function paymentAccept(Request $request)
    {
//        return "asa";
        $row = Payment::find($request->id);
        $row->payment_status = "waiting";
        $row->save();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The '. $row->type.' request id :subject.id  accepted');
        $notifiers = User::permission('safeNotification')->get();
//        $notifiers = User::permission(['accountantNotification', 'managerNotification'])->get();
        $title = 'Payment';

        $message = 'New Safe '. $row->type.'  # ' . $row->id . ' Accepted by (' . auth()->user()->name . ') and needs your Approval ';
        $link = url('admin/payment/' . $row->id);
        PusherNotification::sendAll($notifiers, $title, $message, $link);
        toastr()->success(trans('main.confirm_done_successfully'));

        return back();

    }

    public function paymentDecline(Request $request)
    {
//        return "asa";
        $row = Payment::find($request->id);
        $row->payment_status = "cancel";
        $row->save();
        activity()
            ->performedOn($row)
            ->causedBy(auth()->user())
            ->log('The '. $row->type.' request id :subject.id  declined');
        $notifiers = User::permission('safeNotification')->get();

        $title = 'Payment';

        $message = 'New Safe '. $row->type.'  # ' . $row->id . ' Declined by (' . auth()->user()->name . ')  ';
        $link = url('admin/payment/' . $row->id);
        PusherNotification::sendAll($notifiers, $title, $message, $link);
        toastr()->success(trans('main.decline_done_successfully'));

        return back();

    }

    public function cashOutPay(Request $request)
    {

//return $request->all();


        DB::beginTransaction();
        try {
            $row = Payment::find($request->id);


            $safe = Safe::first();
//dd($safe);
            if ($row->amount > $safe->balance) {
                DB::rollBack();
                return back()->withErrors(trans('main.amount_bigger_than_safe_balance'))->withInput();
            }

            $row->payment_status = "paid";
            $row->save();

            SafeTransaction::create([


                'safe_id' => $safe->id,
                'payment_id' => $row->id,
                'amount' => $row->amount,

                'balance' => $safe->balance,
                'new_balance' => $safe->balance - $row->amount,


            ]);


            $safe->balance = $safe->balance - $row->amount;
            $safe->save();


            DB::commit();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log('The payment  request id :subject.id  paid');
            $notifiers = User::permission(['accountantNotification', 'managerNotification'])->get();
            $title = 'Payment';
            $message = 'New Safe Custody  # ' . $row->id . ' Paid by (' . auth()->user()->name . ') ';
            $link = url('admin/payment/' . $row->id);
            PusherNotification::sendAll($notifiers, $title, $message, $link);
            toastr()->success(trans('main.pay_done_successfully'));
            return back();


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


//        return view('admin.payment.show', compact('row'));
    }



//    public function paymentCustodyAccept(Request $request)
//    {
////        return "asa";
//        $row = Payment::find($request->id);
//        $row->payment_status = "waiting";
//        $row->save();
//        activity()
//            ->performedOn($row)
//            ->causedBy(auth()->user())
//            ->log('The payment custody request id :subject.id  accepted');
//        toastr()->success(trans('main.confirm_done_successfully'));
//
//        return back();
//
//    }
//
//    public function paymentCustodyDecline(Request $request)
//    {
////        return "asa";
//        $row = Payment::find($request->id);
//        $row->payment_status = "cancel";
//        $row->save();
//        activity()
//            ->performedOn($row)
//            ->causedBy(auth()->user())
//            ->log('The payment custody request id :subject.id  declined');
//        toastr()->success(trans('main.decline_done_successfully'));
//
//        return back();
//
//    }
//    public function custodyPay(Request $request)
//    {
//
////return $request->all();
//
//
//        DB::beginTransaction();
//        try {
//            $row = Payment::find($request->id);
//
//
//            $safe = Safe::first();
////dd($safe);
//            if ($row->amount > $safe->balance) {
//                DB::rollBack();
//                return back()->withErrors(trans('main.amount_bigger_than_safe_balance'))->withInput();
//            }
//
//            $row->payment_status = "paid";
//            $row->save();
//
//            SafeTransaction::create([
//
//
//                'safe_id' => $safe->id,
//                'payment_id' => $row->id,
//                'amount' => $row->amount,
//
//                'balance' => $safe->balance,
//                'new_balance' => $safe->balance - $row->amount,
//
//
//            ]);
//
//
//            $safe->balance = $safe->balance - $row->amount;
//            $safe->save();
//
//
//
//            activity()
//                ->performedOn($row)
//                ->causedBy(auth()->user())
//                ->log('The payment custody request id :subject.id  paid');
//            DB::commit();
//            toastr()->success(trans('main.pay_done_successfully'));
//            return back();
//
//
//        } catch (\Exception $e) {
//            DB::rollBack();
////            dd($e->getMessage());
////            return $e->getMessage();
////            $error = $e->getMessage();
////            $html = view('partials.errors', compact('error'))->render();
////            $data = [
////                'status' => false,
////                'errors' => $html,
////            ];
//
////            return response()->json($data, 422);
////            flash()->error($e->getMessage());
//            return back()->withErrors($e->getMessage())->withInput();
////            return back();
//
//
//        } catch (\Illuminate\Database\QueryException $ex) {
//            DB::rollBack();
////            dd(456);
////            $error = $ex->errorInfo[2];
////            $html = view('partials.errors', compact('error'))->render();
////            $data = [
////                'status' => false,
////                'errors' => $html,
////            ];
//
////            return response()->json($data, 422);
////            flash()->error($ex->errorInfo[2]);
//
//            return back()->withErrors($ex->errorInfo[2])->withInput();
//
//        }
//
//
////        return view('admin.payment.show', compact('row'));
//    }


    public function changeStatus(Request $request)
    {
//        return "asa";
        $row = Payment::find($request->id);
        $row->payment_status = $request->payment_status;
        $row->save();
        if ($request->payment_status == "waiting") {

            toastr()->success(trans('main.confirm_done_successfully'));
        } elseif ($request->payment_status == "cancel") {
            toastr()->success(trans('main.decline_done_successfully'));
        }
        return back();

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
        $addImage->payment_id = $id;
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
