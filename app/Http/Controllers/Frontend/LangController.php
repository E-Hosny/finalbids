<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Config;


class LangController extends Controller
{
    public function index()
    {
        return view('lang');
    }



    public function change(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
  
        return redirect()->back();
    }

    public function currencychange(Request $request)
    {
        session()->put('currency', $request->currency);

       
        Config::set('app.currency', $request->currency);

        return redirect()->back();
    }
  
}
