<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use View;
class SubscriberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:subscriber');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {


        $data['data'] = DB::table('conversations')->select('con_id')
        ->where('subscriber_id', '=', auth()->user()->id)
        ->where('persona_id', '=', 1)->get();


        if(count($data) > 0){
            return view('pages.subscriberHome', $data);
        }
        else{
            return view('pages.subscriberHome');
        }
    }
}
