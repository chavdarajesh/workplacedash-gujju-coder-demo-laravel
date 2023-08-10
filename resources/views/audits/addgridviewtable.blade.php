<div class="table-responsive {{$noofcolumns}} {{$noofrows}} gridviewfrontend">
<table class="table table-bordered">
    <thead>
    <tr>
<?php 
$required='';
if($AuditQuestionsValue->atpq_is_mandatory==1){$required='required';}
?>
    <?php for ($j=1; $j <=$noofcolumns ; $j++) {
        $ago_keyword='col'.$j.$AuditQuestionsValue->atpq_atp_id.$AuditQuestionsValue->atpq_id;
        $colvalue=(array_key_exists($ago_keyword, $GridViewOption))?$GridViewOption[$ago_keyword]:'';
        ?> 
        @if($j==1)
            <th>{{$AuditQuestionsValue->atpq_table_heading}}</th>
        @endif
        <th>{{$colvalue}}</th>
    <?php } ?>
    </tr>
</thead>
<?php for ($i=1; $i <=$noofrows ; $i++) {?> 
    <tr>
    <?php for ($j=1; $j <=$noofcolumns ; $j++) {
        $ago_keyword='row'.$i.$AuditQuestionsValue->atpq_atp_id.$AuditQuestionsValue->atpq_id;
        $rowvalue=(array_key_exists($ago_keyword, $GridViewOption))?$GridViewOption[$ago_keyword]:'';
        ?> 
        @if($j==1)
            <th class="firstcoltitle"><span>{{$rowvalue}}</span></th>
        @endif
        <td>
            <div class="form-group mb-0">
                @if (Request::is('audits/*/keyfindings'))
                <p><?php echo (array_key_exists($i.$j, $answerdata))?$answerdata[$i.$j]:''; ?></p>
                @else                
                <input {{$required}} type="text" data-aam_opt_id="{{$i.$j}}" value="<?php echo (array_key_exists($i.$j, $answerdata))?$answerdata[$i.$j]:''; ?>" name="aam_answer" class="form-control addgridvalueadans {{$required}}">
                @endif
            </div>
        </td>
    <?php } ?>
    </tr>
<?php } ?>
</table>
</div>