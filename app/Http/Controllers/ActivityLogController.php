<?php
namespace App\Http\Controllers;
use App\Models\ActivityLog; use Illuminate\Http\Request;
class ActivityLogController extends Controller { public function index(Request $r){$logs=ActivityLog::with('user')->when($r->q,fn($q,$v)=>$q->where('description','like',"%$v%"))->when($r->module,fn($q,$v)=>$q->where('module',$v))->latest('created_at')->paginate(30)->withQueryString();return view('activity-logs.index',compact('logs'));} }
