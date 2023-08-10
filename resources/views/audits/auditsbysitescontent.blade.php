<div class="accordion" id="accordionExample">
    <div class="card1">
        @foreach($sites as $sitekey=> $site)
        <div class="sitewapper">
        <div class="card-header border-0 {{($sitekey==0)?'opensub':''}}" id="heading{{$site->id}}" data-toggle="collapse" data-target="#collapse{{$site->id}}" aria-expanded="{{($sitekey==0)?'true':'false'}}" aria-controls="collapse{{$site->id}}">
            <table width="100%" cellpadding="10">
                <tbody>
                    <tr>
                        <th width="65%" class="listarrowicon">{{$site->site_name}}</th>
                        <td align="right">
                            <span class="sitestausaudit auditrecordfound"><?php if(isset($Audits[$site->id])){echo count($Audits[$site->id]);}else{echo 'No ';}?> {{__('Record Found')}}.</span>
                            <span class="sitestausaudit">S = {{__('Scheduled')}} C = {{__('Completed')}}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="collapse{{$site->id}}" class="collapse {{($sitekey==0)?'show':''}}" aria-labelledby="heading{{$site->id}}" data-parent="#accordionExample" style="">
            <div class="site-card-body">                            
                <div class="custom-reponstable auditableforsite table-responsive">
                    <table class="table template-audit-list-table">
                        <thead>
                            <tr>
                                <th>{{__('Audit Title & Schedule')}}</th>
                                <th colspan="2" class="bgrowtd">{{__('JAN')}}</th>
                                <th colspan="2" >{{__('FEB')}}</th>
                                <th colspan="2" class="bgrowtd">{{__('MAR')}}</th>
                                <th colspan="2" >{{__('APR')}}</th>
                                <th colspan="2" class="bgrowtd">{{__('MAY')}}</th>
                                <th colspan="2" >{{__('JUN')}}</th>
                                <th colspan="2" class="bgrowtd">{{__('JUL')}}</th>
                                <th colspan="2" >{{__('AUG')}}</th>
                                <th colspan="2" class="bgrowtd">{{__('SEP')}}</th>
                                <th colspan="2" >{{__('OCT')}}</th>
                                <th colspan="2" class="bgrowtd">{{__('NOV')}}</th>
                                <th colspan="2" >{{__('DEC')}}</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th class="bgrowtd">S</th>
                                <th class="bgrowtd">C</th>
                                <th >S</th>
                                <th >C</th>
                                <th class="bgrowtd">S</th>
                                <th class="bgrowtd">C</th>
                                <th >S</th>
                                <th >C</th>
                                <th class="bgrowtd">S</th>
                                <th class="bgrowtd">C</th>
                                <th >S</th>
                                <th >C</th>
                                <th class="bgrowtd">S</th>
                                <th class="bgrowtd">C</th>
                                <th >S</th>
                                <th >C</th>
                                <th class="bgrowtd">S</th>
                                <th class="bgrowtd">C</th>
                                <th >S</th>
                                <th >C</th>
                                <th class="bgrowtd">S</th>
                                <th class="bgrowtd">C</th>
                                <th >S</th>
                                <th >C</th>
                            </tr>
                        </thead>                                    
                        <tbody>
                        <?php if(isset($Audits[$site->id])){
                            foreach ($Audits[$site->id] as $key => $value) {
                            $arrkey=$value->site_parent.$value->adm_atm_id;   
                        ?>                                        
                            <tr>
                                <td>
                                    <div class="audittitle"><span>{{$value->atm_audit_name}} </span></div>
                                </td>
                                <?php for ($i=1; $i <=12 ; $i++) { $month= $i; //str_pad( $i, 2, '', STR_PAD_LEFT)?> 
                                <td class="{{($i%2!=0)?'bgrowtd':''}} gcspviewbymonthday" data-site_id="{{$value->site_parent}}" data-atm_id="{{$value->adm_atm_id}}"  data-month="{{$month}}"  data-year="{{$year}}"><?php echo (isset($AuditsCountScheduledArr[$arrkey.$month.$year]))?$AuditsCountScheduledArr[$arrkey.$month.$year]:'-'; ?></td>
                                <td class="{{($i%2!=0)?'bgrowtd':''}} gcspviewbymonthday" data-site_id="{{$value->site_parent}}" data-atm_id="{{$value->adm_atm_id}}"  data-month="{{$month}}"  data-year="{{$year}}"><?php echo (isset($AuditsCountCompletedArr[$arrkey.$month.$year]))?$AuditsCountCompletedArr[$arrkey.$month.$year]:'-'; ?></td>
                                <?php } ?>
                                
                            </tr>
                        <?php } } ?>                                            
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
        </div>
        @endforeach
    </div>
</div>
        