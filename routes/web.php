<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear ');
    Artisan::call('view:clear');
    return "Cache is cleared";
});
Route::get('/', function () {
//    dd(123);
//    return view('welcome');
    return redirect('admin');
    return view('admin.index');
})->middleware('auth:web');
Route::get('/login', 'Admin\AuthController@showLoginForm')->name('showLoginForm');
Route::post('/login', 'Admin\AuthController@login')->name('login');

Route::get('/logout', 'Admin\AuthController@logout');
Route::group(['middleware' => ['auth:web'], 'prefix' => 'admin'], function () {
    Route::get('change-language', 'Admin\LanguageController@changeLanguage')->name('change-language');
//    Route::get('/', function () {
//        return view('admin.index');
//    });
//    Route::get( 'dates', 'Admin\AjaxController@dates' );
    Route::post('cities', 'Admin\AjaxController@cities');
    Route::post('states', 'Admin\AjaxController@states');
    Route::post('sub-cats', 'Admin\AjaxController@subCats');
    Route::post('delete-employee-image', 'Admin\AjaxController@deleteEmployeeImage');

    Route::post('save-project', 'Admin\AjaxController@saveProject');
    Route::get('/', 'Admin\HomeController@index');
    Route::resource('city', 'Admin\CityController');
    Route::resource('category', 'Admin\CategoryController');
    Route::resource('department', 'Admin\DepartmentController');
    Route::resource('organization', 'Admin\OrganizationController');
    Route::resource('project', 'Admin\ProjectController');
    Route::resource('unit', 'Admin\UnitController');
    Route::resource('labors-department', 'Admin\LaborsDepartmentController');
    Route::resource('labors-group', 'Admin\LaborsGroupController');
    Route::resource('contract-type', 'Admin\ContractTypeController');
    Route::resource('user', 'Admin\UserController');
    Route::resource('university', 'Admin\UniversityController');
    Route::resource('bank', 'Admin\BankController');
    Route::resource('job', 'Admin\JobController');
    Route::resource('worker-job', 'Admin\WorkerJobController');
    Route::resource('employee', 'Admin\EmployeeController');


    Route::get('worker-import', 'Admin\WorkerController@import');
    Route::post('worker-import-save', 'Admin\WorkerController@importSave');

    Route::get('worker-print-details/{id}', 'Admin\WorkerController@workerPrintDetails');

    Route::resource('worker', 'Admin\WorkerController');

    Route::get('contract-print/{id}', 'Admin\ContractController@detailsPrint');
    Route::resource('contract', 'Admin\ContractController');
    Route::get('/contract/download/{file}', 'Admin\ContractController@download')->name('contract_download');
    Route::get('/sub_contract/download/{file}', 'Admin\SubContractController@download')->name('sub_contract_download');


    Route::get('sub-contract-print/{id}', 'Admin\SubContractController@detailsPrint');
    Route::resource('sub-contract', 'Admin\SubContractController');


    Route::get('application-worker-import', 'Admin\ApplicantWorkerController@import');
    Route::post('application-worker-import-save', 'Admin\ApplicantWorkerController@importSave');
    Route::post('accept-worker-applicant', 'Admin\ApplicantWorkerController@acceptWorkerApplicant')->name('acceptWorkerApplicant');
//    Route::post('accept-worker-applicant-save/{id}', 'Admin\ApplicantWorkerController@acceptWorkerApplicantSave');
    Route::post('approve-worker-applicant', 'Admin\ApplicantWorkerController@approveWorkerApplicant')->name('approveWorkerApplicant');
    Route::post('cancel-worker-applicant', 'Aread_alldmin\ApplicantWorkerController@cancelWorkerApplicant');
    Route::resource('applicant-worker', 'Admin\ApplicantWorkerController');


    Route::get('print-letter/{id}', 'Admin\ApplicantEmployeeController@printLetter');
    Route::get('accept-employee-applicant/{id}', 'Admin\ApplicantEmployeeController@acceptEmployeeApplicant');
    Route::post('accept-employee-applicant-save/{id}', 'Admin\ApplicantEmployeeController@acceptEmployeeApplicantSave');
    Route::post('approve-employee-applicant', 'Admin\ApplicantEmployeeController@approveEmployeeApplicant')->name('approveEmployeeApplicant');
    Route::post('cancel-employee-applicant', 'Admin\ApplicantEmployeeController@cancelEmployeeApplicant');
    Route::resource('applicant-employee', 'Admin\ApplicantEmployeeController');

    Route::resource('country', 'Admin\CountryController');
    Route::resource('state', 'Admin\StateController');
    Route::resource('city', 'Admin\CityController');
    Route::get('setting', 'Admin\SettingController@view');
    Route::post('setting', 'Admin\SettingController@save');

    Route::get('permissions/{id}', 'Admin\PermissionController@index')->name('permissions');
    Route::post('save-permissions', 'Admin\PermissionController@savePermissions')->name('savePermissions');
    Route::get('employee-print/{id}', 'Admin\EmployeeController@employeePrint');
    Route::get('worker-print/{id}', 'Admin\WorkerController@workerPrint');
    Route::get('employee-print-details/{id}', 'Admin\EmployeeController@employeePrintDetails');


    Route::resource('item', 'Admin\ItemController');
    Route::resource('stock-type', 'Admin\StockTypeController');
    Route::resource('stock-transaction', 'Admin\StockTransactionController');

//    Route::get('stock-in', 'Admin\StockTransactionController@stockIn');
//    Route::post('store-stock-in', 'Admin\StockTransactionController@storeStockIn');
//    Route::get('stock-out', 'Admin\StockTransactionController@stockOut');
//    Route::post('store-stock-out', 'Admin\StockTransactionController@storeStockOut');
    Route::post('stock-approve', 'Admin\StockOrderController@stockApprove')->name('stock-approve');//->middleware('throttle:1,1');
    Route::post('stock-accept', 'Admin\StockOrderController@stockAccept')->name('stock-accept');//->middleware('throttle:1,1');
    Route::post('stock-decline', 'Admin\StockOrderController@stockDecline')->name('stock-decline');//->middleware('throttle:1,1');
    Route::get('stock-in', 'Admin\StockOrderController@stockIn');
    Route::post('store-stock-in', 'Admin\StockOrderController@storeStockIn');
    Route::get('stock-out', 'Admin\StockOrderController@stockOut');
    Route::post('store-stock-out', 'Admin\StockOrderController@storeStockOut');
    Route::resource('stock-order', 'Admin\StockOrderController');
    Route::get('template-cash-in', 'Admin\TemplateController@cashIn');

    Route::resource('file', 'Admin\FileController');


    Route::get('cash-out', 'Admin\PaymentController@cashOut');
    Route::post('store-cash-out', 'Admin\PaymentController@storeCashOut');

    Route::get('custody-rest/{id}', 'Admin\PaymentController@custodyRest');
    Route::get('custody-to-loan/{id}', 'Admin\PaymentController@custodyToLoan');
    Route::get('stock_out-to-loan/{id}', 'Admin\StockOrderController@stockOutToLoan');
    Route::post('store-custody-rest', 'Admin\PaymentController@storeCustodyRest');


    Route::get('custody', 'Admin\PaymentController@custody');
    Route::post('store-custody', 'Admin\PaymentController@storeCustody');

    Route::get('cash-in', 'Admin\PaymentController@cashIn');
    Route::post('store-cash-in', 'Admin\PaymentController@storeCashIn');
    Route::post('payment-accept', 'Admin\PaymentController@paymentAccept')->name('payment-accept');//->middleware('throttle:1,1');
    Route::post('payment-decline', 'Admin\PaymentController@paymentDecline')->name('payment-decline');//->middleware('throttle:1,1');
    Route::post('cash-out-pay', 'Admin\PaymentController@cashOutPay')->name('cash-out-pay');//->middleware('throttle:1,1');

//    Route::post('payment-custody-accept', 'Admin\PaymentController@paymentCustodyAccept')->name('payment-custody-accept');
//    Route::post('payment-custody-decline', 'Admin\PaymentController@paymentCustodyDecline')->name('payment-custody-decline');
//    Route::post('custody-pay', 'Admin\PaymentController@custodyPay')->name('custody-pay');

    Route::resource('payment', 'Admin\PaymentController');


    Route::resource('safe-transaction', 'Admin\SafeTransactionController');


    Route::resource('bank-account', 'Admin\BankAccountController');
    Route::resource('accounting-cash-in', 'Admin\AccountingCashInController');
    Route::resource('accounting-cash-out', 'Admin\AccountingCashOutController');
    Route::resource('accounting', 'Admin\AccountingController');
    Route::get('accounting-request', 'Admin\AccountingController@accountingRequest');
    Route::post('accounting-change-status', 'Admin\AccountingController@changeStatus')->name('accounting-change-status');//->middleware('throttle:1,1');
    Route::get('create-expense', 'Admin\InvoiceController@createExpense');
    Route::post('save-expense', 'Admin\InvoiceController@saveExpense');


    Route::post('invoice-manager-change-status', 'Admin\InvoiceController@managerChangeStatus')->name('invoice-manager-change-status');//->middleware('throttle:1,1');
    Route::post('invoice-safe-change-status', 'Admin\InvoiceController@safeChangeStatus')->name('invoice-safe-change-status');
//    Route::post('invoice-stock-change-status', 'Admin\InvoiceController@stockChangeStatus')->name('invoice-stock-change-status');
    Route::get('invoice-print/{id}', 'Admin\InvoiceController@invoicePrint');
    Route::resource('invoice', 'Admin\InvoiceController');
//    Route::resource('expense', 'Admin\ExpenseController');
    Route::resource('expense-item', 'Admin\ExpenseItemController');

    Route::get('extract-print/{id}', 'Admin\ExtractController@detailsPrint');


    Route::resource('extract', 'Admin\ExtractController');
    Route::get('main_extract', 'Admin\ExtractController@mainIndex');
    Route::get('main_extract/create', 'Admin\ExtractController@mainCreate');
    Route::get('main_extract/edit/{extract}', 'Admin\ExtractController@mainEdit')->name('main_extract.edit');
    Route::put('main_extract/{extract}', 'Admin\ExtractController@mainUpdate');
    Route::post('main_extract', 'Admin\ExtractController@mainStore');
    Route::resource('contract.extract', 'Admin\ContractExtractController');
    Route::resource('extract-item', 'Admin\ExtractItemController');
    Route::resource('contact', 'Admin\ContactController');
    Route::resource('color', 'Admin\ColorController');
    Route::resource('size', 'Admin\SizeController');
    Route::get('worker-time-sheet-history', 'Admin\WorkerTimeSheetController@workerTimeSheetHistory');
    Route::get('employee-time-sheet-history/delete/{id}', 'Admin\EmployeeTimeSheetController@destroyGET');
    Route::get('worker-time-sheet-history/delete/{id}', 'Admin\WorkerTimeSheetController@destroyGET');
    Route::get('employee-time-sheet-history', 'Admin\EmployeeTimeSheetController@employeeTimeSheetHistory');
    Route::post('employee-time-sheet-history/updateAll', 'Admin\EmployeeTimeSheetController@updateAll');
    Route::post('worker-time-sheet-history/updateAll', 'Admin\WorkerTimeSheetController@updateAll');
    Route::get('worker-time-sheet-productivity', 'Admin\WorkerTimeSheetController@workerTimeSheetProductivity');
    Route::post('worker-time-sheet-productivity-save', 'Admin\WorkerTimeSheetController@storeProductivity');
    Route::resource('worker-time-sheet', 'Admin\WorkerTimeSheetController');
    Route::resource('employee-time-sheet', 'Admin\EmployeeTimeSheetController');
    Route::resource('activity-log', 'Admin\ActivityLogController');
//    Route::get('accounting-new-cash-in', 'Admin\AccountingController@newCashIn');
//    Route::post('accounting-store-cash-in', 'Admin\AccountingController@storeCashIn');


    Route::resource('stock', 'Admin\StockController');
    Route::get('stock-accounting-request', 'Admin\StockController@accountingRequest');
    Route::post('stock-accounting-change-status', 'Admin\StockController@changeStatus')->name('stock-accounting-change-status');//->middleware('throttle:1,1');
    Route::resource('worker-classification', 'Admin\WorkerClassificationController');

    Route::post('worker-loan-manager-change-status', 'Admin\WorkerLoanController@managerChangeStatus')->name('worker-loan-manager-change-status');//->middleware('throttle:1,1');

    Route::post('worker-loan-manager-change-statuses', 'Admin\WorkerLoanController@managerChangeStatuses')->name('worker-loan-manager-change-statuses');//->middleware('throttle:1,1');

    Route::post('worker-loan-safe-change-status', 'Admin\WorkerLoanController@safeChangeStatus')->name('worker-loan-safe-change-status');//->middleware('throttle:1,1');

    Route::resource('worker-loan', 'Admin\WorkerLoanController');

    Route::get('worker-salary-print/{id}', 'Admin\WorkerSalaryController@detailsPrint')->name('worker-salary-print');
    Route::post('worker-salary-manager-change-status', 'Admin\WorkerSalaryController@managerChangeStatus')->name('worker-salary-manager-change-status');//->middleware('throttle:1,1');
    Route::post('worker-salary-safe-change-status', 'Admin\WorkerSalaryController@safeChangeStatus')->name('worker-salary-safe-change-status');//->middleware('throttle:1,1');

    Route::resource('worker-salary', 'Admin\WorkerSalaryController');


    Route::post('employee-loan-manager-change-status', 'Admin\EmployeeLoanController@managerChangeStatus')->name('employee-loan-manager-change-status');//->middleware('throttle:1,1');
    Route::post('employee-loan-safe-change-status', 'Admin\EmployeeLoanController@safeChangeStatus')->name('employee-loan-safe-change-status');//->middleware('throttle:1,1');

    Route::resource('employee-loan', 'Admin\EmployeeLoanController');
    Route::resource('employee-monthly-evaluation', 'Admin\EmployeeMonthlyEvaluationController');

    Route::get('employee-salary-print/{id}', 'Admin\EmployeeSalaryController@detailsPrint')->name('employee-salary-print');


    Route::post('employee-salary-manager-change-status', 'Admin\EmployeeSalaryController@managerChangeStatus')->name('employee-salary-manager-change-status');//->middleware('throttle:1,1');
    Route::post('employee-salary-safe-change-status', 'Admin\EmployeeSalaryController@safeChangeStatus')->name('employee-salary-safe-change-status');//->middleware('throttle:1,1');

    Route::resource('employee-salary', 'Admin\EmployeeSalaryController');
    Route::resource('penalty', 'Admin\PenaltyController');


    Route::resource('notification', 'Admin\NotificationController');
    Route::post('get-notifications', 'Admin\NotificationController@getNotifications');
    Route::get('read_all-notification', 'Admin\NotificationController@readNotifications');

    Route::get('accounting-safe-transaction', 'Admin\BankAccountTransactionController@accountingSafeTransaction');
    Route::get('accounting-bank-account-transaction', 'Admin\BankAccountTransactionController@accountingBankAccountTransaction');
    Route::get('backup','Admin\BackupController@backup');
    Route::post('backup','Admin\BackupController@backupSave');

    Route::get('organization/{organization}/projects' , 'Admin\OrganizationController@projects');
    Route::get('organization/{organization}/contracts' , 'Admin\OrganizationController@contracts');
    Route::get('sub_contract/{sub_contract}/items' , 'Admin\SubContractController@items');
    Route::get('contract/{contract}/items' , 'Admin\ContractController@items');
    Route::get('item/{item}/sizes' , 'Admin\ItemController@sizes');
    Route::get('item/{item}/colors' , 'Admin\ItemController@colors');


    /* Reports */
    Route::get('reports/direct_cost' , 'Admin\ReportController@directCost');
    Route::get('reports/direct_cost/worker_salaries' , 'Admin\ReportController@directWorkerSalaries');
    Route::get('reports/direct_cost/invoices' , 'Admin\ReportController@directInvoices');
    Route::get('reports/direct_cost/extracts' , 'Admin\ReportController@directExtracts');

    Route::get('reports/indirect_cost' , 'Admin\ReportController@indirectCost');
    Route::get('reports/indirect_cost/employee_salaries' , 'Admin\ReportController@indirectEmployeeSalaries');
    Route::get('reports/indirect_cost/expenses' , 'Admin\ReportController@indirectExpenses');

    Route::get('reports/stock' , 'Admin\ReportController@stockItems');
    Route::get('reports/stock/details/{item}' , 'Admin\ReportController@stockItemDetails')->name('stock_items_details');

    Route::get('reports/custody' , 'Admin\ReportController@custody');
    Route::get('reports/custody/details/{employee}' , 'Admin\ReportController@custodyDetails')->name('custody_details');

    Route::get('reports/cash_in' , 'Admin\ReportController@cashIn');

    Route::get('reports/employee_loans' , 'Admin\ReportController@employeeLoans');
    Route::get('reports/worker_loans' , 'Admin\ReportController@workerLoans');

    Route::get('reports/organizations' , 'Admin\ReportController@organizations');
    Route::get('reports/organization/details/{organization}' , 'Admin\ReportController@organizations_details')->name('organizations_details');


    /* Excel Exports*/
    Route::get('excel/worker_salaries','Admin\WorkerSalaryController@exportExcel')->name('worker_salaries.export');
    Route::get('excel/workers}','Admin\WorkerController@exportExcel')->name('workers.export');
    Route::get('excel/employees}','Admin\EmployeeController@exportExcel')->name('employees.export');
    Route::get('excel/worker_time_sheet_history','Admin\WorkerTimeSheetController@exportExcel')->name('worker_time_sheet_history.export');
    Route::get('excel/employee_time_sheet_history','Admin\EmployeeTimeSheetController@exportExcel')->name('employee_time_sheet_history.export');

});
