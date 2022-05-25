<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    //

    public function cashIn(){
//        return

        return  view('admin.template.cash_in');
    }
}
