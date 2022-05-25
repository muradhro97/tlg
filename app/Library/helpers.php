<?php

use Carbon\Carbon;

if (!function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * @param  string|null $key
     * @param  array $replace
     * @param  string|null $locale
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    function trans($key = null, $replace = [], $locale = null)
    {

//        return app()->getLocale();
        if (is_null($key)) {
            return app('translator');
        }
//if()
        if(app()->getLocale()=="en"){
            return ucfirst(app('translator')->get($key, $replace, $locale));
        }elseif (app()->getLocale()=="ch"){
            return (app('translator')->get($key, $replace, $locale));
        }

    }
}


if (!function_exists('minToHour')) {
    /**
     * Translate the given message.
     *
     * @param  string|null $key
     * @param  array $replace
     * @param  string|null $locale
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    function minToHour($min)
    {
        if($min== null or $min== 0){
            return "00:00:00";
        }
        return Carbon::parse("00:00:00")->addMinutes($min)->format('H:i:s');
//        return ucfirst(app('translator')->get($key, $replace, $locale));
    }
}