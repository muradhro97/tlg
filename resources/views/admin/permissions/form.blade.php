<div class="col-md-12">
    @include('flash::message')
    <div class="row">

        {{csrf_field()}}
        {{--{{dd($permissions)}}--}}
        <input type="hidden" name="user_id" value="{{$id}}">
        <div class="col-md-12 ">

            <input type="checkbox" id="select_all"

            >
            <label for="select_all">
                {{trans('main.all_permissions')}}
            </label>


        </div>
        <br>
        <br>

        <h2 class="font-bold  navy-bg pa-10 ">{{trans('main.human_resource')}}</h2>
        <div class="">
            <div class="col-md-4">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.applicant_employees')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allEmpApp" name="per[]" value="allEmpApp"
                                   @if(in_array('allEmpApp',$permissions)) checked @endif
                            >
                            <label for="allEmpApp">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addEmpApp" name="per[]" value="addEmpApp"
                                   @if(in_array('addEmpApp',$permissions)) checked @endif
                            >
                            <label for="addEmpApp">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editEmpApp" name="per[]" value="editEmpApp"
                                   @if(in_array('editEmpApp',$permissions)) checked @endif
                            >
                            <label for="editEmpApp">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteEmpApp" name="per[]"
                                   @if(in_array('deleteEmpApp',$permissions)) checked @endif
                                   value="deleteEmpApp">
                            <label for="deleteEmpApp">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                        <li>
                            <input type="checkbox" id="actionEmpApp" name="per[]"
                                   @if(in_array('actionEmpApp',$permissions)) checked @endif
                                   value="actionEmpApp">
                            <label for="actionEmpApp">
                                {{trans('main.accept_decline')}}
                            </label>
                        </li>

                    </ul>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.applicant_workers')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allWorApp" name="per[]" value="allWorApp"
                                   @if(in_array('allWorApp',$permissions)) checked @endif
                            >
                            <label for="allWorApp">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addWorApp" name="per[]" value="addWorApp"
                                   @if(in_array('addWorApp',$permissions)) checked @endif
                            >
                            <label for="addWorApp">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editWorApp" name="per[]" value="editWorApp"
                                   @if(in_array('editWorApp',$permissions)) checked @endif
                            >
                            <label for="editWorApp">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteWorApp" name="per[]"
                                   @if(in_array('deleteWorApp',$permissions)) checked @endif
                                   value="deleteWorApp">
                            <label for="deleteWorApp">
                                {{trans('main.delete')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="actionWorApp" name="per[]"
                                   @if(in_array('actionWorApp',$permissions)) checked @endif
                                   value="actionWorApp">
                            <label for="actionWorApp">
                                {{trans('main.accept_decline')}}
                            </label>
                        </li>

                    </ul>

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.employees')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allEmp" name="per[]" value="allEmp"
                                   @if(in_array('allEmp',$permissions)) checked @endif
                            >
                            <label for="allEmp">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addEmp" name="per[]" value="addEmp"
                                   @if(in_array('addEmp',$permissions)) checked @endif
                            >
                            <label for="addEmp">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editEmp" name="per[]" value="editEmp"
                                   @if(in_array('editEmp',$permissions)) checked @endif
                            >
                            <label for="editEmp">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteEmp" name="per[]"
                                   @if(in_array('deleteEmp',$permissions)) checked @endif
                                   value="deleteEmp">
                            <label for="deleteEmp">
                                {{trans('main.delete')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.workers')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allWor" name="per[]" value="allWor"
                                   @if(in_array('allWor',$permissions)) checked @endif
                            >
                            <label for="allWor">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addWor" name="per[]" value="addWor"
                                   @if(in_array('addWor',$permissions)) checked @endif
                            >
                            <label for="addWor">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editWor" name="per[]" value="editWor"
                                   @if(in_array('editWor',$permissions)) checked @endif
                            >
                            <label for="editWor">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteWor" name="per[]"
                                   @if(in_array('deleteWor',$permissions)) checked @endif
                                   value="deleteWor">
                            <label for="deleteWor">
                                {{trans('main.delete')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.employee_time_sheet')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="addEmpTime" name="per[]" value="addEmpTime"
                                   @if(in_array('addEmpTime',$permissions)) checked @endif
                            >
                            <label for="addEmpTime">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editEmpTime" name="per[]" value="editEmpTime"
                                   @if(in_array('editEmpTime',$permissions)) checked @endif
                            >
                            <label for="editEmpTime">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteEmpTime" name="per[]" value="deleteEmpTime"
                                   @if(in_array('deleteEmpTime',$permissions)) checked @endif
                            >
                            <label for="deleteEmpTime">
                                {{trans('main.delete')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="historyEmpTime" name="per[]"
                                   @if(in_array('historyEmpTime',$permissions)) checked @endif
                                   value="historyEmpTime">
                            <label for="historyEmpTime">
                                {{trans('main.history')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.worker_time_sheet')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="addWorTime" name="per[]" value="addWorTime"
                                   @if(in_array('addWorTime',$permissions)) checked @endif
                            >
                            <label for="addWorTime">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editWorTime" name="per[]" value="editWorTime"
                                   @if(in_array('editWorTime',$permissions)) checked @endif
                            >
                            <label for="editWorTime">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteWorTime" name="per[]" value="deleteWorTime"
                                   @if(in_array('deleteWorTime',$permissions)) checked @endif
                            >
                            <label for="deleteWorTime">
                                {{trans('main.delete')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="historyWorTime" name="per[]"
                                   @if(in_array('historyWorTime',$permissions)) checked @endif
                                   value="historyWorTime">
                            <label for="historyWorTime">
                                {{trans('main.history')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.employee_monthly_evaluations')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allEmpMonthlyEvaluation" name="per[]" value="allEmpMonthlyEvaluation"
                                   @if(in_array('allEmpMonthlyEvaluation',$permissions)) checked @endif
                            >
                            <label for="allEmpMonthlyEvaluation">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addEmpMonthlyEvaluation" name="per[]" value="addEmpMonthlyEvaluation"
                                   @if(in_array('addEmpMonthlyEvaluation',$permissions)) checked @endif
                            >
                            <label for="addEmpMonthlyEvaluation">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editEmpMonthlyEvaluation" name="per[]" value="editEmpMonthlyEvaluation"
                                   @if(in_array('editEmpMonthlyEvaluation',$permissions)) checked @endif
                            >
                            <label for="editEmpMonthlyEvaluation">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteEmpMonthlyEvaluation" name="per[]"
                                   @if(in_array('deleteEmpMonthlyEvaluation',$permissions)) checked @endif
                                   value="deleteEmpMonthlyEvaluation">
                            <label for="deleteEmpMonthlyEvaluation">
                                {{trans('main.delete')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.penalties')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allPenalty" name="per[]" value="allPenalty"
                                   @if(in_array('allPenalty',$permissions)) checked @endif
                            >
                            <label for="allPenalty">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addPenalty" name="per[]" value="addPenalty"
                                   @if(in_array('addPenalty',$permissions)) checked @endif
                            >
                            <label for="addPenalty">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editPenalty" name="per[]" value="editPenalty"
                                   @if(in_array('editPenalty',$permissions)) checked @endif
                            >
                            <label for="editPenalty">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deletePenalty" name="per[]"
                                   @if(in_array('deletePenalty',$permissions)) checked @endif
                                   value="deletePenalty">
                            <label for="deletePenalty">
                                {{trans('main.delete')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>
            <div class="clearfix"></div>
        </div>


        <h2 class="font-bold  navy-bg pa-10 ">{{trans('main.contracts')}}</h2>
        <div class="">
            <div class="col-md-2">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.contracts')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allContract" name="per[]" value="allContract"
                                   @if(in_array('allContract',$permissions)) checked @endif
                            >
                            <label for="allContract">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addContract" name="per[]" value="addContract"
                                   @if(in_array('addContract',$permissions)) checked @endif
                            >
                            <label for="addContract">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editContract" name="per[]" value="editContract"
                                   @if(in_array('editContract',$permissions)) checked @endif
                            >
                            <label for="editContract">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteContract" name="per[]"
                                   @if(in_array('deleteContract',$permissions)) checked @endif
                                   value="deleteContract">
                            <label for="deleteContract">
                                {{trans('main.delete')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.sub_contracts')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allSubContract" name="per[]" value="allSubContract"
                                   @if(in_array('allSubContract',$permissions)) checked @endif
                            >
                            <label for="allSubContract">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addSubContract" name="per[]" value="addSubContract"
                                   @if(in_array('addSubContract',$permissions)) checked @endif
                            >
                            <label for="addSubContract">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editSubContract" name="per[]" value="editSubContract"
                                   @if(in_array('editSubContract',$permissions)) checked @endif
                            >
                            <label for="editSubContract">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteSubContract" name="per[]"
                                   @if(in_array('deleteSubContract',$permissions)) checked @endif
                                   value="deleteSubContract">
                            <label for="deleteSubContract">
                                {{trans('main.delete')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.extracts')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allExtract" name="per[]" value="allExtract"
                                   @if(in_array('allExtract',$permissions)) checked @endif
                            >
                            <label for="allExtract">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addExtract" name="per[]" value="addExtract"
                                   @if(in_array('addExtract',$permissions)) checked @endif
                            >
                            <label for="addExtract">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editExtract" name="per[]" value="editExtract"
                                   @if(in_array('editExtract',$permissions)) checked @endif
                            >
                            <label for="editExtract">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        {{--<li>--}}
                            {{--<input type="checkbox" id="deleteExtract" name="per[]"--}}
                                   {{--@if(in_array('deleteExtract',$permissions)) checked @endif--}}
                                   {{--value="deleteExtract">--}}
                            {{--<label for="deleteExtract">--}}
                                {{--{{trans('main.delete')}}--}}
                            {{--</label>--}}
                        {{--</li>--}}


                    </ul>

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.main_extracts')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allMainExtract" name="per[]" value="allMainExtract"
                                   @if(in_array('allMainExtract',$permissions)) checked @endif
                            >
                            <label for="allMainExtract">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addMainExtract" name="per[]" value="addMainExtract"
                                   @if(in_array('addMainExtract',$permissions)) checked @endif
                            >
                            <label for="addMainExtract">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editMainExtract" name="per[]" value="editMainExtract"
                                   @if(in_array('editMainExtract',$permissions)) checked @endif
                            >
                            <label for="editMainExtract">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        {{--<li>--}}
                        {{--<input type="checkbox" id="deleteExtract" name="per[]"--}}
                        {{--@if(in_array('deleteExtract',$permissions)) checked @endif--}}
                        {{--value="deleteExtract">--}}
                        {{--<label for="deleteExtract">--}}
                        {{--{{trans('main.delete')}}--}}
                        {{--</label>--}}
                        {{--</li>--}}


                    </ul>

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.extract_items')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>
                            <input type="checkbox" id="allExtractItem" name="per[]" value="allExtractItem"
                                   @if(in_array('allExtractItem',$permissions)) checked @endif
                            >
                            <label for="allExtractItem">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="addExtractItem" name="per[]" value="addExtractItem"
                                   @if(in_array('addExtractItem',$permissions)) checked @endif
                            >
                            <label for="addExtractItem">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        {{--<li>--}}
                        {{--<input type="checkbox" id="editExtractItem" name="per[]" value="editExtractItem"--}}
                        {{--@if(in_array('editExtractItem',$permissions)) checked @endif--}}
                        {{-->--}}
                        {{--<label for="editExtractItem">--}}
                        {{--{{trans('main.edit')}}--}}
                        {{--</label>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<input type="checkbox" id="deleteExtractItem" name="per[]"--}}
                        {{--@if(in_array('deleteExtractItem',$permissions)) checked @endif--}}
                        {{--value="deleteExtractItem">--}}
                        {{--<label for="deleteExtractItem">--}}
                        {{--{{trans('main.delete')}}--}}
                        {{--</label>--}}
                        {{--</li>--}}


                    </ul>

                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.contract_types')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allContractType" name="per[]" value="allContractType"
                                   @if(in_array('allContractType',$permissions)) checked @endif
                            >
                            <label for="allContractType">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addContractType" name="per[]" value="addContractType"
                                   @if(in_array('addContractType',$permissions)) checked @endif
                            >
                            <label for="addContractType">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editContractType" name="per[]" value="editContractType"
                                   @if(in_array('editContractType',$permissions)) checked @endif
                            >
                            <label for="editContractType">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteContractType" name="per[]"
                                   @if(in_array('deleteContractType',$permissions)) checked @endif
                                   value="deleteContractType">
                            <label for="deleteContractType">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>


        <h2 class="font-bold  navy-bg pa-10 ">{{trans('main.stocks')}}</h2>
        <div class="">
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.stock_types')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allStockType" name="per[]" value="allStockType"
                                   @if(in_array('allStockType',$permissions)) checked @endif
                            >
                            <label for="allStockType">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addStockType" name="per[]" value="addStockType"
                                   @if(in_array('addStockType',$permissions)) checked @endif
                            >
                            <label for="addStockType">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editStockType" name="per[]" value="editStockType"
                                   @if(in_array('editStockType',$permissions)) checked @endif
                            >
                            <label for="editStockType">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteStockType" name="per[]"
                                   @if(in_array('deleteStockType',$permissions)) checked @endif
                                   value="deleteStockType">
                            <label for="deleteStockType">
                                {{trans('main.delete')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.items')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allItem" name="per[]" value="allItem"
                                   @if(in_array('allItem',$permissions)) checked @endif
                            >
                            <label for="allItem">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addItem" name="per[]" value="addItem"
                                   @if(in_array('addItem',$permissions)) checked @endif
                            >
                            <label for="addItem">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editItem" name="per[]" value="editItem"
                                   @if(in_array('editItem',$permissions)) checked @endif
                            >
                            <label for="editItem">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteItem" name="per[]"
                                   @if(in_array('deleteItem',$permissions)) checked @endif
                                   value="deleteItem">
                            <label for="deleteItem">
                                {{trans('main.delete')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.stock_orders')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="stockOrder" name="per[]" value="stockOrder"
                                   @if(in_array('stockOrder',$permissions)) checked @endif
                            >
                            <label for="stockOrder">
                                {{trans('main.stock_order')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="stockIn" name="per[]" value="stockIn"
                                   @if(in_array('stockIn',$permissions)) checked @endif
                            >
                            <label for="stockIn">
                                {{trans('main.stock_in')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="stockOut" name="per[]" value="stockOut"
                                   @if(in_array('stockOut',$permissions)) checked @endif
                            >
                            <label for="stockOut">
                                {{trans('main.stock_out')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="stockOutToLoan" name="per[]" value="stockOutToLoan"
                                   @if(in_array('stockOutToLoan',$permissions)) checked @endif
                            >
                            <label for="stockOutToLoan">
                                {{trans('main.stock_out_to_loan')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="detailsStockOrder" name="per[]"
                                   @if(in_array('detailsStockOrder',$permissions)) checked @endif
                                   value="detailsStockOrder">
                            <label for="detailsStockOrder">
                                {{trans('main.details')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="acceptStockOrder" name="per[]"
                                   @if(in_array('acceptStockOrder',$permissions)) checked @endif
                                   value="acceptStockOrder">
                            <label for="acceptStockOrder">
                                {{trans('main.accept')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="declineStockOrder" name="per[]"
                                   @if(in_array('declineStockOrder',$permissions)) checked @endif
                                   value="declineStockOrder">
                            <label for="declineStockOrder">
                                {{trans('main.decline')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="approveStockOrder" name="per[]"
                                   @if(in_array('approveStockOrder',$permissions)) checked @endif
                                   value="approveStockOrder">
                            <label for="approveStockOrder">
                                {{trans('main.approve')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.stock_transaction')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="stockTransaction" name="per[]" value="stockTransaction"
                                   @if(in_array('stockTransaction',$permissions)) checked @endif
                            >
                            <label for="stockTransaction">
                                {{trans('main.stock_transaction')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>

        </div>
        <div class="clearfix"></div>

        <h2 class="font-bold  navy-bg pa-10 ">{{trans('main.safe')}}</h2>
        <div class="">

            <div class="col-md-2">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.payments')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="payment" name="per[]" value="payment"
                                   @if(in_array('payment',$permissions)) checked @endif
                            >
                            <label for="payment">
                                {{trans('main.payment')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="cashIn" name="per[]" value="cashIn"
                                   @if(in_array('cashIn',$permissions)) checked @endif
                            >
                            <label for="cashIn">
                                {{trans('main.cash_in')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="cashOut" name="per[]" value="cashOut"
                                   @if(in_array('cashOut',$permissions)) checked @endif
                            >
                            <label for="cashOut">
                                {{trans('main.cash_out')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="custody" name="per[]" value="custody"
                                   @if(in_array('custody',$permissions)) checked @endif
                            >
                            <label for="custody">
                                {{trans('main.custody')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="custodyToLoan" name="per[]" value="custodyToLoan"
                                   @if(in_array('custodyToLoan',$permissions)) checked @endif
                            >
                            <label for="custodyToLoan">
                                {{trans('main.custodyToLoan')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="custodyRest" name="per[]" value="custodyRest"
                                   @if(in_array('custodyRest',$permissions)) checked @endif
                            >
                            <label for="custodyRest">
                                {{trans('main.custody_rest')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="detailsPayment" name="per[]"
                                   @if(in_array('detailsPayment',$permissions)) checked @endif
                                   value="detailsPayment">
                            <label for="detailsPayment">
                                {{trans('main.details')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="acceptPayment" name="per[]"
                                   @if(in_array('acceptPayment',$permissions)) checked @endif
                                   value="acceptPayment">
                            <label for="acceptPayment">
                                {{trans('main.accept')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="declinePayment" name="per[]"
                                   @if(in_array('declinePayment',$permissions)) checked @endif
                                   value="declinePayment">
                            <label for="declinePayment">
                                {{trans('main.decline')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="payPayment" name="per[]"
                                   @if(in_array('payPayment',$permissions)) checked @endif
                                   value="payPayment">
                            <label for="payPayment">
                                {{trans('main.pay')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.others')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="safeTransaction" name="per[]" value="safeTransaction"
                                   @if(in_array('safeTransaction',$permissions)) checked @endif >
                            <label for="safeTransaction">
                                {{trans('main.safe_transaction')}}
                            </label>
                        </li>

                        <li>
                            <input type="checkbox" id="accountingRequest" name="per[]" value="accountingRequest"
                                   @if(in_array('accountingRequest',$permissions)) checked @endif >
                            <label for="accountingRequest">
                                {{trans('main.accounting_request')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>

        </div>
        <div class="clearfix"></div>

        <h2 class="font-bold  navy-bg pa-10 ">{{trans('main.reports')}}</h2>
        <div class="">

            <div class="col-md-2">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.reports')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>
                            <input type="checkbox" id="cashInReport" name="per[]" value="cashInReport"
                                   @if(in_array('cashInReport',$permissions)) checked @endif
                            >
                            <label for="cashInReport">
                                {{trans('main.cash_in')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="directCostReport" name="per[]" value="directCostReport"
                                   @if(in_array('directCostReport',$permissions)) checked @endif
                            >
                            <label for="directCostReport">
                                {{trans('main.direct_cost')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="indirectCostReport" name="per[]" value="indirectCostReport"
                                   @if(in_array('indirectCostReport',$permissions)) checked @endif
                            >
                            <label for="indirectCostReport">
                                {{trans('main.indirect_cost')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="StockItemsReport" name="per[]" value="StockItemsReport"
                                   @if(in_array('StockItemsReport',$permissions)) checked @endif
                            >
                            <label for="StockItemsReport">
                                {{trans('main.stock_items')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="custodyReport" name="per[]" value="custodyReport"
                                   @if(in_array('custodyReport',$permissions)) checked @endif
                            >
                            <label for="custodyReport">
                                {{trans('main.custody')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="loansReport" name="per[]" value="loansReport"
                                   @if(in_array('loansReport',$permissions)) checked @endif
                            >
                            <label for="loansReport">
                                {{trans('main.loans')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="organizationReport" name="per[]" value="organizationReport"
                                   @if(in_array('organizationReport',$permissions)) checked @endif
                            >
                            <label for="organizationReport">
                                {{trans('main.organization cred/debt')}}
                            </label>
                        </li>
                    </ul>

                </div>
            </div>

        </div>
        <div class="clearfix"></div>

        <h2 class="font-bold  navy-bg pa-10 ">{{trans('main.accounting')}}</h2>
        <div class="">


            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.worker_loans')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allWorkerLoan" name="per[]" value="allWorkerLoan"
                                   @if(in_array('allWorkerLoan',$permissions)) checked @endif
                            >
                            <label for="allWorkerLoan">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addWorkerLoan" name="per[]" value="addWorkerLoan"
                                   @if(in_array('addWorkerLoan',$permissions)) checked @endif
                            >
                            <label for="addWorkerLoan">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="detailsWorkerLoan" name="per[]" value="detailsWorkerLoan"
                                   @if(in_array('detailsWorkerLoan',$permissions)) checked @endif
                            >
                            <label for="detailsWorkerLoan">
                                {{trans('main.details')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="managerAcceptDeclineWorkerLoan" name="per[]" value="managerAcceptDeclineWorkerLoan"
                                   @if(in_array('managerAcceptDeclineWorkerLoan',$permissions)) checked @endif
                            >
                            <label for="managerAcceptDeclineWorkerLoan">
                                {{trans('main.manager_accept_decline')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="safeAcceptDeclineWorkerLoan" name="per[]"
                                   @if(in_array('safeAcceptDeclineWorkerLoan',$permissions)) checked @endif
                                   value="safeAcceptDeclineWorkerLoan">
                            <label for="safeAcceptDeclineWorkerLoan">
                                {{trans('main.safe_accept_decline')}}
                            </label>
                        </li>




                    </ul>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.employee_loans')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allEmployeeLoan" name="per[]" value="allEmployeeLoan"
                                   @if(in_array('allEmployeeLoan',$permissions)) checked @endif
                            >
                            <label for="allEmployeeLoan">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addEmployeeLoan" name="per[]" value="addEmployeeLoan"
                                   @if(in_array('addEmployeeLoan',$permissions)) checked @endif
                            >
                            <label for="addEmployeeLoan">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="detailsEmployeeLoan" name="per[]" value="detailsEmployeeLoan"
                                   @if(in_array('detailsEmployeeLoan',$permissions)) checked @endif
                            >
                            <label for="detailsEmployeeLoan">
                                {{trans('main.details')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="managerAcceptDeclineEmployeeLoan" name="per[]" value="managerAcceptDeclineEmployeeLoan"
                                   @if(in_array('managerAcceptDeclineEmployeeLoan',$permissions)) checked @endif
                            >
                            <label for="managerAcceptDeclineEmployeeLoan">
                                {{trans('main.manager_accept_decline')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="safeAcceptDeclineEmployeeLoan" name="per[]"
                                   @if(in_array('safeAcceptDeclineEmployeeLoan',$permissions)) checked @endif
                                   value="safeAcceptDeclineEmployeeLoan">
                            <label for="safeAcceptDeclineEmployeeLoan">
                                {{trans('main.safe_accept_decline')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.worker_salaries')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allWorkerSalary" name="per[]" value="allWorkerSalary"
                                   @if(in_array('allWorkerSalary',$permissions)) checked @endif
                            >
                            <label for="allWorkerSalary">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addWorkerSalary" name="per[]" value="addWorkerSalary"
                                   @if(in_array('addWorkerSalary',$permissions)) checked @endif
                            >
                            <label for="addWorkerSalary">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="detailsWorkerSalary" name="per[]" value="detailsWorkerSalary"
                                   @if(in_array('detailsWorkerSalary',$permissions)) checked @endif
                            >
                            <label for="detailsWorkerSalary">
                                {{trans('main.details')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="managerAcceptDeclineWorkerSalary" name="per[]" value="managerAcceptDeclineWorkerSalary"
                                   @if(in_array('managerAcceptDeclineWorkerSalary',$permissions)) checked @endif
                            >
                            <label for="managerAcceptDeclineWorkerSalary">
                                {{trans('main.manager_accept_decline')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="safeAcceptDeclineWorkerSalary" name="per[]"
                                   @if(in_array('safeAcceptDeclineWorkerSalary',$permissions)) checked @endif
                                   value="safeAcceptDeclineWorkerSalary">
                            <label for="safeAcceptDeclineWorkerSalary">
                                {{trans('main.safe_accept_decline')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.employee_salaries')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allEmployeeSalary" name="per[]" value="allEmployeeSalary"
                                   @if(in_array('allEmployeeSalary',$permissions)) checked @endif
                            >
                            <label for="allEmployeeSalary">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addEmployeeSalary" name="per[]" value="addEmployeeSalary"
                                   @if(in_array('addEmployeeSalary',$permissions)) checked @endif
                            >
                            <label for="addEmployeeSalary">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="detailsEmployeeSalary" name="per[]" value="detailsEmployeeSalary"
                                   @if(in_array('detailsEmployeeSalary',$permissions)) checked @endif
                            >
                            <label for="detailsEmployeeSalary">
                                {{trans('main.details')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="managerAcceptDeclineEmployeeSalary" name="per[]" value="managerAcceptDeclineEmployeeSalary"
                                   @if(in_array('managerAcceptDeclineEmployeeSalary',$permissions)) checked @endif
                            >
                            <label for="managerAcceptDeclineEmployeeSalary">
                                {{trans('main.manager_accept_decline')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="safeAcceptDeclineEmployeeSalary" name="per[]"
                                   @if(in_array('safeAcceptDeclineEmployeeSalary',$permissions)) checked @endif
                                   value="safeAcceptDeclineEmployeeSalary">
                            <label for="safeAcceptDeclineEmployeeSalary">
                                {{trans('main.safe_accept_decline')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.invoices')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allInvoice" name="per[]" value="allInvoice"
                                   @if(in_array('allInvoice',$permissions)) checked @endif
                            >
                            <label for="allInvoice">
                                {{trans('main.all')}}
                            </label>
                        </li>

                        <li>

                            <input type="checkbox" id="addInvoice" name="per[]" value="addInvoice"
                                   @if(in_array('addInvoice',$permissions)) checked @endif
                            >
                            <label for="addInvoice">
                                {{trans('main.add_invoice')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addExpense" name="per[]" value="addExpense"
                                   @if(in_array('addExpense',$permissions)) checked @endif
                            >
                            <label for="addExpense">
                                {{trans('main.add_expense')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="detailsInvoice" name="per[]" value="detailsInvoice"
                                   @if(in_array('detailsInvoice',$permissions)) checked @endif
                            >
                            <label for="detailsInvoice">
                                {{trans('main.details')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="managerAcceptDeclineInvoice" name="per[]" value="managerAcceptDeclineInvoice"
                                   @if(in_array('managerAcceptDeclineInvoice',$permissions)) checked @endif
                            >
                            <label for="managerAcceptDeclineInvoice">
                                {{trans('main.manager_accept_decline')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="safeAcceptDeclineInvoice" name="per[]"
                                   @if(in_array('safeAcceptDeclineInvoice',$permissions)) checked @endif
                                   value="safeAcceptDeclineInvoice">
                            <label for="safeAcceptDeclineInvoice">
                                {{trans('main.safe_accept_decline')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="stockAcceptDeclineInvoice" name="per[]"
                                   @if(in_array('stockAcceptDeclineInvoice',$permissions)) checked @endif
                                   value="stockAcceptDeclineInvoice">
                            <label for="stockAcceptDeclineInvoice">
                                {{trans('main.stock_accept_decline')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.accounting_cash_in')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allAccountingCashIn" name="per[]" value="allAccountingCashIn"
                                   @if(in_array('allAccountingCashIn',$permissions)) checked @endif
                            >
                            <label for="allAccountingCashIn">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addAccountingCashIn" name="per[]" value="addAccountingCashIn"
                                   @if(in_array('addAccountingCashIn',$permissions)) checked @endif
                            >
                            <label for="addAccountingCashIn">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="detailsAccountingCashIn" name="per[]" value="detailsAccountingCashIn"
                                   @if(in_array('detailsAccountingCashIn',$permissions)) checked @endif
                            >
                            <label for="detailsAccountingCashIn">
                                {{trans('main.details')}}
                            </label>
                        </li>

                        <li>
                            <input type="checkbox" id="safeAcceptDeclineAccountingCashIn" name="per[]"
                                   @if(in_array('safeAcceptDeclineAccountingCashIn',$permissions)) checked @endif
                                   value="safeAcceptDeclineAccountingCashIn">
                            <label for="safeAcceptDeclineAccountingCashIn">
                                {{trans('main.safe_accept_decline')}}
                            </label>
                        </li>



                    </ul>

                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.accounting_cash_out')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allAccountingCashOut" name="per[]" value="allAccountingCashOut"
                                   @if(in_array('allAccountingCashOut',$permissions)) checked @endif
                            >
                            <label for="allAccountingCashOut">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addAccountingCashOut" name="per[]" value="addAccountingCashOut"
                                   @if(in_array('addAccountingCashOut',$permissions)) checked @endif
                            >
                            <label for="addAccountingCashOut">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="detailsAccountingCashOut" name="per[]" value="detailsAccountingCashOut"
                                   @if(in_array('detailsAccountingCashOut',$permissions)) checked @endif
                            >
                            <label for="detailsAccountingCashOut">
                                {{trans('main.details')}}
                            </label>
                        </li>





                    </ul>

                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.expense_items')}}</h3>
                    <ul class="list-unstyled permission-ul">
                        <li>

                            <input type="checkbox" id="allExpenseItem" name="per[]" value="allExpenseItem"
                                   @if(in_array('allExpenseItem',$permissions)) checked @endif
                            >
                            <label for="allExpenseItem">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addExpenseItem" name="per[]" value="addExpenseItem"
                                   @if(in_array('addExpenseItem',$permissions)) checked @endif
                            >
                            <label for="addExpenseItem">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editExpenseItem" name="per[]" value="editExpenseItem"
                                   @if(in_array('editExpenseItem',$permissions)) checked @endif
                            >
                            <label for="editExpenseItem">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteExpenseItem" name="per[]"
                                   @if(in_array('deleteExpenseItem',$permissions)) checked @endif
                                   value="deleteExpenseItem">
                            <label for="deleteExpenseItem">
                                {{trans('main.delete')}}
                            </label>
                        </li>


                    </ul>

                </div>
            </div>


        </div>
        <div class="clearfix"></div>

        <h2 class="font-bold  navy-bg pa-10 ">{{trans('main.settings')}}</h2>
        <div class="">
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.departments')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allDepartment" name="per[]" value="allDepartment"
                                   @if(in_array('allDepartment',$permissions)) checked @endif
                            >
                            <label for="allDepartment">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addDepartment" name="per[]" value="addDepartment"
                                   @if(in_array('addDepartment',$permissions)) checked @endif
                            >
                            <label for="addDepartment">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editDepartment" name="per[]" value="editDepartment"
                                   @if(in_array('editDepartment',$permissions)) checked @endif
                            >
                            <label for="editDepartment">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteDepartment" name="per[]"
                                   @if(in_array('deleteDepartment',$permissions)) checked @endif
                                   value="deleteDepartment">
                            <label for="deleteDepartment">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.labors_departments')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allLaborDepartment" name="per[]" value="allLaborDepartment"
                                   @if(in_array('allLaborDepartment',$permissions)) checked @endif
                            >
                            <label for="allLaborDepartment">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addLaborDepartment" name="per[]" value="addLaborDepartment"
                                   @if(in_array('addLaborDepartment',$permissions)) checked @endif
                            >
                            <label for="addLaborDepartment">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editLaborDepartment" name="per[]" value="editLaborDepartment"
                                   @if(in_array('editLaborDepartment',$permissions)) checked @endif
                            >
                            <label for="editLaborDepartment">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteLaborDepartment" name="per[]"
                                   @if(in_array('deleteLaborDepartment',$permissions)) checked @endif
                                   value="deleteLaborDepartment">
                            <label for="deleteLaborDepartment">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.labors_groups')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allLaborGroup" name="per[]" value="allLaborGroup"
                                   @if(in_array('allLaborGroup',$permissions)) checked @endif
                            >
                            <label for="allLaborGroup">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addLaborGroup" name="per[]" value="addLaborGroup"
                                   @if(in_array('addLaborGroup',$permissions)) checked @endif
                            >
                            <label for="addLaborGroup">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editLaborGroup" name="per[]" value="editLaborGroup"
                                   @if(in_array('editLaborGroup',$permissions)) checked @endif
                            >
                            <label for="editLaborGroup">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteLaborGroup" name="per[]"
                                   @if(in_array('deleteLaborGroup',$permissions)) checked @endif
                                   value="deleteLaborGroup">
                            <label for="deleteLaborGroup">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.categories')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allCategory" name="per[]" value="allCategory"
                                   @if(in_array('allCategory',$permissions)) checked @endif
                            >
                            <label for="allCategory">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addCategory" name="per[]" value="addCategory"
                                   @if(in_array('addCategory',$permissions)) checked @endif
                            >
                            <label for="addCategory">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editCategory" name="per[]" value="editCategory"
                                   @if(in_array('editCategory',$permissions)) checked @endif
                            >
                            <label for="editCategory">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteCategory" name="per[]"
                                   @if(in_array('deleteCategory',$permissions)) checked @endif
                                   value="deleteCategory">
                            <label for="deleteCategory">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.organizations')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allOrganization" name="per[]" value="allOrganization"
                                   @if(in_array('allOrganization',$permissions)) checked @endif
                            >
                            <label for="allOrganization">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addOrganization" name="per[]" value="addOrganization"
                                   @if(in_array('addOrganization',$permissions)) checked @endif
                            >
                            <label for="addOrganization">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editOrganization" name="per[]" value="editOrganization"
                                   @if(in_array('editOrganization',$permissions)) checked @endif
                            >
                            <label for="editOrganization">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteOrganization" name="per[]"
                                   @if(in_array('deleteOrganization',$permissions)) checked @endif
                                   value="deleteOrganization">
                            <label for="deleteOrganization">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.projects')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allProject" name="per[]" value="allProject"
                                   @if(in_array('allProject',$permissions)) checked @endif
                            >
                            <label for="allProject">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addProject" name="per[]" value="addProject"
                                   @if(in_array('addProject',$permissions)) checked @endif
                            >
                            <label for="addProject">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editProject" name="per[]" value="editProject"
                                   @if(in_array('editProject',$permissions)) checked @endif
                            >
                            <label for="editProject">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteProject" name="per[]"
                                   @if(in_array('deleteProject',$permissions)) checked @endif
                                   value="deleteProject">
                            <label for="deleteProject">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.units')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allUnit" name="per[]" value="allUnit"
                                   @if(in_array('allUnit',$permissions)) checked @endif
                            >
                            <label for="allUnit">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addUnit" name="per[]" value="addUnit"
                                   @if(in_array('addUnit',$permissions)) checked @endif
                            >
                            <label for="addUnit">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editUnit" name="per[]" value="editUnit"
                                   @if(in_array('editUnit',$permissions)) checked @endif
                            >
                            <label for="editUnit">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteUnit" name="per[]"
                                   @if(in_array('deleteUnit',$permissions)) checked @endif
                                   value="deleteUnit">
                            <label for="deleteUnit">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.universities')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allUniversity" name="per[]" value="allUniversity"
                                   @if(in_array('allUniversity',$permissions)) checked @endif
                            >
                            <label for="allUniversity">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addUniversity" name="per[]" value="addUniversity"
                                   @if(in_array('addUniversity',$permissions)) checked @endif
                            >
                            <label for="addUniversity">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editUniversity" name="per[]" value="editUniversity"
                                   @if(in_array('editUniversity',$permissions)) checked @endif
                            >
                            <label for="editUniversity">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteUniversity" name="per[]"
                                   @if(in_array('deleteUniversity',$permissions)) checked @endif
                                   value="deleteUniversity">
                            <label for="deleteUniversity">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.countries')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allCountry" name="per[]" value="allCountry"
                                   @if(in_array('allCountry',$permissions)) checked @endif
                            >
                            <label for="allCountry">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addCountry" name="per[]" value="addCountry"
                                   @if(in_array('addCountry',$permissions)) checked @endif
                            >
                            <label for="addCountry">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editCountry" name="per[]" value="editCountry"
                                   @if(in_array('editCountry',$permissions)) checked @endif
                            >
                            <label for="editCountry">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteCountry" name="per[]"
                                   @if(in_array('deleteCountry',$permissions)) checked @endif
                                   value="deleteCountry">
                            <label for="deleteCountry">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.states')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allState" name="per[]" value="allState"
                                   @if(in_array('allState',$permissions)) checked @endif
                            >
                            <label for="allState">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addState" name="per[]" value="addState"
                                   @if(in_array('addState',$permissions)) checked @endif
                            >
                            <label for="addState">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editState" name="per[]" value="editState"
                                   @if(in_array('editState',$permissions)) checked @endif
                            >
                            <label for="editState">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteState" name="per[]"
                                   @if(in_array('deleteState',$permissions)) checked @endif
                                   value="deleteState">
                            <label for="deleteState">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.cities')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allCity" name="per[]" value="allCity"
                                   @if(in_array('allCity',$permissions)) checked @endif
                            >
                            <label for="allCity">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addCity" name="per[]" value="addCity"
                                   @if(in_array('addCity',$permissions)) checked @endif
                            >
                            <label for="addCity">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editCity" name="per[]" value="editCity"
                                   @if(in_array('editCity',$permissions)) checked @endif
                            >
                            <label for="editCity">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteCity" name="per[]"
                                   @if(in_array('deleteCity',$permissions)) checked @endif
                                   value="deleteCity">
                            <label for="deleteCity">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.employee_jobs')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allEmployeeJob" name="per[]" value="allEmployeeJob"
                                   @if(in_array('allEmployeeJob',$permissions)) checked @endif
                            >
                            <label for="allEmployeeJob">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addEmployeeJob" name="per[]" value="addEmployeeJob"
                                   @if(in_array('addEmployeeJob',$permissions)) checked @endif
                            >
                            <label for="addEmployeeJob">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editEmployeeJob" name="per[]" value="editEmployeeJob"
                                   @if(in_array('editEmployeeJob',$permissions)) checked @endif
                            >
                            <label for="editEmployeeJob">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteEmployeeJob" name="per[]"
                                   @if(in_array('deleteEmployeeJob',$permissions)) checked @endif
                                   value="deleteEmployeeJob">
                            <label for="deleteEmployeeJob">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.worker_jobs')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allWorkerJob" name="per[]" value="allWorkerJob"
                                   @if(in_array('allWorkerJob',$permissions)) checked @endif
                            >
                            <label for="allWorkerJob">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addWorkerJob" name="per[]" value="addWorkerJob"
                                   @if(in_array('addWorkerJob',$permissions)) checked @endif
                            >
                            <label for="addWorkerJob">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editWorkerJob" name="per[]" value="editWorkerJob"
                                   @if(in_array('editWorkerJob',$permissions)) checked @endif
                            >
                            <label for="editWorkerJob">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteWorkerJob" name="per[]"
                                   @if(in_array('deleteWorkerJob',$permissions)) checked @endif
                                   value="deleteWorkerJob">
                            <label for="deleteWorkerJob">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.worker_classifications')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allWorkerClassification" name="per[]" value="allWorkerClassification"
                                   @if(in_array('allWorkerClassification',$permissions)) checked @endif
                            >
                            <label for="allWorkerClassification">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addWorkerClassification" name="per[]" value="addWorkerClassification"
                                   @if(in_array('addWorkerClassification',$permissions)) checked @endif
                            >
                            <label for="addWorkerClassification">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editWorkerClassification" name="per[]" value="editWorkerClassification"
                                   @if(in_array('editWorkerClassification',$permissions)) checked @endif
                            >
                            <label for="editWorkerClassification">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteWorkerClassification" name="per[]"
                                   @if(in_array('deleteWorkerClassification',$permissions)) checked @endif
                                   value="deleteWorkerClassification">
                            <label for="deleteWorkerClassification">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.banks')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allBank" name="per[]" value="allBank"
                                   @if(in_array('allBank',$permissions)) checked @endif
                            >
                            <label for="allBank">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addBank" name="per[]" value="addBank"
                                   @if(in_array('addBank',$permissions)) checked @endif
                            >
                            <label for="addBank">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editBank" name="per[]" value="editBank"
                                   @if(in_array('editBank',$permissions)) checked @endif
                            >
                            <label for="editBank">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteBank" name="per[]"
                                   @if(in_array('deleteBank',$permissions)) checked @endif
                                   value="deleteBank">
                            <label for="deleteBank">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.bank_accounts')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allBankAccount" name="per[]" value="allBankAccount"
                                   @if(in_array('allBankAccount',$permissions)) checked @endif
                            >
                            <label for="allBankAccount">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addBankAccount" name="per[]" value="addBankAccount"
                                   @if(in_array('addBankAccount',$permissions)) checked @endif
                            >
                            <label for="addBankAccount">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editBankAccount" name="per[]" value="editBankAccount"
                                   @if(in_array('editBankAccount',$permissions)) checked @endif
                            >
                            <label for="editBankAccount">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteBankAccount" name="per[]"
                                   @if(in_array('deleteBankAccount',$permissions)) checked @endif
                                   value="deleteBankAccount">
                            <label for="deleteBankAccount">
                                {{trans('main.delete')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.settings')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="saveSettings" name="per[]" value="saveSettings"
                                   @if(in_array('saveSettings',$permissions)) checked @endif
                            >
                            <label for="saveSettings">
                                {{trans('main.save_settings')}}
                            </label>
                        </li>


                    </ul>
                </div>
            </div>

        </div>
        <div class="clearfix"></div>
        <h2 class="font-bold  navy-bg pa-10 ">{{trans('main.system')}}</h2>
        <div class="">
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.users')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="allUser" name="per[]" value="allUser"
                                   @if(in_array('allUser',$permissions)) checked @endif
                            >
                            <label for="allUser">
                                {{trans('main.all')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="addUser" name="per[]" value="addUser"
                                   @if(in_array('addUser',$permissions)) checked @endif
                            >
                            <label for="addUser">
                                {{trans('main.add')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="editUser" name="per[]" value="editUser"
                                   @if(in_array('editUser',$permissions)) checked @endif
                            >
                            <label for="editUser">
                                {{trans('main.edit')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="deleteUser" name="per[]"
                                   @if(in_array('deleteUser',$permissions)) checked @endif
                                   value="deleteUser">
                            <label for="deleteUser">
                                {{trans('main.delete')}}
                            </label>
                        </li>
                        <li>
                            <input type="checkbox" id="perUser" name="per[]" value="perUser"
                                   @if(in_array('perUser',$permissions)) checked @endif>
                            <label for="perUser">
                                {{trans('main.permissions')}}
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.notifications')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="accountantNotification" name="per[]" value="accountantNotification"
                                   @if(in_array('accountantNotification',$permissions)) checked @endif
                            >
                            <label for="accountantNotification">
                                {{trans('main.accountant_notification')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="managerNotification" name="per[]" value="managerNotification"
                                   @if(in_array('managerNotification',$permissions)) checked @endif
                            >
                            <label for="managerNotification">
                                {{trans('main.manager_notification')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="safeNotification" name="per[]" value="safeNotification"
                                   @if(in_array('safeNotification',$permissions)) checked @endif
                            >
                            <label for="safeNotification">
                                {{trans('main.safe_notification')}}
                            </label>
                        </li>
                        <li>

                            <input type="checkbox" id="stockNotification" name="per[]" value="stockNotification"
                                   @if(in_array('stockNotification',$permissions)) checked @endif
                            >
                            <label for="stockNotification">
                                {{trans('main.stock_notification')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.activity_logs')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="activityLog" name="per[]" value="activityLog"
                                   @if(in_array('activityLog',$permissions)) checked @endif
                            >
                            <label for="activityLog">
                                {{trans('main.activity_log')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group custom-ul">
                    <h3 class="heading">{{trans('main.backup')}}</h3>
                    <ul class="list-unstyled permission-ul">

                        <li>

                            <input type="checkbox" id="backup" name="per[]" value="backup"
                                   @if(in_array('backup',$permissions)) checked @endif
                            >
                            <label for="backup">
                                {{trans('main.backup')}}
                            </label>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

    </div>
</div>
@push('style')

@endpush
@push('script')
    <!-- Switchery -->

    <script>

        $(function () {


            $('#select_all').click(function () {
//                alert();
                if ($(this).is(':checked')) {
                    $('input[type=checkbox]').prop('checked', true);
                } else {
                    $('input[type=checkbox]').prop('checked', false);
                }
            });
        });
    </script>
@endpush
