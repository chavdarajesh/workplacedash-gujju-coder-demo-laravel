jQuery(document).on('click','.audittemplatesedit',function(){
    event.preventDefault(); 
    var editurl=jQuery(this).attr('href');    
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: editurl,
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: 1,
        success: function(response){
            jQuery('.innnerrightpanel .rightpanelinnerbox').html(response);
            jQuery(document).find('.multipleSelect').fastselect();                
            jQuery('body').addClass('loaded');              
        }
    });
});

jQuery(document).on('click','.audittemplatescreate',function(){
    event.preventDefault(); 
    var editurl=jQuery(this).attr('href');    
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: editurl,
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: 1,
        success: function(response){
            jQuery('.innnerrightpanel .rightpanelinnerbox').html(response);            
            jQuery('body').addClass('loaded');              
        }
    });
});

jQuery(document).on('click','.audittemplatesdelete',function(){
    event.preventDefault();
    if(confirm('Are you sure you want to delete this Audit Template?')){ 
        jQuery('body').removeClass('loaded');  
        jQuery.ajax({
            url: jQuery(this).attr('href'),
            type : 'POST',
            cache: false,
            contentType: false,
            processData: false,   
            data: 1,
            success: function(response){
                jQuery('.gcspaudittemplate'+response).remove();
                jQuery('body').addClass('loaded');              
            }
        });
    }
});

jQuery(document).on('click','.removeimgsingleicon',function(){
    event.preventDefault(); 
    if(confirm('Are you sure you want to delete this file, this file will not recoverd once deleted.?')){
        jQuery('body').removeClass('loaded');  
        jQuery.ajax({
            url: jQuery(this).data('href'),
            type : 'POST',
            cache: false,
            contentType: false,
            processData: false,   
            data: 1,
            success: function(response){
                jQuery('.pip'+response).remove();
                jQuery('body').addClass('loaded');              
            }
        });
    }
});
jQuery(document).on('click','.gcspaddtmpsection',function(){
    event.preventDefault(); 
    jQuery('.gcspnewsectionarea').slideDown();
});    


jQuery(document).on('submit','#storesection',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#storesection")[0]); 
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            jQuery(".tmpsctionmain ul").append(response);
            jQuery("#storesection")[0].reset();
            jQuery('.gcspnewsectionarea').slideUp();
            jQuery('body').addClass('loaded');  
        }
    });
});

jQuery(document).on('click','.addnewquestion',function(){
    event.preventDefault(); 
    var editurl=jQuery(this).attr('href');   
    var atp_id= jQuery(this).data('atp_id');
    var atp_atm_id= jQuery(this).data('atp_atm_id');
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {atp_id:atp_id,atp_atm_id:atp_atm_id},
        success: function(response){
            jQuery('.gcspaddnewquetionwpr').before(response);                        
        }
    });
});

jQuery(document).on('click','.addnewsubquetions',function(){
    event.preventDefault(); 
    var editurl=jQuery(this).attr('href'); 
    var divid=jQuery(this).data('divid');        
    var option_id=jQuery(this).data('option_id');        

    var atp_id=jQuery(this).data('atp_id');        
    var atp_atm_id=jQuery(this).data('atp_atm_id');        
    var atpq_id=jQuery(this).data('atpq_id');        

    jQuery.ajax({
        url: editurl,
        type : 'POST',
        
        data: {divid:divid,option_id:option_id,atp_id:atp_id,atp_atm_id:atp_atm_id,atpq_id:atpq_id},
        success: function(response){
            jQuery('.addnewsubquetions'+divid).before(response);                        
        }
    });
});

jQuery(document).on('change','.atpq_type',function(){
    event.preventDefault(); 
    var editurl=site_url+'/audit-templates/addnewquestionoption';
    var atpq_type=jQuery(this).val();
    var divid=jQuery(this).data('divid');    
    var atpq_id=jQuery(this).data('atpq_id');    
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {atpq_type:atpq_type,divid:divid,atpq_id:atpq_id},
        success: function(response){
            jQuery('.gcspquetionwpr'+divid+' .questionruleswpr').html(response); 
            if(atpq_type==3){
                jQuery(".gcspdatepicker").datepicker({     dateFormat: 'dd-mm-yy'  });                       
            }
            if(atpq_type==2){
                jQuery(".CheckBoxOptionModal"+divid).slideDown(); 
            }else{
                jQuery(".CheckBoxOptionModal"+divid).slideUp();
                jQuery(".gcsprulescontaner"+divid).html('');                
            }
        }
    });
});

jQuery(document).on('change','.gcspshowdescription',function(){
    var divid=jQuery(this).data('divid');
    if(jQuery(this).prop("checked") == true){
        jQuery('.gcspquetionwpr'+divid+' .hideDescription').slideDown();       
    }else{
        jQuery('.gcspquetionwpr'+divid+' .hideDescription').slideUp();       
    }
});

jQuery(document).on('change','.gcspgriedvireadd',function(){
    event.preventDefault(); 
    var editurl=site_url+'/audit-templates/addgridviewtable';
    var divid=jQuery(this).data('divid');   
    var atpq_id=jQuery(this).data('atpq_id');    
    var noofrows=jQuery('.gcspgridviewinput'+divid+' input[name="atpq_no_of_rows"]').val();
    var noofcolumns=jQuery('.gcspgridviewinput'+divid+' input[name="atpq_no_of_columns"]').val();    
    if(noofrows=='' || noofcolumns=='' || noofrows==0 || noofcolumns==0){ jQuery('.gridview'+divid).html(''); return false;}
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {noofrows:noofrows,noofcolumns:noofcolumns,divid:divid,atpq_id:atpq_id},
        success: function(response){
            jQuery('.gridview'+divid).html(response);             
        }
    });
});

jQuery(document).on('change','.gcspdisablerowheadcheck',function(){
    var divid=jQuery(this).data('divid');
    if(jQuery(this).prop("checked") == true){
      jQuery('.gcspquetionwpr'+divid+' .gcspdisablerowhead').prop('disabled',true).addClass('gcspchangeplacehoderclr').prop('required',false);
      jQuery('.gcspquetionwpr'+divid+' .gcspdisablerowhead').parent('td').addClass('hideastrick');
    }else{
      jQuery('.gcspquetionwpr'+divid+' .gcspdisablerowhead').prop('disabled',false).removeClass('gcspchangeplacehoderclr').prop('required',true);
      jQuery('.gcspquetionwpr'+divid+' .gcspdisablerowhead').parent('td').removeClass('hideastrick');
    }
});

jQuery(document).on('click','.gpqustionremove',function(){
    event.preventDefault(); 
    var divid=jQuery(this).data('divid');    
    var atpq_id=jQuery(this).data('atpq_id');    
    var editurl=site_url+'/audit-templates/deletequstion';    
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {atpq_divid:divid,atpq_id:atpq_id},
        success: function(response){
            jQuery('.gcspquetionwpr'+divid).remove();
        }
    });  
    
});

jQuery(document).on('click','.gcspremoveoptioninpopup',function(){
    event.preventDefault(); 
    var divid=jQuery(this).data('divid');  
    jQuery(this).closest('.row').remove();
    jQuery('#CheckBoxOptionModal'+divid+' .gcspsavenewoption').prop('disabled',false);
});

jQuery(document).on('click','.gcspaddnewoptionvaluewpr a',function(){
    event.preventDefault(); 
    var divid=jQuery(this).data('divid');  
    jQuery('#CheckBoxOptionModal'+divid+' .gcspoptioncontaner').append('<div class="row mb-2"> <div class="col-sm-6"><input type="text" class="form-control aco_name" data-divid="'+divid+'" required="required" name="aco_name[]" value=""></div> <div class="col-sm-1 gcspcolopickerrel"> <input type="hidden" class="form-control gcsptopncolorvalue" value="1" name="optcolor[]"> <span class="gcspcolorcircle gcspcolorcirclechange optcolor1"></span> <div class="gcspcolopickerwpr"> <span class="gcspcolorcircle optcolor1" data-value="1"></span> <span class="gcspcolorcircle optcolor2" data-value="2"></span> <span class="gcspcolorcircle optcolor3" data-value="3"></span> <span class="gcspcolorcircle optcolor4" data-value="4"></span> <span class="gcspcolorcircle optcolor5" data-value="5"></span> <span class="gcspcolorcircle optcolor6" data-value="6"></span> <span class="gcspcolorcircle optcolor7" data-value="7"></span> <span class="gcspcolorcircle optcolor8" data-value="8"></span> </div> </div> <div class="col-sm-1"><a data-divid="'+divid+'" class="gcspremoveoptioninpopup" href="javascript:void(0);"><i class="fa fa-trash"></i></a></div> </div>'); 
    jQuery('#CheckBoxOptionModal'+divid+' .gcspoptioncontaner input[name="aco_grpid_id"]').val(divid);
    jQuery('#CheckBoxOptionModal'+divid+' .gcspaddnewoptionsavecheck').slideDown();
    jQuery('#CheckBoxOptionModal'+divid+' .gcspsavenewoption').prop('disabled',false);
});
    
jQuery(document).on('click','.gcspcolopickerwpr .gcspcolorcircle',function(){
    event.preventDefault(); 

    var colorid=jQuery(this).data('value');
    jQuery(this).closest('.gcspcolopickerrel').find('.gcspcolorcirclechange').removeClass('optcolor1 optcolor2 optcolor3 optcolor4 optcolor5 optcolor6 optcolor7 optcolor8');    
    jQuery(this).closest('.gcspcolopickerrel').find('.gcspcolorcirclechange').addClass('optcolor'+colorid);    
    jQuery(this).closest('.gcspcolopickerrel').find('.gcsptopncolorvalue').val(colorid);
    jQuery('.addoptcheckbox').slideUp();
    jQuery(this).closest('.modal-content').find('.gcspaddnewoptionsavecheck').slideDown();
    jQuery(this).closest('.modal-content').find('.gcspsavenewoption').prop('disabled',false);
    
});

jQuery(document).on('change','.gcspckbaddpreoption',function(){
    event.preventDefault(); 

    var editurl=site_url+'/audit-templates/checkboxoptionchange';
    var divid=jQuery(this).data('divid');
    jQuery('#CheckBoxOptionModal'+divid+' .gcspaddnewoptionsavecheck').slideUp();
    jQuery('#CheckBoxOptionModal'+divid+' .gcspaddnewoptionsavecheck input[name="Addthisasanewoption"]').prop('checked',false);
    var aco_grpid_id=jQuery(this).val(); 
    jQuery('body').removeClass('loaded');     
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {divid:divid,aco_grpid_id:aco_grpid_id},
        success: function(response){
            jQuery('.gcspoptioncontaner'+divid).html(response);  
            jQuery('body').addClass('loaded'); 
            jQuery('#CheckBoxOptionModal'+divid+' .gcspsavenewoption').prop('disabled',false);               
        }
    });

});

jQuery(document).on('change','.aco_name',function(){
    event.preventDefault(); 
    var divid=jQuery(this).data('divid');
    jQuery('#CheckBoxOptionModal'+divid+' .gcspoptioncontaner input[name="aco_grpid_id"]').val(divid);
    jQuery('#CheckBoxOptionModal'+divid+' .gcspaddnewoptionsavecheck').slideDown();
    jQuery('#CheckBoxOptionModal'+divid+' .gcspsavenewoption').prop('disabled',false);
});

jQuery(document).on('click','.gcspsavenewoption',function(event){
    event.preventDefault(); 
    var allowSubmit = true;

    var divid=jQuery(this).data('divid');
    var data = new FormData(jQuery("#mainqustionfrm"+divid)[0]); 
    //jQuery("input:empty").length == 0;
    if(jQuery("#mainqustionfrm"+divid+' input[type="text"]').length==0){
        alert('Please add field or select from top option');
        allowSubmit = false;
        return false;
    }

    jQuery("#mainqustionfrm"+divid+' input[type="text"]').each(function(e){
        if( jQuery(this).val() == "" ){
            alert('Please fill all the fields');
            jQuery(this).focus();
            allowSubmit = false;
            return false;
        }
    });
    

    if (allowSubmit) {
        jQuery('body').removeClass('loaded');      
        jQuery.ajax({
            url: site_url+'/audit-templates/checkboxoptionsave',
            type : 'POST',
            cache: false,
            contentType: false,
            processData: false,   
            data: data,
            success: function(response){
                jQuery("#mainqustionfrm"+divid+" .close").trigger('click');
                jQuery("#mainqustionfrm"+divid+" .closemodal").trigger('click');
                jQuery(".gcspquetionwpr"+divid+" .gcsprulesckdiv").removeClass('gcsprulesckdivhide');
                jQuery('.gcsprulescontaner'+divid).html(response);  
                jQuery('body').addClass('loaded');      
            }
        });
    }
});

jQuery(document).on('change','.gcsphaverules',function(){
    var divid=jQuery(this).data('divid');
    if(jQuery(this).prop("checked") == true){
        jQuery('.gcsprulescontaner'+divid).slideDown();       
    }else{
        jQuery('.gcsprulescontaner'+divid).slideUp();       
    }
});

jQuery(document).on('click','.delelteseaction',function(){
    event.preventDefault(); 
    if(confirm('Are you sure you want to delete this Audit Template Section?')){ 
        var editurl=jQuery(this).attr('href');    
        jQuery('body').removeClass('loaded');  
        jQuery.ajax({
            url: editurl,
            type : 'POST',
            cache: false,
            contentType: false,
            processData: false,   
            data: 1,
            success: function(response){
                location.reload();
            }
        });
    }    
});

jQuery(document).on('change','.changesectionstatus',function(){
    event.preventDefault(); 
    var atp_id=jQuery(this).data('atp_id');  
    if(jQuery(this).prop("checked") == true){ var atp_status=1;  }else{    var atp_status=0;  }  
    var editurl=site_url+'/audit-templates/changesectionstatus';    
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {atp_status:atp_status,atp_id:atp_id},
        success: function(response){            
        }
    });    
});

jQuery(document).on('click','.editpencilatpname',function(){
    jQuery('.editpencilatpnametext').slideToggle();
});

jQuery(document).on('change blur','.editpencilatpnametext',function(){
    event.preventDefault(); 
    var atp_id=jQuery(this).data('atp_id'); 
    var atp_name=jQuery(this).val();          
    var editurl=site_url+'/audit-templates/changesectionname';    
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {atp_name:atp_name,atp_id:atp_id},
        success: function(response){ 
             jQuery('.editpencilatpnametext').slideUp();
             jQuery('.atp_nameheading').html(atp_name);         
             jQuery('.atp_nameheading'+atp_id).html(atp_name);         
        }
    });    
});

jQuery(document).on('change','.addupdatequstion input,.addupdatequstion textarea,.addupdatequstion select',function(event){
    event.preventDefault();
    var eventname=event.type;
    var inputname=jQuery(this).attr('name');
    var divid=jQuery(this).closest('form').find('input[name="atpq_divid"]').val();    
    if(eventname=='change' && inputname=='atpq_type'){return false;}

    if(eventname=='change' && inputname=='atpq_is_multiple_choice'){
        if(jQuery(this).prop("checked") == true){
            jQuery('.gcsprulesckdiv'+divid).hide();
            jQuery('.gcsprulesckdiv'+divid+' input[name="atpq_is_rules"]').prop("checked",false);
            jQuery('.gcsprulescontaner'+divid).hide();            
        }else{
            jQuery('.gcsprulesckdiv'+divid).show();            
        }
    }    

    if(eventname=='change' && inputname=='gridvalues'){

        var ago_atp_id=jQuery(this).data('ago_atp_id'); 
        var ago_atpq_id=jQuery(this).data('ago_atpq_id'); 
        var ago_keyword=jQuery(this).data('ago_keyword'); 
        var ago_atm_id=jQuery(this).data('ago_atm_id'); 
        var ago_value=jQuery(this).val();        
        var editurl=site_url+'/audit-templates/addvaluetogridoption';    
        jQuery.ajax({
            url: editurl,
            type : 'POST',        
            data: {ago_atp_id:ago_atp_id,ago_atpq_id:ago_atpq_id,ago_keyword:ago_keyword,ago_value:ago_value,ago_atm_id:ago_atm_id},
            success: function(response){

            }
        });  

    }else{
        
        var data = new FormData(jQuery("#mainqustionfrm"+divid)[0]); 
        var atpq_question =data.get('atpq_question');
        if(atpq_question==''){return false;}    
        jQuery.ajax({
            url: jQuery("#mainqustionfrm"+divid).attr('action'),
            type : 'POST',
            cache: false,
            contentType: false,
            processData: false,   
            data: data,
            success: function(response){
                jQuery("#mainqustionfrm"+divid+' input[name="atpq_id"]').val(response);
            }
        }); 
    }  
});

