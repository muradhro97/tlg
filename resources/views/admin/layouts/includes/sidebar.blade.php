<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong
                                        class="font-bold">{{auth()->user()->name}}</strong>
                             </span> <span class="text-muted text-xs block">{{trans('main.admin')}}
                                    <b
                                        class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{url('admin/profile')}}">{{trans('main.profile')}}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{url('logout')}}">{{trans('main.logout')}}</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    Ds
                </div>
            </li>

            @can('homeReport')
            <li class="@if(request()->is('admin')) active @endif">
                <a href="{{url('/admin')}}"><i class="fa fa-home"></i> <span
                        class="nav-label">{{trans('main.home')}}</span></a>
            </li>
            @endcan
            
            @canany(['allEmp','allWor','addWorTime','historyWorTime','addEmpTime','historyEmpTime','allEmpApp','allWorApp'])

                <li>
                    <a href="#"><i class="fa fa-group"></i> <span
                            class="nav-label">{{trans('main.hr')}} </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @canany(['allEmp','allWor'])
                            <li>
                                <a href="#"><i class="fa fa-users"></i>{{trans('main.employees')}} <span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    @can('allEmp')
                                        <li class="@if(request()->is('admin/employee')) active @endif">
                                            <a href="{{url('admin/employee')}}"> <i
                                                    class="fa fa-user-o"></i>{{trans('main.employees')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('allWor')
                                        <li class="@if(request()->is('admin/worker')) active @endif">
                                            <a href="{{url('admin/worker')}}"> <i
                                                    class="fa fa-user-o"></i>{{trans('main.workers')}}
                                            </a>
                                        </li>
                                    @endcan


                                </ul>
                            </li>
                        @endcanany
                        @canany(['addWorTime','historyWorTime','addEmpTime','historyEmpTime'])
                            <li>
                                <a href="#"><i class="fa fa-clock-o"></i>{{trans('main.time_sheets')}} <span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">


                                    @can('addWorTime')
                                        <li class="@if(request()->is('admin/worker-time-sheet')) active @endif">
                                            <a href="{{url('admin/worker-time-sheet')}}"> <i
                                                    class="fa fa-user-times"></i>{{trans('main.worker_time_sheet')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('historyWorTime')
                                        <li class="@if(request()->is('admin/worker-time-sheet-history')) active @endif">
                                            <a href="{{url('admin/worker-time-sheet-history')}}"> <i
                                                    class="fa fa-history"></i>{{trans('main.worker_time_sheet_history')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('addEmpTime')
                                        <li class="@if(request()->is('admin/employee-time-sheet')) active @endif">
                                            <a href="{{url('admin/employee-time-sheet')}}"> <i
                                                    class="fa fa-user-times"></i>{{trans('main.employee_time_sheet')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('historyEmpTime')
                                        <li class="@if(request()->is('admin/employee-time-sheet-history')) active @endif">
                                            <a href="{{url('admin/employee-time-sheet-history')}}"> <i
                                                    class="fa fa-history"></i>{{trans('main.employee_time_sheet_history')}}
                                            </a>
                                        </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcanany
                        @canany(['allEmpApp','allWorApp'])
                            <li>
                                <a href="#"><i class="fa fa-file"></i>{{trans('main.applicants')}} <span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    @can('allEmpApp')
                                        <li class="@if(request()->is('admin/applicant-employee')) active @endif">
                                            <a href="{{url('admin/applicant-employee')}}"><i
                                                    class="fa fa-file-text"></i>{{trans('main.applicant_employees')}}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('allWorApp')
                                        <li class="@if(request()->is('admin/applicant-worker')) active @endif">
                                            <a href="{{url('admin/applicant-worker')}}"><i
                                                    class="fa fa-file-text"></i>{{trans('main.applicant_workers')}}</a>
                                        </li>

                                    @endcan
                                    <li class="@if(request()->is('admin/application-worker-import')) active @endif">
                                        <a href="{{url('admin/application-worker-import')}}"> <i
                                                class="fa fa-sign-in"></i>{{trans('main.application_worker_import')}}
                                        </a>
                                    </li>

                                    <li class="@if(request()->is('admin/worker-import')) active @endif">
                                        <a href="{{url('admin/worker-import')}}"> <i
                                                class="fa fa-sign-in"></i>{{trans('main.worker_import')}}
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        @endcanany

                        @can('allEmpMonthlyEvaluation')
                            <li class="@if(request()->is('admin/employee-monthly-evaluation')) active @endif">
                                <a href="{{url('admin/employee-monthly-evaluation')}}"><i
                                        class="fa fa-star-half-full"></i>{{trans('main.employee_monthly_evaluations')}}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany(['allContract','allSubContract','allExtractItem','allExtract'])
                <li>
                    <a href="#"><i class="fa fa-file-text"></i> <span
                            class="nav-label">{{trans('main.contracts')}} </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @canany(['allContract','allMainExtract'])
                            <li>
                                <a href="#"><i class="fa fa-file-text"></i> <span
                                        class="nav-label">{{trans('main.main')}} </span><span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    @can('allContract')
                                        <li class="@if(request()->is('admin/contract')) active @endif">
                                            <a href="{{url('admin/contract')}}"> <i
                                                    class="fa fa-file"></i>{{trans('main.main_contracts')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('allMainExtract')
                                        <li class="@if(request()->is('admin/main_extract')) active @endif">
                                            <a href="{{url('admin/main_extract')}}"> <i
                                                    class="fa fa-file-excel-o"></i>{{trans('main.main_extracts')}}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                        @canany(['allSubContract','allExtract'])
                            <li>
                                <a href="#"><i class="fa fa-file-text"></i> <span
                                        class="nav-label">{{trans('main.sub')}} </span><span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                    @can('allSubContract')
                                        <li class="@if(request()->is('admin/sub-contract')) active @endif">
                                            <a href="{{url('admin/sub-contract')}}"><i
                                                    class="fa fa-file-text"></i>{{trans('main.sub_contracts')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('allExtract')
                                        <li class="@if(request()->is('admin/extract')) active @endif">
                                            <a href="{{url('admin/extract')}}"> <i
                                                    class="fa fa-file-excel-o"></i>{{trans('main.extracts')}}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                    </ul>
                </li>
            @endcanany

            @canany(['allStockType','stockOrder','stockTransaction','allItem'])
                <li>
                    <a href="#"><i class="fa fa-database"></i> <span
                            class="nav-label">{{trans('main.stock')}} </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">

                        @can('allStockType')
                            <li class="@if(request()->is('admin/stock-type')) active @endif">
                                <a href="{{url('admin/stock-type')}}"> <i
                                        class="fa fa-th-list"></i>{{trans('main.stock_types')}}
                                </a>
                            </li>
                        @endcan
                        @can('stockOrder')
                            <li class="@if(request()->is('admin/stock-order')) active @endif">
                                <a href="{{url('admin/stock-order')}}"> <i
                                        class="fa fa-first-order"></i>{{trans('main.stock_orders')}}
                                </a>
                            </li>
                        @endcan
                        @can('stockTransaction')
                            <li class="@if(request()->is('admin/stock-transaction')) active @endif">
                                <a href="{{url('admin/stock-transaction')}}"> <i
                                        class="fa fa-spinner"></i>{{trans('main.stock_transactions')}}
                                </a>
                            </li>
                        @endcan
                        @can('allItem')
                            <li class="@if(request()->is('admin/item')) active @endif">
                                <a href="{{url('admin/item')}}"> <i class="fa fa-square"></i>{{trans('main.item')}}
                                </a>
                            </li>
                        @endcan

                        <li class="@if(request()->is('admin/stock-accounting-request')) active @endif">
                            <a href="{{url('admin/stock-accounting-request')}}"> <i
                                    class="fa fa-universal-access"></i>{{trans('main.accounting_request')}}
                            </a>
                        </li>
                    </ul>
                </li>
            @endcanany
            @canany(['payment','accountingRequest','safeTransaction'])
                <li>
                    <a href="#"><i class="fa fa-dollar"></i> <span
                            class="nav-label">{{trans('main.safe')}} </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @can('payment')
                            <li class="@if(request()->is('admin/payment')) active @endif">
                                <a href="{{url('admin/payment')}}"> <i
                                        class="fa fa-paypal"></i>{{trans('main.payment')}}
                                </a>
                            </li>
                        @endcan
                        @can('accountingRequest')
                            <li class="@if(request()->is('admin/accounting-request')) active @endif">
                                <a href="{{url('admin/accounting-request')}}"> <i
                                        class="fa fa-universal-access"></i>{{trans('main.accounting_request')}}
                                </a>
                            </li>
                        @endcan
                        @can('safeTransaction')
                            <li class="@if(request()->is('admin/safe-transaction')) active @endif">
                                <a href="{{url('admin/safe-transaction')}}"> <i
                                        class="fa fa-spinner"></i>{{trans('main.safe_transaction')}}
                                </a>
                            </li>
                        @endcan


                    </ul>
                </li>
            @endcanany
            @canany(['safeTransaction','allAccountingCashIn','allAccountingCashOut','allInvoice','allWorkerLoan','allEmployeeLoan','allWorkerSalary','allEmployeeSalary','allPenalty'])
            <li>
                <a href="#"><i class="fa fa-line-chart"></i> <span
                        class="nav-label">{{trans('main.accounting')}} </span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">

                    {{--<li class="@if(request()->is('admin/employee')) active @endif">--}}
                    {{--<a href="{{url('admin/cash-in')}}"> <i class="fa fa-user-o"></i>{{trans('main.accounting')}}--}}
                    {{--</a>--}}
                    {{--</li>--}}

                    @can('safeTransaction')
                        <li class="@if(request()->is('admin/accounting-safe-transaction')) active @endif">
                            <a href="{{url('admin/accounting-safe-transaction')}}"> <i
                                    class="fa fa-spinner"></i>{{trans('main.accounting_safe_transaction')}}
                            </a>
                        </li>
                    @endcan

                    @can('safeTransaction')
                        <li class="@if(request()->is('admin/accounting-bank-account-transaction')) active @endif">
                            <a href="{{url('admin/accounting-bank-account-transaction')}}"> <i
                                    class="fa fa-spinner"></i>{{trans('main.accounting_bank_account_transaction')}}
                            </a>
                        </li>
                    @endcan

                    @can('allAccountingCashIn')
                        <li class="@if(request()->is('admin/accounting-cash-in')) active @endif">
                            <a href="{{url('admin/accounting-cash-in')}}"> <i
                                    class="fa fa-dollar"></i>{{trans('main.actual_cash_in')}}
                            </a>
                        </li>
                    @endcan

                    @can('allAccountingCashOut')
                        <li class="@if(request()->is('admin/accounting-cash-out')) active @endif">
                            <a href="{{url('admin/accounting-cash-out')}}"> <i
                                    class="fa fa-dollar"></i>{{trans('main.cash_out')}}
                            </a>
                        </li>
                    @endcan

                    @can('allInvoice')
                        <li class="@if(request()->is('admin/invoice')) active @endif">
                            <a href="{{url('admin/invoice')}}"> <i
                                    class="fa fa-file-text"></i>{{trans('main.invoices')}}
                            </a>
                        </li>
                    @endcan

                    @canany(['allWorkerLoan','allEmployeeLoan'])
                        <li>
                            <a href="#"><i class="fa fa-arrow-circle-left"></i>{{trans('main.loans')}} <span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                @can('allWorkerLoan')
                                    <li class="@if(request()->is('admin/worker-loan')) active @endif">
                                        <a href="{{url('admin/worker-loan')}}"> <i
                                                class="fa fa-user-circle"></i>{{trans('main.worker_loans')}}
                                        </a>
                                    </li>
                                @endcan
                                @can('allEmployeeLoan')
                                    <li class="@if(request()->is('admin/employee-loan')) active @endif">
                                        <a href="{{url('admin/employee-loan')}}"> <i
                                                class="fa fa-user-circle"></i>{{trans('main.employee_loans')}}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany

                    @canany(['allWorkerSalary','allEmployeeSalary'])
                        <li>
                            <a href="#"><i class="fa fa-bank"></i>{{trans('main.salaries')}} <span
                                    class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                @can('allWorkerSalary')
                                    <li class="@if(request()->is('admin/worker-salary')) active @endif">
                                        <a href="{{url('admin/worker-salary')}}"> <i
                                                class="fa fa-user-circle"></i>{{trans('main.worker_salaries')}}
                                        </a>
                                    </li>
                                @endcan

                                @can('allEmployeeSalary')
                                    <li class="@if(request()->is('admin/employee-salary')) active @endif">
                                        <a href="{{url('admin/employee-salary')}}"> <i
                                                class="fa fa-user-circle"></i>{{trans('main.employee_salaries')}}
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    @endcanany

                    @can('allPenalty')
                        <li class="@if(request()->is('admin/penalty')) active @endif">
                            <a href="{{url('admin/penalty')}}"><i
                                    class="fa fa-dollar"></i>{{trans('main.penalties')}}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcanany

        @canany(['cashInReport','directCostReport','indirectCostReport','StockItemsReport','custodyReport','loansReport'])
                <li>
                    <a href="#"><i class="fa fa-dollar"></i> <span
                            class="nav-label">{{trans('main.reports')}} </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @can('cashInReport')
                            <li class="@if(request()->is('admin/reports/cash_in')) active @endif">
                                <a href="{{url('admin/reports/cash_in')}}"> <i
                                        class="fa fa-user-circle"></i>{{trans('main.cash_in')}}
                                </a>
                            </li>
                        @endcan
                        @canany(['directCostReport','indirectCostReport'])
                            <li>
                                <a href="#"><i class="fa fa-arrow-circle-left"></i>{{trans('main.cash_out')}} <span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    @can('directCostReport')
                                        <li class="@if(request()->is('admin/reports/direct_cost')) active @endif">
                                            <a href="{{url('admin/reports/direct_cost')}}"> <i
                                                    class="fa fa-user-circle"></i>{{trans('main.direct_cost')}}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('indirectCostReport')
                                        <li class="@if(request()->is('admin/reports/indirect_cost')) active @endif">
                                            <a href="{{url('admin/reports/indirect_cost')}}"> <i
                                                    class="fa fa-user-circle"></i>{{trans('main.indirect_cost')}}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('StockItemsReport')
                            <li class="@if(request()->is('admin/reports/stock')) active @endif">
                                <a href="{{url('admin/reports/stock')}}"> <i
                                        class="fa fa-user-circle"></i>{{trans('main.stock_items')}}
                                </a>
                            </li>
                        @endcan

                        @can('custodyReport')
                            <li class="@if(request()->is('admin/reports/custody')) active @endif">
                                <a href="{{url('admin/reports/custody')}}"> <i
                                        class="fa fa-user-circle"></i>{{trans('main.custody')}}
                                </a>
                            </li>
                        @endcan
                        @canany(['loansReport'])
                            <li>
                                <a href="#"><i class="fa fa-arrow-circle-left"></i>{{trans('main.loans')}} <span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    @can('loansReport')
                                        <li class="@if(request()->is('admin/reports/employee_loans')) active @endif">
                                            <a href="{{url('admin/reports/employee_loans')}}"> <i
                                                    class="fa fa-user-circle"></i>{{trans('main.employee_loans')}}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('loansReport')
                                        <li class="@if(request()->is('admin/reports/worker_loans')) active @endif">
                                            <a href="{{url('admin/reports/worker_loans')}}"> <i
                                                    class="fa fa-user-circle"></i>{{trans('main.worker_loans')}}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('organizationReport')
                            <li class="@if(request()->is('admin/reports/organizations')) active @endif">
                                <a href="{{url('admin/reports/organizations')}}"> <i
                                        class="fa fa-user-circle"></i>{{trans('main.organization cred/debt')}}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['allUser','activityLog'])
                <li>
                    <a href="#"><i class="fa fa-gear"></i> <span
                            class="nav-label">{{trans('main.system')}} </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @can('allUser')
                            <li class="@if(request()->is('admin/user')) active @endif">
                                <a href="{{url('admin/user')}}"> <i class="fa fa-user-o"></i>{{trans('main.users')}}
                                </a>
                            </li>
                        @endcan
                        @can('activityLog')
                            <li class="@if(request()->is('admin/activity-log')) active @endif">
                                <a href="{{url('admin/activity-log')}}"> <i
                                        class="fa fa-history"></i>{{trans('main.activity_logs')}}
                                </a>
                            </li>
                        @endcan
                        @can('backup')
                            <li class="@if(request()->is('admin/backup')) active @endif">
                                <a href="{{url('admin/backup')}}"> <i
                                        class="fa fa-database"></i>{{trans('main.backup')}}
                                </a>
                            </li>
                        @endcan


                    </ul>
                </li>
            @endcanany
            {{--<li class="@if(request()->is('admin/user')) active @endif">--}}
            {{--<a href="{{url('admin/user')}}"><i class="fa fa-user-o"></i> <span--}}
            {{--class="nav-label">{{trans('main.users')}}</span>--}}
            {{--</a>--}}
            {{--</li>--}}

            @canany(['allDepartment','allLaborDepartment','allLaborGroup','allCategory','allOrganization','allProject','allUnit','allBank','allBankAccount','allCountry','allState','allCity','allEmployeeJob','allWorkerJob','allUniversity','saveSettings','allContractType'])
                <li>
                    <a href="#"><i class="fa fa-sitemap"></i> <span
                            class="nav-label">{{trans('main.settings')}} </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @can('allContractType')
                            <li class="@if(request()->is('admin/contract-type')) active @endif">
                                <a href="{{url('admin/contract-type')}}"><i
                                        class="fa fa-file-text"></i> {{trans('main.contract_types')}}
                                </a>
                            </li>

                        @endcan
                        @can('allDepartment')
                            <li class="@if(request()->is('admin/department')) active @endif">
                                <a href="{{url('admin/department')}}"><i
                                        class="fa fa-list"></i> {{trans('main.departments')}}
                                </a>
                            </li>
                        @endcan
                        @can('allLaborDepartment')
                            <li class="@if(request()->is('admin/labors-department')) active @endif">
                                <a href="{{url('admin/labors-department')}}"><i
                                        class="fa fa-list-ol"></i> {{trans('main.labors_departments')}}
                                </a>
                            </li>
                        @endcan
                        @can('allLaborGroup')
                            <li class="@if(request()->is('admin/labors-group')) active @endif">
                                <a href="{{url('admin/labors-group')}}"><i
                                        class="fa fa-group"></i> {{trans('main.labors_groups')}}
                                </a>
                            </li>
                        @endcan
                        @can('allCategory')

                            <li class="@if(request()->is('admin/category')) active @endif">
                                <a href="{{url('admin/category')}}"><i
                                        class="fa fa-list-ul"></i> {{trans('main.categories')}}
                                </a>
                            </li>
                        @endcan
                        @can('allOrganization')
                            <li class="@if(request()->is('admin/organization')) active @endif">
                                <a href="{{url('admin/organization')}}"><i
                                        class="fa fa-group"></i> {{trans('main.organizations')}}
                                </a>
                            </li>
                        @endcan
                        @can('allProject')
                            <li class="@if(request()->is('admin/project')) active @endif">
                                <a href="{{url('admin/project')}}"><i
                                        class="fa fa-product-hunt"></i> {{trans('main.projects')}}
                                </a>
                            </li>
                        @endcan
                        @can('allUnit')
                            <li class="@if(request()->is('admin/unit')) active @endif">
                                <a href="{{url('admin/unit')}}"><i class="fa fa-th-large"></i> {{trans('main.units')}}
                                </a>
                            </li>
                        @endcan
                        @can('allBank')
                            <li class="@if(request()->is('admin/bank')) active @endif">
                                <a href="{{url('admin/bank')}}"><i class="fa fa-bank"></i> {{trans('main.banks')}}
                                </a>
                            </li>
                        @endcan
                        @can('allBankAccount')
                            <li class="@if(request()->is('admin/bank-account')) active @endif">
                                <a href="{{url('admin/bank-account')}}"><i
                                        class="fa fa-bank"></i> {{trans('main.bank_accounts')}}
                                </a>
                            </li>
                        @endcan
                        @can('allCountry')
                            <li class="@if(request()->is('admin/country')) active @endif">
                                <a href="{{url('admin/country')}}"><i class="fa fa-map"></i> {{trans('main.countries')}}
                                </a>
                            </li>
                        @endcan
                        @can('allCountry')
                            <li class="@if(request()->is('admin/contact')) active @endif">
                                <a href="{{url('admin/contact')}}"><i
                                        class="fa fa-file-text"></i> {{trans('main.contacts')}}
                                </a>
                            </li>
                        @endcan
                        {{--                    @can('allColor')--}}
                        <li class="@if(request()->is('admin/color')) active @endif">
                            <a href="{{url('admin/color')}}"><i class="fa fa-paint-brush"></i> {{trans('main.colors')}}
                            </a>
                        </li>
                        <li class="@if(request()->is('admin/size')) active @endif">
                            <a href="{{url('admin/size')}}"><i class="fa fa-minus"></i> {{trans('main.sizes')}}
                            </a>
                        </li>

                        {{--                    @endcan--}}
                        @can('allState')
                            <li class="@if(request()->is('admin/state')) active @endif">
                                <a href="{{url('admin/state')}}"><i
                                        class="fa fa-map-marker"></i> {{trans('main.states')}}
                                </a>
                            </li>
                        @endcan
                        @can('allCity')
                            <li class="@if(request()->is('admin/city')) active @endif">
                                <a href="{{url('admin/city')}}"><i
                                        class="fa fa-map-marker"></i> {{trans('main.cities')}}
                                </a>
                            </li>

                        @endcan
                        @can('allEmployeeJob')

                            <li class="@if(request()->is('admin/job')) active @endif">
                                <a href="{{url('admin/job')}}"><i
                                        class="fa fa-address-book"></i> {{trans('main.employee_jobs')}}
                                </a>
                            </li>
                        @endcan
                        @can('allWorkerJob')
                            <li class="@if(request()->is('admin/worker-job')) active @endif">
                                <a href="{{url('admin/worker-job')}}"><i
                                        class="fa fa-address-book"></i> {{trans('main.worker_jobs')}}
                                </a>
                            </li>
                        @endcan
                        @can('allUniversity')
                            <li class="@if(request()->is('admin/university')) active @endif">
                                <a href="{{url('admin/university')}}"><i
                                        class="fa fa-university"></i> {{trans('main.universities')}}
                                </a>
                            </li>

                        @endcan

                        @can('allWorkerClassification')
                            <li class="@if(request()->is('admin/worker-classification')) active @endif">
                                <a href="{{url('admin/worker-classification')}}"><i
                                        class="fa fa-user-circle    "></i> {{trans('main.worker_classifications')}}
                                </a>
                            </li>

                        @endcan
                        <li class="@if(request()->is('admin/bank-account')) active @endif">
                            <a href="{{url('admin/bank-account')}}"> <i
                                    class="fa fa-bank"></i>{{trans('main.bank_accounts')}}
                            </a>
                        </li>
                        @can('allExpenseItem')
                            <li class="@if(request()->is('admin/expense-item')) active @endif">
                                <a href="{{url('admin/expense-item')}}"> <i
                                        class="fa fa-th-large"></i>{{trans('main.expense_items')}}
                                </a>
                            </li>
                        @endcan
                        @can('allExtractItem')
                            <li class="@if(request()->is('admin/extract-item')) active @endif">
                                <a href="{{url('admin/extract-item')}}"><i
                                        class="fa fa-th-large"></i>{{trans('main.extract_items')}}
                                </a>
                            </li>
                        @endcan

                        @can('saveSettings')
                            <li class="@if(request()->is('admin/setting')) active @endif">
                                <a href="{{url('admin/setting')}}"><i
                                        class="fa fa-sliders"></i> {{trans('main.settings')}}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

            @endcanany
        </ul>

    </div>
</nav>
