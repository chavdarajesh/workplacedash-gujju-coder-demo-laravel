@extends('layouts.dashboard') @section('content')
    <div class="mainmidsec">
        <div class="innerleftpanel">
            <div class="tab-content gc-tabs" id="myTabContent">
                <div class="tab-pane fade show active" id="gc-observsnopen" role="tabpanel"
                    aria-labelledby="gc-observsnopen-tab">

                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div classs="gc-obserfilter gc-calendricon">
                                <lable>{{ __('Filter by date') }}</lable>
                                <br>
                                <input type="text" name="filterdate" autocomplete="off" value=""
                                    class=" gcspdaterangepicker gc-picker vaccinationslist"
                                    placeholder="{{ date('d M, Y') }}">
                                <input type="hidden" name="ifchaneddate">
                                <i class="fa fa-calendar gc-calendricon" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div classs="gc-obserfilter">
                                <div class="form-group gcsptreeviewwapepe">
                                    <label>{{ __('Vaccine type') }}</label>
                                        {!! GetVaccinetypeDropDown(true) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 gcspfilterreset">
                            <button type="reset" class="btn btn-primary">{{ __('Reset') }}</button>
                        </div>
                    </div>

                    <div class="gc-vaccinations-userdtl">
                        <div class="row">
                            <?php if($Vaccination){
                            foreach ($Vaccination as $key => $Vaccination_value) {
                        ?>
                            <div class="col-md-6 mb-4 gcobseritem gcobseritem{{ $Vaccination_value->id }}">
                                <div
                                    class="card riskpotentiallevel{{ $Vaccination_value->vaccine_type == 'Other' ? $Vaccination_value->other_vaccine_type : $Vaccination_value->vaccine_type }}">
                                    <div class="gcspaction">
                                        @if ($Vaccination_value->deleted_at == '')
                                            <a href="{{ route('vaccinationedit', ['id' => $Vaccination_value->id]) }}"
                                                class="ml-1 vaccinationedit"><i class="fa fa-edit"></i></a>
                                        @if ($cuser->hasRole('Super Admin'))
                                        <a href="{{ route('vaccinationdelete', ['id' => $Vaccination_value->id]) }}"
                                                class="ml-1 vaccinationdelete"><i class="fa fa-trash"></i></a> @endif
                                        @endif
                                    </div>

                                    <div class="card-body gcspobservationdetails{{ $Vaccination_value->deleted_at }}"> <span
                                            class="d-flex gc-observsntitle">{{ $Vaccination_value->id }} -
                                            {{ $Vaccination_value->vaccine_type == 'Other' ? $Vaccination_value->other_vaccine_type : $Vaccination_value->vaccine_type }}</span>
                                        <span class="d-flex"> Date
                                            administered :</span><span class="d-flex">
                                            {{ date('d M, Y D h:ia', strtotime($Vaccination_value->date_administered)) }}</span>

                                        <div class="gc-observsntitle-userdtl clearfix">
                                            <div class="gc-observsntitle-nametag"> <span
                                                    class="d-flex">By:{{ $Vaccination_value->name }} (ID:
                                                    {{ $Vaccination_value->empid }})</span> <span
                                                    class="d-flex">{{ date('d M, Y D h:ia', strtotime($Vaccination_value->created_at)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="innnerrightpanel">
            <div class="rightpanelinnerbox">
                @include('vaccinations.create', compact('cuser'))
            </div>
        </div>
    </div>
@endsection
