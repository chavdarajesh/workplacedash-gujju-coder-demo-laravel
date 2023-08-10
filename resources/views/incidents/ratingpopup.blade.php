<div class="modal-dialog">
    <div class="modal-content">
        <form action="{{route('updaterating')}}" class="updaterating" method="post" >
            @csrf
            <input type="hidden" name="im_id" value="{{$Incident_value->im_id}}">
            <div class="modal-header">
                <h4 class="modal-title">{{__('Incident Classification Matrix')}}</h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
            </div>
            <div class="incidentratingpopup">
                <div class="modal-body">
                    <div class="gcsp_ratingpoup_table">
                        <p>{{__('Tap on a colored cell below to rate the incident based on consequence and nature of incident.')}}</p>            
                        <table border="0" cellpadding="0" cellspacing="0" class="table">
                            <tr>
                                <th rowspan="2">{{__('Severity')}}</th>
                                <th colspan="4">{{__('Likelihood of Incident')}}</th>
                            </tr>
                            <tr>
                                <td>{{__('Almost Certain / Cyclic')}}</td>
                                <td>{{__('Frequent / Repetitive')}}</td>
                                <td>{{__('Likely / Intermittent')}}</td>
                                <td>{{__('Unlikely / Rare')}}</td>
                            </tr>
                            <tr>
                                <td>{{__('Major Hazard / Calamity')}}</td>
                                <td class="colorfatal">
                                    <label for="incmat20{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat20{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==20)?'checked':''}}  value="20"/></label>
                                </td>
                                <td class="colorfatal">
                                    <label for="incmat19{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat19{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==19)?'checked':''}} value="19"/></label>
                                </td>
                                <td class="colorserious">
                                    <label for="incmat18{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat18{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==18)?'checked':''}} value="18"/></label>
                                </td>
                                <td class="colorminor">
                                    <label for="incmat17{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat17{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==17)?'checked':''}} value="17"/></label>
                                </td>
                            </tr>
                            <tr>
                                <td>{{__('Fatal')}}</td>
                                <td class="colorfatal">
                                    <label for="incmat16{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat16{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==16)?'checked':''}} value="16"/></label>
                                </td>
                                <td class="colorserious">
                                    <label for="incmat15{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat15{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==15)?'checked':''}} value="15"/></label>
                                </td>
                                <td class="colorserious">
                                    <label for="incmat14{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat14{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==14)?'checked':''}} value="14"/></label>
                                </td>
                                <td class="colorminor">
                                    <label for="incmat13{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat13{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==13)?'checked':''}} value="13"/></label>
                                </td>
                            </tr>
                            <tr>
                                <td>{{__('Serious')}}</td>
                                <td class="colorserious">
                                    <label for="incmat12{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat12{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==12)?'checked':''}} value="12"/></label>
                                </td>
                                <td class="colorserious">
                                    <label for="incmat11{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat11{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==11)?'checked':''}} value="11"/></label>
                                </td>
                                <td class="colorminor">
                                    <label for="incmat10{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat10{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==10)?'checked':''}} value="10"/></label>
                                </td>
                                <td class="colorminor">
                                    <label for="incmat9{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat9{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==9)?'checked':''}} value="9"/></label>
                                </td>
                            </tr>
                            <tr>
                                <td>{{__('Minor')}}</td>
                                <td class="colorserious">
                                    <label for="incmat8{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat8{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==8)?'checked':''}} value="8"/></label>
                                </td>
                                <td class="colorminor">
                                    <label for="incmat7{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat7{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==7)?'checked':''}} value="7"/></label>
                                </td>
                                <td class="colorminor">
                                    <label for="incmat6{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat6{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==6)?'checked':''}} value="6"/></label>
                                </td>
                                <td class="colorminor">
                                    <label for="incmat5{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat5{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==5)?'checked':''}}  value="5"/></label>
                                </td>
                            </tr>
                            <tr>
                                <td>{{__('Very Low')}}</td>
                                <td class="colorminor">
                                    <label for="incmat4{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat4{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==4)?'checked':''}} value="4"/></label>
                                </td>
                                <td class="colorminor">
                                    <label for="incmat3{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat3{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==3)?'checked':''}} value="3"/></label>
                                </td>
                                <td class="colorminor">
                                    <label for="incmat2{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat2{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==2)?'checked':''}} value="2"/></label>
                                </td>
                                <td class="colorminor">
                                    <label for="incmat1{{$Incident_value->im_id}}"><input type="radio" name="im_ratinganincident" id="incmat1{{$Incident_value->im_id}}" {{($Incident_value->im_ratinganincident==1)?'checked':''}} value="1"/>
                                    </label>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="incidentratform">
                        <div class="formgroup">
                            <div class="formlabel">{{__('Is the Investigation required?')}}</div>
                            <div class="formfieldrig">
                                <label class="radiocontainer radio-inline"><input type="radio" name="im_investigationisrequired" value="1" aria-required="true" aria-invalid="false" {{($Incident_value->im_investigationisrequired==1)?'checked':''}} />{{__('Yes')}} <span class="checkmark"></span></label>
                                <label class="radiocontainer radio-inline"><input type="radio" name="im_investigationisrequired" value="0" aria-required="true" aria-invalid="false" {{($Incident_value->im_investigationisrequired==0)?'checked':''}} />{{__('Not Rated')}} <span class="checkmark"></span></label>
                            </div>
                        </div>
                        <div class="formgroup investigation_button"><button type="submit" class="btn  btn-primary">{{__('Submit')}}</button></div>
                    </div>
                </div>
            </div> 
            </form>       
    </div>
</div>