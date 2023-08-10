<div class="modal-dialog modal-dialog-top modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <div class="modal-title" >
            <p class="mb-1"><b>{{$sites->site_name}}</b></p>
            <p><b>{{__('Audit Name')}}:</b> {{$AuditTemplates->atm_audit_name}}</p>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

            <div class="pupup custom-reponstable auditableforsite table-responsive">
                <table class="table template-audit-list-table">
                    <thead>
                        <tr>
                            <th class="bgrowtd" >{{__(strtoupper($month_name))}} {{$year}}</th>
                            @for($i=1;$i<=$days;$i++)
                            <th  class="bgrowtd">{{$i}}</th>
                            @endfor                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>                
                            <td class="bgrowtd text-left" ><b># {{__('of Audits')}}</b></td>
                            @for($i=1;$i<=$days;$i++)
                            <td class="{{(in_array($i,array(3,10,17,24,$days)))?'bgrowtd':''}}">
                                <?php 
                                if(isset($AuditsCount[$i])){
                                    echo $AuditsCount[$i][0]->auditsbyday;
                                }else{
                                    echo '-';
                                }
                                ?>
                            </td>
                            @endfor
                        </tr>
                        <tr>                
                            <td class="bgrowtd text-left"><b>{{__('Findings')}}</b></td>
                            @for($i=1;$i<=$days;$i++)
                            <td class="{{(in_array($i,array(3,10,17,24,$days)))?'bgrowtd':''}}">
                                <?php 
                                if(isset($KeyFindingCount[$i])){
                                    echo $KeyFindingCount[$i][0]->auditskeyfindnigbyday;
                                }else{
                                    echo '-';
                                }
                                ?>
                            </td>
                            @endfor
                        </tr>
                        <tr>                
                            <td class="bgrowtd text-left"><b>{{__('Actions')}}</b></td>
                            @for($i=1;$i<=$days;$i++)
                            <td class="{{(in_array($i,array(3,10,17,24,$days)))?'bgrowtd':''}}">
                                <?php 
                                if(isset($ActionsCount[$i])){
                                    echo $ActionsCount[$i][0]->actionsbyday;
                                }else{
                                    echo '-';
                                }
                                ?>
                            </td>
                            @endfor
                        </tr>
                    </tbody>                                    
                    </table>
            </div>        
         </div>   
     </div>
</div>
