<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    public function changeLanguage(Request $request)
    {
        $rules = ['lang' => 'in:ch,en'];
        $language = $request->lang;
//dd(123);
        $validator = validator()->make($request->all(), $rules);
        if ($validator->passes()) {
            session()->put('site_language', $language);
            app()->setLocale($request->lang);

//			return app()->getLocale();

            return back();
        }

        return back();
    }
}
