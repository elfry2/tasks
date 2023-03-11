<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preference;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public static function read($name){
      $name = str_replace(' ', '', $name);
      $preference = Preference::where('parent_user', Auth::id())
      ->where('name', $name)
      ->first();

      if ($preference !== null) {
        return $preference["value"];
      } return null;
    }

    public static function createOrUpdate($name, $value, Request $request){
      $name = str_replace(' ', '', $name);
      $value = str_replace(' ', '', $value);

      if (self::read($name) !== null) {
        Preference::where('parent_user', Auth::id())
        ->where('name', $name)
        ->update(['value'=>$value]);
      } else {
        Preference::create([
          'parent_user'=>Auth::id(),
          'name'=>$name,
          'value'=>$value
        ]);
      }

      if($request->has('redirect')) return redirect($request->input('redirect'));
      return redirect()->route('root');
    }

    public static function delete($name, Request $request){
      if (self::read($name) !== null) {
        Preference::where('parent_user', Auth::id())
        ->where('name', $name)
        ->delete();
      }

      if($request->has('redirect')) return redirect($request->input('redirect'));
      return redirect()->route('root');
    }
}
