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
