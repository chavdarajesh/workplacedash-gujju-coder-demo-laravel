<input type="hidden" name="aco_grpid_id" value="{{$aco_grpid_id}}" >
@foreach($CheckBoxOption as $CheckBoxOptionItem)
<div class="row mb-2">
    <div class="col-sm-6"><input type="text" class="form-control aco_name" data-divid="{{$divid}}" required name="aco_name[]" value="{{$CheckBoxOptionItem->aco_name}}"></div>
    <div class="col-sm-1 gcspcolopickerrel">
        <input type="hidden" class="form-control gcsptopncolorvalue" value="{{$CheckBoxOptionItem->optcolor}}" name="optcolor[]">
        <span class="gcspcolorcircle gcspcolorcirclechange optcolor{{$CheckBoxOptionItem->optcolor}}"></span>
        <div class="gcspcolopickerwpr">
            <span class="gcspcolorcircle optcolor1" data-value="1"></span>
            <span class="gcspcolorcircle optcolor2" data-value="2"></span>
            <span class="gcspcolorcircle optcolor3" data-value="3"></span>
            <span class="gcspcolorcircle optcolor4" data-value="4"></span>
            <span class="gcspcolorcircle optcolor5" data-value="5"></span>
            <span class="gcspcolorcircle optcolor6" data-value="6"></span>
            <span class="gcspcolorcircle optcolor7" data-value="7"></span>
            <span class="gcspcolorcircle optcolor8" data-value="8"></span>
        </div>    
    </div>
    <div class="col-sm-1"><a data-divid="{{$divid}}" class="gcspremoveoptioninpopup" href="javascript:void(0);"><i class="fa fa-trash"></i></a></div>
</div>
@endforeach