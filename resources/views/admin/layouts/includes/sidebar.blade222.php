<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{asset('inspina/img/profile_small.jpg')}}"/>
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong
                                            class="font-bold">{{auth()->user()->name}}</strong>
                             </span> <span class="text-muted text-xs block">@if(count(auth()->user()->roles) > 0){{auth()->user()->roles()->first()->display_name}}@endif <b
                                            class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="">الصفحة الشخصية</a></li>
                        <li><a href="">جهات الاتصال</a></li>
                        <li><a href="">الخطابات</a></li>
                        <li class="divider"></li>
                        <li><a href="{{url('logout')}}">تسجيل الخروج</a></li>
                    </ul>
                </div>
                <div class="logo-element">انجز</div>
            </li>

            <li class="@if(request()->url() == url('/')) active @endif">
                <a href="{{url('/')}}"><i class="fa fa-th-large"></i> <span class="nav-label">الرئيسية</span></a>
            </li>
            {{--Entrust::can('permission-name');--}}
          @if(  Entrust::can('brand-list','carActivity-list','carMaintenance-list'))
            <li class="@if(request()->is('car')
            || request()->is('brand')
            || request()->is('car-activity')
            || request()->is('car-maintenance')) active @endif">
               
                <a href="#"><i class="fa fa-car"></i> <span class="nav-label">نظام الكراج</span> <span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="@if(request()->is('car')) active @endif"><a href="{{url('car')}}">السيارات</a></li>
                    <li class="@if(request()->is('car-activity')) active @endif"><a href="{{url('car-activity')}}">أنشطة
                            السيارات</a></li>
                    <li class="@if(request()->is('car-maintenance')) active @endif"><a
                                href="{{url('car-maintenance')}}">صيانة الصيارات</a></li>
                    <li class="@if(request()->is('brand')) active @endif"><a href="{{url('brand')}}">ماركات السيارات</a>
                    </li>
                </ul>
            </li>
            @endif

            <li class="@if(request()->is('currency')
            || request()->is('safe')
            || request()->is('finance-safes')) active @endif">
                <a href="#"><i class="fa fa-money"></i> <span class="nav-label">النظام المالي</span> <span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="@if(request()->is('expense')) active @endif"><a href="{{url('expense')}}">المصروفات</a></li>
                    <li class="@if(request()->is('income')) active @endif"><a href="{{url('income')}}">الإيرادات</a></li>
                    <li class="@if(request()->is('finance-type')) active @endif"><a href="{{url('finance-type')}}">بنود
                            النظام المالي</a></li>
                    <li class="@if(request()->is('currency')) active @endif"><a href="{{url('currency')}}">العملات</a>
                    </li>
                    <li class="@if(request()->is('safe')) active @endif"><a href="{{url('safe')}}">الخزائن</a></li>
                </ul>
            </li>

            <li class="@if(request()->is('prince-information')
            || request()->is('prince-bank')
            || request()->is('prince-bank-account')
            || request()->is('prince-visa')) active @endif">
                <a href="#"><i class="fa fa-user-circle-o"></i> <span class="nav-label">النظام الخاص</span> <span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="@if(request()->is('prince-information')) active @endif"><a href="{{url('prince-information')}}">البيانات الشخصية</a></li>
                    <li class="@if(request()->is('prince-bank')) active @endif"><a href="{{url('prince-bank')}}">البنوك</a></li>
                    <li class="@if(request()->is('prince-bank-account')) active @endif"><a
                                href="{{url('prince-bank-account')}}">حسابات البنوك</a></li>
                    <li class="@if(request()->is('prince-visa')) active @endif"><a href="{{url('prince-visa')}}">بطاقات
                            الائتمان</a>
                    </li>

                    <li class="@if(request()->is('prince-business-card')) active @endif"><a
                                href="{{url('prince-business-card')}}">الكروت الشخصية
                        </a>
                    </li>

                    <li class="@if(request()->is('prince-contact')) active @endif"><a href="{{url('prince-contact')}}">جهات
                            الاتصال
                        </a>
                    </li>
                </ul>
            </li>


            <li class="@if(request()->url() == url('visa')) active @endif">
                <a href="{{url('visa')}}"><i class="fa fa-cc-visa"></i> <span class="nav-label">التأشيرات</span></a>
            </li>

			<li class="@if(request()->url() == url('archive')) active @endif">
                <a href="{{url('archive')}}"><i class="fa fa-archive"></i> <span class="nav-label">الارشيف</span></a>
            </li>

            <li class="@if(request()->url() == url('contact')) active @endif">
                <a href="{{url('contact')}}"><i class="fa fa-cc-visa"></i> <span class="nav-label">جهات الاتصال</span></a>
            </li>

            <li class="@if(request()->url() == url('business-card')) active @endif">
                <a href="{{url('business-card')}}"><i class="fa fa-id-card-o"></i> <span class="nav-label">الكروت الشخصية</span></a>
            </li>

            <li class="@if(request()->is('employee')
            || request()->is('worker')
            || request()->is('role')
            || request()->is('department')
            || request()->is('prince-visa')) active @endif">
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">اداره المستخدمين</span> <span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="@if(request()->is('employee')) active @endif"><a
                                href="{{url('employee')}}">الموظفين</a></li>
                    <li class="@if(request()->is('worker')) active @endif"><a
                                href="{{url('worker')}}">العمالة</a></li>
                    <li class="@if(request()->is('role')) active @endif"><a
                                href="{{url('role')}}">مجموعات المستخدمين</a></li>
                    <li class="@if(request()->url() == url('department')) active @endif">
                        <a href="{{url('department')}}"><i class="fa fa-list"></i> <span class="nav-label">الاقسام</span></a>
                    </li>

                </ul>
            </li>

            <li class="@if(request()->is('organization')
            || request()->is('bank-account')
            || request()->is('bank')) active @endif">
                <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">الإعدادات</span> <span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="@if(request()->url() == url('organization')) active @endif">
                        <a href="{{url('organization')}}"><i class="fa fa-building-o"></i> <span class="nav-label">الجهات</span></a>
                    </li>
                    <li class="@if(request()->url() == url('bank')) active @endif">
                        <a href="{{url('bank')}}"><i class="fa fa-university"></i> <span class="nav-label">البنوك</span></a>
                    </li>
                    <li class="@if(request()->url() == url('bank-account')) active @endif">
                        <a href="{{url('bank-account')}}"><i class="fa fa-credit-card"></i> <span class="nav-label">حسابات البنوك</span></a>
                    </li>
                </ul>
            </li>

        </ul>

    </div>
</nav>