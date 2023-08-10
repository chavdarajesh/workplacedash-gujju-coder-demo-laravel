<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\RootCause;
use App\RootCauseItem;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DB;

class RootCauseControllers extends Controller
{
    public function __construct()
    {        
        $this->middleware('FrontUsers');
    }
    
    public function index()
    {
        $cuser = Auth::user();
        if(!$cuser->can('Root Cause')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

        $RootCause= RootCause::where('rc_status','1')->get();  
        $RootCauseDeactive= RootCause::where('rc_status','0')->get();  
        $page_title='Root Cause';
        return view('rootcause.rootcause',compact('RootCause','RootCauseDeactive','page_title','cuser'));
    }

    
    public function create()
    {
        $cuser = Auth::user();
        if(!$cuser->can('Root Cause Add')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        
        
        $page_title="Root Cause Create";
        return view('rootcause.create',compact('page_title','cuser'));
    }

    
    public function store(Request $request)
    {
        $cuser = Auth::user();
        $RootCause = new \App\RootCause;        
        $RootCause->rc_name = $request->rc_name;
        $RootCause->rc_desctiption = $request->rc_desctiption;                
        $RootCause->rc_status = $request->rc_status;                
        $RootCause->save();         
        return Redirect::route('rootcause')->with('success',__('Root Cause successfully added.'));
    }
        

    public function edit($id)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Root Cause Edit')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        
        
        $RootCause=RootCause::where('rc_id',$id)->first();
        if(empty($RootCause)){
            return Redirect::route('rootcause')->with('error',__('Root Cause not found.'));   
        }
        $page_title=__('Edit Root Cause').' '.$RootCause->rc_name;        
        return view('rootcause.edit', compact('RootCause','page_title','cuser'));
    }

    
    public function update(Request $request)
    {
        $cuser = Auth::user();
        $RootCause =  \App\RootCause::find($request->rc_id); 
        $RootCause->rc_name = $request->rc_name;
        $RootCause->rc_desctiption = $request->rc_desctiption;                
        $RootCause->rc_status = $request->rc_status;                
        $RootCause->save();         
        return Redirect::route('rootcause')->with('success',__('Root Cause successfully updated.'));   
    }

    
    public function delete($id)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Root Cause Delete')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

        RootCause::where('rc_id',$id)->delete();
        RootCauseItem::where('rci_rc_id',$id)->delete();
        return Redirect::route('rootcause')->with('success',__('Root Cause successfully deleted.'));   
    }    

    public function GetList(Request $request)
    {   
        $cuser = Auth::user();
        if(!$cuser->can('Root Cause')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

        $rc_id=$request->rc_id;
        $RootCause=RootCause::where('rc_id',$request->rc_id)->first();    
        $RootCauseItem= RootCauseItem::where('rci_rc_id',$request->rc_id)->orderby('rci_parent_id','asc')->get();                 
        $page_title=__('Edit Root Cause').' '.$RootCause->rc_name;        
        return view('rootcause.list', compact('RootCauseItem','page_title','rc_id','cuser'));
    }

    public function ListSubCreate(Request $request)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Root Cause Add')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

        $cuser = Auth::user();
        $rci_rc_id= $request->rc_id;
        $parent_id= $request->parent_id;
        $page_title="Root Cause Create";
        return view('rootcause.createSub',compact('page_title','rci_rc_id','parent_id','cuser'));
    }
    
    public function StoreSub(Request $request)
    {
        $RootCauseItem = new \App\RootCauseItem;        
        $RootCauseItem->rci_rc_id = $request->rci_rc_id;        
        $RootCauseItem->rci_name = $request->rci_name;        
        $RootCauseItem->rci_parent_id = $request->rci_parent_id;        
        $RootCauseItem->rci_status = 1;                
        $RootCauseItem->save(); 
        if($request->rci_parent_id==''){
            DB::table('rootcause_items')->where('rci_id',$RootCauseItem->rci_id)->update(['rci_parent_id' => $RootCauseItem->rci_id]);
        }                
        return Redirect::route('rootcauselist',['rc_id'=>$request->rci_rc_id])->with('success',__('Root Cause successfully added.'));
    }


    public function Subedit($rci_id)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Root Cause Edit')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

        $RootCauseItem=RootCauseItem::where('rci_id',$rci_id)->first();
        if(empty($RootCauseItem)){
            return Redirect::route('rootcause')->with('error',__('Root Cause not found.'));   
        }
        $page_title=__('Edit Root Cause').' '.$RootCauseItem->rc_name;        
        return view('rootcause.subedit', compact('RootCauseItem','page_title','cuser'));
    }

    
    public function Subupdate(Request $request)
    {
        $RootCauseItem = \App\RootCauseItem::find($request->rci_id); 
        $RootCauseItem->rci_name = $request->rci_name;        
        $RootCauseItem->save();         
        return Redirect::route('rootcauselist',['rc_id'=>$request->rci_rc_id])->with('success',__('Root Cause successfully updated.'));
    }
    
    public function Subdelete($rc_id,$rci_id)
    {    
        $cuser = Auth::user();
        if(!$cuser->can('Root Cause Delete')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        
            
        RootCauseItem::where('rci_id',$rci_id)->delete();
        RootCauseItem::where('rci_parent_id',$rci_id)->delete();
        return Redirect::route('rootcauselist',['rc_id'=>$rc_id])->with('success',__('Root Cause successfully deleted.'));        
    }    
    

}
