<?php
namespace App\Support;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
class Activity {
 public static function record(string $action,string $module,string $description,array $old=[],array $new=[]): void {
  ActivityLog::create(['user_id'=>Auth::id(),'module'=>$module,'action'=>$action,'description'=>$description,'old_values'=>$old ?: null,'new_values'=>$new ?: null,'ip_address'=>request()->ip(),'created_at'=>now()]);
 }
}
