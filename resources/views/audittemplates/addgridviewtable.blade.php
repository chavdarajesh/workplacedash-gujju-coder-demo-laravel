<div class="table-responsive {{$noofcolumns}} {{$noofrows}}">
<table class="table table-bordered">
    <tr>
    <?php for ($j=1; $j <=$noofcolumns ; $j++) {
        $ago_keyword='col'.$j.$AuditQuestionsValue->atpq_atp_id.$AuditQuestionsValue->atpq_id;
        $colvalue=(array_key_exists($ago_keyword, $GridViewOption))?$GridViewOption[$ago_keyword]:'';
        ?> 
        @if($j==1)
            <td><span class="required">*</span><input type="text"  value="{{$AuditQuestionsValue->atpq_table_heading}}" required name="atpq_table_heading" placeholder="Table Heading" class="form-control"></td>
        @endif
        <td><span class="required">*</span><input type="text" required name="gridvalues" data-ago_keyword="{{$ago_keyword}}"  data-ago_atp_id="{{$AuditQuestionsValue->atpq_atp_id}}" data-ago_atpq_id="{{$AuditQuestionsValue->atpq_id}}" data-ago_atm_id="{{$AuditQuestionsValue->atpq_atm_id}}"  placeholder="Col Head {{$j}}" class="form-control" value="{{$colvalue}}"></td>
    <?php } ?>
    </tr>
<?php for ($i=1; $i <=$noofrows ; $i++) {?> 
    <tr>
    <?php for ($j=1; $j <=$noofcolumns ; $j++) {
        $ago_keyword='row'.$i.$AuditQuestionsValue->atpq_atp_id.$AuditQuestionsValue->atpq_id;
        $rowvalue=(array_key_exists($ago_keyword, $GridViewOption))?$GridViewOption[$ago_keyword]:'';
        ?> 
        @if($j==1)
            <td><span class="required">*</span><input type="text" name="gridvalues" required data-ago_keyword="{{$ago_keyword}}" data-ago_atp_id="{{$AuditQuestionsValue->atpq_atp_id}}" data-ago_atpq_id="{{$AuditQuestionsValue->atpq_id}}" data-ago_atm_id="{{$AuditQuestionsValue->atpq_atm_id}}" placeholder="Row Head {{$j}}" class="form-control gcspdisablerowhead" value="{{$rowvalue}}"></td>
        @endif
        <td></td>
    <?php } ?>
    </tr>
<?php } ?>
</table>
</div>