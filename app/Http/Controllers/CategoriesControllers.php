<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Category;
use App\CategoryType;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DB;

class CategoriesControllers extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('FrontUsers');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cuser = Auth::user();
        if(!$cuser->can('Categories')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        
        $Categories= DB::table('category')
        ->select('category.*', 'category_type.ct_name')
        ->leftJoin('category_type', 'category_type.ct_id', '=', 'category.type_id')
        ->whereNull('category.deleted_at')    
        ->orderby('category.parent_id','asc')    
        ->get();
        $page_title='Categories';
        return view('categories.categories',compact('Categories','page_title','cuser'));
    }

    public function create(Request $request)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Categories Add')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        
        $page_title='Add New Category';
        $parent_id=$request->parent_id;
        $type_id='';
        if($parent_id){
            $Category=Category::where('id',$parent_id)->first();
             $type_id=$Category->type_id;
             $page_title=__('Add New Category in ').$Category->category_name;
        }
        $CategoryType=CategoryType::where('status','1')->get();        
                
        return view('categories.create', compact('CategoryType','page_title','parent_id','type_id','cuser'));
    }

    public function store(Request $request)
    {    
        $cuser = Auth::user();
        $validatedData = $request->validate([            
            'category_name' => ['required'],
            'type_id' => ['required'],            
           // 'cat_icon' => ['required'],            
        ]);
        $cat_icon='';
        $parentuser = Auth::user();
        if($request->file('cat_icon')){
            $cat_icon = Storage::putFile('public/'.$parentuser->companyname, $request->file('cat_icon'));    
        }        
        $Category = new \App\Category;        
        $Category->category_name = $request->category_name;
        $Category->type_id = $request->type_id;        
        $Category->parent_id = $request->parent_id;        
        $Category->cat_icon = str_replace('public/', '', $cat_icon);     
        $Category->save(); 
        if($request->parent_id==''){
            DB::table('category')->where('id',$Category->id)->update(['parent_id' => $Category->id]);
        }        
        return Redirect::route('categories')->with('success',__('Category successfully added.'));
    }

    public function edit(Request $request)
    {
       $cuser = Auth::user();
       if(!$cuser->can('Categories Edit')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

       $Category=Category::where('id',$request->id)->first();
       if(empty($Category)){
            return Redirect::route('categories')->with('error',__('Category not found.'));   
       }
        $page_title=__('Edit Category ').$Category->category_name;        
        return view('categories.edit', compact('Category','page_title','cuser'));
    }

    public function update(Request $request)
    {    
        $cuser = Auth::user();
        $validatedData = $request->validate([            
            'category_name' => 'required'
        ]); 
        $Category =  \App\Category::find($request->id);       
        $cat_icon='';
        $parentuser = Auth::user();
        if($request->file('cat_icon')){
            Storage::delete($Category->cat_icon);
            $cat_icon = Storage::putFile('public/'.$parentuser->companyname, $request->file('cat_icon'));    
        } 
        
        $Category->category_name = $request->category_name;
        if($cat_icon!=''){
            $Category->cat_icon = str_replace('public/', '', $cat_icon);        
        }                
        $Category->save();  
        return Redirect::route('categories')->with('success',__('Category successfully updated.'));
    }
    public function delete($id)
    {     
        $cuser = Auth::user();
        if(!$cuser->can('Categories Delete')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }                   
        Category::where('id',$id)->delete();
        Category::where('parent_id',$id)->delete();
        return Redirect::route('categories')->with('success',__('Category successfully deleted.'));
    }
}
