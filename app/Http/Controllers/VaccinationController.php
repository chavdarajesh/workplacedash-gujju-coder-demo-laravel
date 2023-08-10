<?php

namespace App\Http\Controllers;
use App\Vaccination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{

    public function __construct()
    {
        $this->middleware('FrontUsers');

    }
    //
    public function index(Request $request)
    {
        $cuser = Auth::user();$filterdatestart='';  $filterdateend='';
        $page_title='Vaccinations';

        $Vaccination_query= DB::table('vaccinations as vc');
        $Vaccination_query->select('vc.*', 'u.name','u.empid');
        $Vaccination_query->leftJoin('users as u', 'u.id', '=', 'vc.created_by');
        $Vaccination_query->whereNull('vc.deleted_at') ;

        $filterdate=$request->filterdate;
        $filtervaccinetype=$request->filtervaccinetype;

        if($filterdate!=''){
            $filterdaterange=explode(' - ', $filterdate);
            $filterdatestart=date('Y-m-d 00:00:00',strtotime($filterdaterange[0]));
            $filterdateend=date('Y-m-d 23:59:59',strtotime($filterdaterange[1]));
        }

        if($filterdate!=''){  $Vaccination_query->whereBetween('vc.created_at', [$filterdatestart,$filterdateend]); }
        if($filtervaccinetype!=''){   $Vaccination_query->where('vc.vaccine_type',$filtervaccinetype)->orWhere('vc.second_vaccine_type',$filtervaccinetype);    }
        $Vaccination= $Vaccination_query->get();
        if ($request->ajax()) {
            return view('vaccinations.vaccinationsajax', compact('Vaccination','cuser'));
        }
        return view('vaccinations.vaccinations', compact('Vaccination','cuser','page_title'));
    }

    public function store(Request $request)
    {
        $cuser = Auth::user();
        $ErrorMessage = [
            'vaccinated.required' => 'Vaccinated field is required.',
            'date_administered.required' => 'Date Administered field is required.',
            'vaccine_type.required' => 'Vaccine Type field is required.',
            'picture.required' => 'Picture field is required.',
        ];
        $validatedData = $request->validate([
            'vaccinated' => ['required'],
            'date_administered' => ['required'],
            'vaccine_type' => ['required'],
            'picture' => ['required'],
        ],$ErrorMessage);

        $parentuser = Auth::user();

        $Vaccination = new \App\Vaccination;
        $Vaccination->vaccinated = $request->vaccinated;
        $Vaccination->date_administered = $request->date_administered;
        $Vaccination->vaccine_type=$request->vaccine_type;
        if($request->vaccine_type == 'Other'){
            $Vaccination->other_vaccine_type = $request->other_vaccine_type;
        }
        $picture='';
        if($request->file('picture')){
            $picture = Storage::putFile('public/'.$parentuser->companyname, $request->file('picture'));
            $picture=str_replace('public/', '', $picture);
            $Vaccination->picture = $picture;
        }
        if($request->second_vaccinated == 1){
            $Vaccination->second_vaccinated = $request->second_vaccinated;
            $Vaccination->second_date_administered = $request->second_date_administered;
            $Vaccination->second_vaccine_type=$request->second_vaccine_type;
            if($request->second_vaccine_type == 'Other'){
                $Vaccination->second_other_vaccine_type = $request->second_other_vaccine_type;
            }
            $second_picture='';
            if($request->file('second_picture')){
                $second_picture = Storage::putFile('public/'.$parentuser->companyname, $request->file('second_picture'));
                $second_picture=str_replace('public/', '', $second_picture);
                $Vaccination->second_picture = $second_picture;
            }
        }else{
            $Vaccination->second_vaccinated == 0;
        }
        $Vaccination->created_by = $parentuser->id;
        $Vaccination->save();
        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $cuser = Auth::user();

        $Vaccination = Vaccination::where('id',$request->id)->first();
        if(empty($Vaccination)){
            return Redirect::route('vaccinations')->with('error',__('Vaccination not found.'));
        }
        if((!$cuser->hasRole('Super Admin') && $cuser->id!=$Vaccination->created_by)){
            return Redirect::route('dashboard')->with('error',__('You can not access this section.'));
        }

        $page_title='Edit Vaccination';
        return  view('vaccinations.edit', compact('page_title','Vaccination','cuser'));
    }
public function update(Request $request)
{
    $cuser = Auth::user();
        $ErrorMessage = [
            'id.required' => __('The Vaccinated field is required.'),
            'vaccinated.required' => 'Vaccinated field is required.',
            'date_administered.required' => 'Date Administered field is required.',
            'vaccine_type.required' => 'Vaccine Type field is required.',
        ];
        $validatedData = $request->validate([
            'id' => ['required'],
            'vaccinated' => ['required'],
            'date_administered' => ['required'],
            'vaccine_type' => ['required'],
        ],$ErrorMessage);

        $parentuser = Auth::user();

        $Vaccination =  \App\Vaccination::find($request->id);
        $Vaccination->vaccinated = $request->vaccinated;
        $Vaccination->date_administered = $request->date_administered;
        $Vaccination->vaccine_type=$request->vaccine_type;
        if($request->vaccine_type == 'Other'){
            $Vaccination->other_vaccine_type = $request->other_vaccine_type;
        }
        $picture='';
        if($request->file('picture')){
            $picture = Storage::putFile('public/'.$parentuser->companyname, $request->file('picture'));
            $picture=str_replace('public/', '', $picture);
            $Vaccination->picture = $picture;
        }
        if($request->second_vaccinated == 1){
            $Vaccination->second_vaccinated = $request->second_vaccinated;
            $Vaccination->second_date_administered = $request->second_date_administered;
            $Vaccination->second_vaccine_type=$request->second_vaccine_type;
            if($request->second_vaccine_type == 'Other'){
                $Vaccination->second_other_vaccine_type = $request->second_other_vaccine_type;
            }
            $second_picture='';
            if($request->file('second_picture')){
                $second_picture = Storage::putFile('public/'.$parentuser->companyname, $request->file('second_picture'));
                $second_picture=str_replace('public/', '', $second_picture);
                $Vaccination->second_picture = $second_picture;
            }
        }else{
            $Vaccination->second_vaccinated == 0;
        }
        $Vaccination->created_by = $parentuser->id;
        $Vaccination->save();
        return redirect()->back();
}

    public function delete($id)
    {
        $cuser = Auth::user();
        $Vaccination = Vaccination::where('id',$id)->first();
        if((!$cuser->hasRole('Super Admin') && $cuser->id!=$Vaccination->created_by)){
            return Redirect::route('dashboard')->with('error',__('You can not access this section.'));
        }
        if($Vaccination->deleted_at){
            Vaccination::where('id',$id)->forceDelete();
        }else{
            Vaccination::where('id',$id)->delete();
        }
        return $id;
    }
}
