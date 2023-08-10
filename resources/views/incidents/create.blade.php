<div class="gc-form-title">
         <h5>{{__('Reports an Incident')}}</h5>
     </div>
     <form id="incidentsstore" action="{{route('incidentsstore')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group gcsptreeviewwapepe">
                    <label for="exampleInputEmail1">1. {{__('Select incident type')}}<span class="required">*</span></label>
                    <select  name="im_ic_id" class="oc_id1"  >                    
                        {!! GetCatDropDown(2) !!}
                    </select>                    
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">2. {{__('Describe your incident in few words')}}...<span class="required">*</span></label>
                    <textarea class="form-control" name="im_description" >{{ old('im_description') }}</textarea>                
                </div>
            </div>    
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group gcsptreeviewwapepe">
                    <label for="exampleInputEmail1">3. {{__('Whare? name the location, area, site')}}...<span class="required">*</span></label>
                    <select  class="site_id1" name="im_site_id">
                        {!! GetSiteDropDown() !!}
                    </select>            
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">4. {{__('Select Shift')}}<span class="required">*</span></label>
                    <select name="im_shift" required class="form-control" >
                        <option>{{__('Select')}}</option>
                        <?php if(count($Shifts)){
                            foreach ($Shifts as $key => $ShiftsValue) {?>
                             <option value="{{$ShiftsValue->sm_id}}">{{$ShiftsValue->sm_name}}</option>
                         <?php   }
                     } ?>                    
                 </select>                
             </div>
         </div>    
     </div>

     <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">5. {{__('When? select date and time')}}<span class="required">*</span></label>
                <input required type="datetime-local" value="{{ old('im_datetime') }}" name="im_datetime" placeholder="" onClick="$(this).removeClass('placeholderclass')" class="dateclass placeholderclass form-control"  />
            </div>
        </div>
        <div class="col-md-12">

            <div class="form-group gc-uploadbtn">
                <label for="exampleInputEmail1">6. {{__('Upload images or attach files')}}</label>
                <div id="newfiletypeadded"></div>
                <div class="gcspuploadedwpr">
                 <label for="file-upload" class="custom-file-upload d-block">
                     <img src="{{ asset('images/attached-file.png') }}" alt="">
                 </label>
                 <input id="file-upload" class="file-upload" name="attachedmain[]" type="file" multiple accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf" />
             </div>    
             <div id="fileinstedt"></div>
             <div id="fileinstedtimg"></div>
         </div> 


         
     </div>    
    </div>

    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button> 
    </form>