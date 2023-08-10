@if($new==1)
<div class="col-md-6 mb-4 gcobseritem gcobseritem{{$Incident_value->im_id}}">
@endif  
                <div class="gcspaction"> @if($Incident_value->im_ratinganincident) <a href="{{ route('incidentsdetails',['id'=>$Incident_value->im_id,'step'=>1]) }}" class="ml-1"><i class="fa fa-eye"></i></a> @endif @if($cuser->can('Incident Edit') && (($cuser->hasRole('Super Admin') || $cuser->id==$Incident_value->im_created_by))) <a href="{{ route('incidentsedit',['id'=>$Incident_value->im_id]) }}" class="ml-1 incidentsedit"><i class="fa fa-edit"></i></a> @endif @if($cuser->can('Incident Delete') && (($cuser->hasRole('Super Admin') || $cuser->id==$Incident_value->im_created_by))) <a href="{{ route('incidentsdelete',['id'=>$Incident_value->im_id]) }}" class="ml-1 incidentsdelete"><i class="fa fa-trash"></i></a> @endif </div>
                <div class="card colorfatalboder colorborder{{$Incident_value->rating_type}}">
                  <div class="card-body"> <span class="d-flex gc-observsntitle " @if($Incident_value->im_ratinganincident) onclick="location.href='{{ route('incidentsdetails',['id'=>$Incident_value->im_id,'step'=>1]) }}';" @endif>{{$Incident_value->category_name}} - {{$Incident_value->im_srno}}</span> <span class="gc-fatal-incidents colorrating{{$Incident_value->rating_type}}" data-toggle="modal" data-target="#myModal{{$Incident_value->im_id}}">
                                      <?php 
                                        if($Incident_value->im_ratinganincident){
                                          echo $Incident_value->rating.' - '.$Incident_value->rating_text;
                                        }else{
                                          echo ' > '.__('Set Rating').' ';
                                        }
                                      ?>
                                      </span>
                    <?php if($cuser->hasRole('Super Admin')){?>
                      <div id="myModal{{$Incident_value->im_id}}" class="modal fade" role="dialog"> @include('incidents.ratingpopup') </div>
                      <?php } ?>
                        <div @if($Incident_value->im_ratinganincident) onclick="location.href='{{ route('incidentsdetails',['id'=>$Incident_value->im_id,'step'=>1]) }}';" @endif >
                          <div class="gc-incident-carddtl"> <span class="d-flex">{{date('d M, Y D h:ia',strtotime($Incident_value->im_datetime))}}</span> <span class="d-flex">{{$Incident_value->site_name}}</span>
                            <p class="card-text">{{substr($Incident_value->im_description,0,57)}}...</p>
                          </div>
                          <div class="gc-observsntitle-userdtl clearfix">
                            <div class="gc-observsntitle-nametag"> <span class="d-flex">{{__('By')}}:{{$Incident_value->name}}</span> <span class="d-flex">{{date('d M, Y D h:ia',strtotime($Incident_value->created_at))}}</span> </div>
                            <div class="gc-observsntitle-subtag">
                              <label for="tag">{{__('Open')}}</label>
                            </div>
                          </div>
                        </div>
                  </div>
                </div>
@if($new==1)              
</div>
@endif