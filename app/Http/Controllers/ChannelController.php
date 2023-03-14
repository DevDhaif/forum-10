<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    //
    public function index (){
        return view('threads.show' , compact(Thread::first()));
    }
}
