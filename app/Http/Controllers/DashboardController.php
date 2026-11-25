<?php
namespace App\Http\Controllers;
use App\Models\Asset; use App\Models\Category; use App\Models\Supplier; use App\Models\ActivityLog;
class DashboardController extends Controller {
 public function __invoke(){
  $assetCount=Asset::count(); $purchaseTotal=Asset::sum('total_price'); $quantityTotal=Asset::sum('qty');
  $categoryCount=Category::count(); $supplierCount=Supplier::count();
  $thisMonth=Asset::whereMonth('purchase_date',now()->month)->whereYear('purchase_date',now()->year)->sum('total_price');
  $recentLogs=ActivityLog::with('user')->latest('created_at')->limit(10)->get();
  $recentAssets=Asset::with('category')->latest('purchase_date')->limit(8)->get();
  return view('dashboard.index',compact('assetCount','purchaseTotal','quantityTotal','categoryCount','supplierCount','thisMonth','recentLogs','recentAssets'));
 }
}
