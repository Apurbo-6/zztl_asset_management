<?php
namespace App\Http\Controllers;
use App\Models\Supplier; use App\Support\Activity; use Illuminate\Http\Request;
class SupplierController extends Controller {
 public function index(){ $suppliers=Supplier::withCount('assets')->orderBy('name')->paginate(25); return view('suppliers.index',compact('suppliers')); }
 public function create(){return view('suppliers.form',['supplier'=>new Supplier]);}
 public function store(Request $r){$d=$r->validate(['name'=>'required|string|max:200','contact_person'=>'nullable|string|max:150','phone'=>'nullable|string|max:30','email'=>'nullable|email|max:150','address'=>'nullable|string']);$s=Supplier::create($d);Activity::record('created','suppliers','Created supplier '.$s->name,[], $s->toArray());return redirect()->route('suppliers.index')->with('success','Supplier created.');}
 public function edit(Supplier $supplier){return view('suppliers.form',compact('supplier'));}
 public function update(Request $r,Supplier $supplier){$old=$supplier->toArray();$d=$r->validate(['name'=>'required|string|max:200','contact_person'=>'nullable|string|max:150','phone'=>'nullable|string|max:30','email'=>'nullable|email|max:150','address'=>'nullable|string']);$supplier->update($d+['is_active'=>$r->boolean('is_active')]);Activity::record('updated','suppliers','Updated supplier '.$supplier->name,$old,$supplier->toArray());return redirect()->route('suppliers.index')->with('success','Supplier updated.');}
 public function destroy(Supplier $supplier){$supplier->update(['is_active'=>false]);Activity::record('deactivated','suppliers','Deactivated supplier '.$supplier->name);return back()->with('success','Supplier deactivated.');}
}
