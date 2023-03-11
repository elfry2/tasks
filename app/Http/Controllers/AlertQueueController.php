<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlertQueue;
use Illuminate\Support\Facades\Auth;

class AlertQueueController extends Controller
{
    //
    public static function enqueue($alert)
    {
      AlertQueue::create([
        'parent_user'=>Auth::id(),
        'type'=>$alert["type"],
        'message'=>$alert["message"]
      ]);
    }

    public static function dequeueAll(){

      $alerts = AlertQueue::where('parent_user', Auth::id())
      ->orderBy('id', 'desc')
      ->get();

      AlertQueue::where('parent_user', Auth::id())->delete();

      return $alerts;
    }
}
