<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = message::all();
        return view('home',compact('messages'));
    }

    public function sendmessage(Request $request){
        $message=$request->message;
        $authUserName = auth()->user()->name;

        $data_array = $request->except( 'updated_at', 'created_at');		
        $data_array["user_name"] = $authUserName;
        $data_array["use_id"] = auth()->user()->id;
        $data_array["message"] = $message;
        
        Message::create($data_array);
        
        event(new \App\Events\Chat($message,$authUserName));

    }
}
