<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use DB;
use Mail;
use App;

class NearMissOverDue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nearmissoverdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $observations2= DB::table('observations_master as om');
        $observations2->select('om.*', 'u.name','u.planguage','u.email','u.empid','c.category_name','s.site_name');
        $observations2->leftJoin('users as u', 'u.id', '=', 'om.created_by');
        $observations2->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $observations2->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $observations2->whereNull('om.deleted_at');
        $observations2->whereDate('om.created_at', '<=' , date('Y-m-d H:i:s', strtotime("-3 days")));
        $observations2->where('om.status',1) ;
        $Observationoverdule= $observations2->get();
        if($Observationoverdule){
            foreach ($Observationoverdule as $key => $observations_value) {
                DB::table('observations_master')->where('ob_id', $observations_value->ob_id)->update(['status' => 2]);
                $observations = array();
                $observations['ob_srno'] = $observations_value->ob_srno;
                $observations['ob_information_required'] = '';
                $observations['observationtype'] = get_category_field($observations_value->oc_id, 'category_name');
                $observations['description'] = $observations_value->description;
                $observations['sites'] = $sitesname= ($observations_value->site_id!=0)?get_site_field($observations_value->site_id, 'site_name'):$request->ob_describethelocation;
                $observations['datetime'] = $observations_value->obdatetime;
                $risklevel = '';
                if($observations_value->riskpotentiallevel == 1){ $risklevel = 'Minor'; }
                if($observations_value->riskpotentiallevel == 2){ $risklevel = 'Serious'; }
                if($observations_value->riskpotentiallevel == 3){ $risklevel = 'Fatal'; }
                $observations['risklevel'] = $risklevel;
                $observations['comments'] = $observations_value->Comments;
                //Send to creator                
                $useremail =$observations_value->email;
                $username = $observations_value->name;
                App::setLocale($observations_value->planguage); 
                $subjectforcreatror = __('Near Miss status has been changed.');
                Mail::send('email.observations_overdue', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subjectforcreatror) {            
                    $m->to($useremail, $username)->subject($subjectforcreatror);
                });

                
            }    
        }
        
        
    }
}