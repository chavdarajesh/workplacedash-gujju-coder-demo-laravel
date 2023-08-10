<div class="gc-form-title">
    <h5>{{__('Report an Near Miss')}}</h5>
</div>
<div class="alert alert-secondary" role="alert">
        {{__('Please note that your identity is safe - You have the option to submit this report anonymously if you do not wish to share your information. You will not be subject to disciplinary action for a Near-Miss submittal.')}}
    </div>
<form id="observationsstore" action="{{route('observationsstore')}}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="row">

        <div class="col-md-12">
            <div class="form-check mb-3">
                <input class="form-check-input " type="checkbox" name="agree" required id="exampleRadios111" value="1"  />
                <label class="form-check-label" for="exampleRadios1">
                {{__('I have read and understood the disclaimer.')}}
                </label>
            </div>
            <div class="form-group gcsptreeviewwapepe ">
                <label for="exampleInputEmail1">{{__('Select Near Miss Type')}}<span class="required">*</span></label>
                <select  name="oc_id" class="oc_id2 classoc_id"  >
                    {!! GetCatDropDown(1) !!}
                </select>
                <span class="invalid-feedback classoc_idmsg" role="alert"><strong>{{__('The Near Miss Type field is required.')}}</strong></span>
            </div>

        </div>
        <div class="col-md-12">
            <div class="form-group ">
                <label for="exampleInputEmail1">{{__('Describe your near miss')}}<span class="required">*</span></label>
                <textarea name="description"  class="form-control classdescription">{{ old('description') }}</textarea>
                <span class="invalid-feedback" role="alert"><strong>{{__('Description field is required.')}}</strong></span>
            </div>
        </div>
    </div>  <!--first row over-->

    <div class="row">
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe classsite_id">
                <label for="exampleInputEmail1">{{__('Where? name the location, area, site')}}...<span class="required">*</span></label>
                <select  class="site_id2 " name="site_id" >
                    {!! GetSiteDropDown() !!}
                    <option value="0"></option>
                </select>
            </div>
            <span class="invalid-feedback  mt-n2 mb-1" role="alert"><strong>{{__('Select Area field is required.')}}</strong></span>
            <div class="form-check mb-3">
                <input class="form-check-input gcspobservationsitelist" type="checkbox" name="ob_describethelocation_check" id="exampleRadios11" value="1"  />
                <label class="form-check-label" for="exampleRadios1">
                {{__('Unsure / do not know')}}
                </label>
            </div>
            <div class="form-group gcsphidediv gcspobservationsite">
                <input type="text" value="{{ old('ob_describethelocation') }}" name="ob_describethelocation" placeholder="{{__('Describe the location')}}"  class="form-control"  />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group ">
                <label for="exampleInputEmail1">{{__('When? select date and time')}}<span class="required">*</span></label>
                <input type="datetime" value="{{ old('obdatetime') }}" name="obdatetime"  class="dateclass placeholderclass gcspdatetimepicker form-control classobdatetime"  />
                <span class="invalid-feedback" role="alert"><strong>{{__('Date and Time field is required.')}}</strong></span>
            </div>
        </div>
    </div>

    <div class="row">
        @if($cuser->hasRole('Super Admin') || $cuser->can('Observations Risk potential'))
        <div class="col-md-12">
            <div class="form-group ">
                <label for="exampleInputEmail1">{{__('Select risk potential level')}}<span class="required">*</span></label><br />
                <div class="btn-group btn-group-toggle classriskpotentiallevel" data-toggle="buttons">
                    <label class="btn btn-secondary minorbg gc-formbtn active"> <input  type="radio" value="1" name="riskpotentiallevel" id="option1" autocomplete="off"  /> {{__('Minor')}} </label>
                    <label class="btn btn-secondary seriousbg gc-formbtn"> <input value="2" type="radio" name="riskpotentiallevel" id="option2" autocomplete="off" /> {{__('Serious')}} </label>
                    <label class="btn btn-secondary fatalbg gc-formbtn"> <input value="3" type="radio" name="riskpotentiallevel" id="option3" autocomplete="off" class="" /> {{__('Fatal')}} </label>

                </div>
                <span class="invalid-feedback" role="alert"><strong>{{__('Risk potential level field is required.')}}</strong></span>
            </div>
        </div>
        @else
        <input type="hidden" name="riskpotentiallevel" value="0">
        @endif

        @if($cuser->hasRole('Super Admin') || $cuser->can('Actions Add'))
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Action required')}}<span class="required">*</span></label>
                <div class="rightcheckbox classaction_required">
                    <div class="form-check">
                        <input class="form-check-input action_required" type="radio" name="action_required" id="exampleRadios1" value="1"  />
                        <label class="form-check-label" for="exampleRadios1">
                            {{__('Yes')}}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input action_required" type="radio" name="action_required" id="exampleRadios12" value="0"  />
                        <label class="form-check-label" for="exampleRadios12">
                            {{__('No')}}
                        </label>
                    </div>
                </div>
                <span class="invalid-feedback" role="alert"><strong>{{__('Actions field is required')}}</strong></span>
            </div>
            <div class="form-group gcsphideactionsmain gcsphideactions p-2">
                <div class="gc-form-title">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>{{__('Actions')}}  </h5>
                        </div>
                        <div class="col-md-6 text-right pl-0">
                            <a href="javascript:void(0);" class="btn btn-primary gcspaddaction"><i class="fa fa-plus"></i> {{__('Add Action')}}</a>
                        </div>
                    </div>
                </div>
                <div class="actionhtmlbefore"></div>
            </div>
        </div>
        @else
        <input type="hidden" name="action_required" value="0">
        @endif

    </div>

    <div class="row">
        <?php /*
        <div class="col-md-12">
            <div class="form-group gc-uploadbtn">
             <div id="newfiletypeadded"></div>
             <div class="gcspuploadedwpr">
                 <label for="file-upload" class="custom-file-upload">
                     <img src="{{ asset('images/attached-file.png') }}" alt="">
                 </label>
                 <input id="file-upload" class="file-upload" name="attachedmain[]" type="file" multiple accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf" />
             </div>
             <div id="fileinstedt"></div>
             <div id="fileinstedtimg"></div>
         </div>
     </div>
     <?php */?>

     <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Make a suggestion/recommendation')}}<span class="required">*</span></label>
            <textarea  name="Comments" class="form-control classComments">{{ old('Comments') }}</textarea>
            <span class="invalid-feedback" role="alert"><strong>{{__('Make a suggestion field is required.')}}</strong></span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('How would you like to submit this report')}}<span class="required">*</span></label>
            <div class="rightcheckbox classlisting_type">
                <div class="form-check">
                    <input class="form-check-input" checked type="radio" name="listing_type" id="Anonymously" value="1"  />
                    <label class="form-check-label" for="Anonymously">
                        {{__('Anonymously')}}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="listing_type" id="exampleRadios12" value="2"  />
                    <label class="form-check-label" for="Happytosharemydetails">
                        {{__('Happy to share my details')}}
                    </label>
                </div>
            </div>
            @if($cuser->is_admin==6)
            <div class="gcspuniversalnm mt-2 gcsphidediv">
                <div class="form-group">
                    <input type="text" value="{{ old('ob_fullname') }}" name="ob_fullname" placeholder="{{__('Full Name')}}"  class="form-control"  />
                </div>
                <div class="form-group">
                    <input type="text" value="{{ old('ob_empid') }}" name="ob_empid" placeholder="{{__('Employee ID')}}"  class="form-control"  />
                </div>
                <div class="form-group">
                    <input type="email" value="{{ old('ob_email') }}" name="ob_email" placeholder="{{__('E-Mail Address')}}"  class="form-control"  />
                </div>
            </div>
            @endif


            <span class="invalid-feedback" role="alert"><strong>{{__('Please select at least one is required')}}</strong></span>
        </div>

        <div class="form-check mb-3">
                <input class="form-check-input " type="checkbox" name="agree" required id="exampleRadios111" value="1"  />
                <label class="form-check-label" for="exampleRadios1">
                {{__('Please agree with disclaimer/terms of agreement before submitting.')}}
                </label>
            </div>
    </div>


</div>

<button type="submit"  class="btn btn-primary gcspaddobservation">{{__('Submit')}}</button>
</form>

