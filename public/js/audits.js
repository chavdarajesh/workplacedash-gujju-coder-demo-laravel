jQuery(function(){
    if(window.location.hash) {        
        var hash = window.location.hash;            
        jQuery("#Auditcreatemodal").modal('toggle');
    }
});

jQuery(document).on('change','.adm_site_id_change',function(event){
    event.preventDefault();    
    var site_id=jQuery(this).val(); 
    if(site_id==''){return false;}
    var formtype=jQuery(this).data('formtype');     
    var editurl=site_url+'/audits/getsiteusers'; 
    jQuery('#auditsstore .adm_site_id_replace_html').html('<label for="exampleInputEmail1">Select Auditor<span class="required">*</span></label><br/>Users loading ..... please wait');
      
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {site_id:site_id},
        success: function(response){
            if(formtype=='add'){
                jQuery('#auditsstore .adm_site_id_replace_html').html(response);
            }
            if(formtype=='edit'){
                jQuery('#auditsupdate .adm_site_id_replace_html').html(response);
            }
        }
    });  
});

jQuery(document).on('click','.gcspauditedit',function(event){
    event.preventDefault();
    var adm_id=jQuery(this).data('adm_id');     
    var editurl=site_url+'/audits/edit';
    jQuery('body').removeClass('loaded');     
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {adm_id:adm_id},
        success: function(response){
            jQuery("#AuditEditmodal").html(response);
            jQuery("#AuditEditmodal").modal('toggle');
            jQuery(".site_id3").select2ToTree();
            jQuery('body').addClass('loaded');  

            if(jQuery('.gcspdatepickerstart').length){
                jQuery(".gcspdatepickerstart").datepicker({ 
                dateFormat: 'yy-mm-dd',      
                onSelect: function(date){
                    var selectedDate = new Date(date);
                    var msecsInADay = 86400000;
                    var endDate = new Date(selectedDate.getTime() + msecsInADay);       
                    jQuery(".gcspdatepickerend").datepicker( "option", "minDate", endDate );          
                }
                });
            } 
   
            if(jQuery('.gcspdatepickerend').length){
                jQuery(".gcspdatepickerend").datepicker({dateFormat: 'yy-mm-dd'});
            } 

        }
    });  
});

jQuery(document).on('click','.gcspauditdelete',function(event){
    event.preventDefault();
    if(confirm('Are you sure you want to delete this audit?')){
        var adm_id=jQuery(this).data('adm_id');     
        var editurl=site_url+'/audits/delete';
        jQuery('body').removeClass('loaded');     
        jQuery.ajax({
            url: editurl,
            type : 'POST',        
            data: {adm_id:adm_id},
            success: function(response){
                jQuery('.tr'+adm_id).remove();
                jQuery('body').addClass('loaded');
            }
        }); 
    } 
});

jQuery(document).on('change','.gcspaddkeyfindingchange',function(){
    var atpq_id=jQuery(this).data('atpq_id');
    var quefrmid=jQuery(this).closest('form').attr('id');        
    var ak_atpq_id=jQuery('#'+quefrmid+' input[name="atpq_id"]').val();
    var ak_adm_id=jQuery('#'+quefrmid+' input[name="adm_id"]').val();
    if(jQuery(this).prop("checked") == true){
        jQuery('.gckeyfinfingwpr'+atpq_id).slideDown();       
    }else{
        jQuery('.gckeyfinfingwpr'+atpq_id).slideUp();
        var editurl=site_url+'/audits/postkeyfindings';        
        jQuery.ajax({
            url: editurl,
            type : 'POST',        
            data: {ak_atpq_id:ak_atpq_id,ak_adm_id:ak_adm_id,deleted:1},
            success: function(response){
                jQuery('#'+quefrmid+' textarea[name="ak_keyfinding"]').val('');
                jQuery('.keyfinfindincount').html('Key Finding(s) ('+response+')');
                jQuery('.keyfinfindincountright').html(response);
            }
        });       
    }
});

jQuery(document).on('change','.gcspaddnotifychange',function(){
    var atpq_id=jQuery(this).data('atpq_id');
    var quefrmid=jQuery(this).closest('form').attr('id');        
    var aun_atpq_id=jQuery('#'+quefrmid+' input[name="atpq_id"]').val();    
    var aun_adm_id=jQuery('#'+quefrmid+' input[name="adm_id"]').val();
    if(jQuery(this).prop("checked") == true){
        jQuery('.gcnotifywpr'+atpq_id).slideDown();       
    }else{
        jQuery('.gcnotifywpr'+atpq_id).slideUp();
        var editurl=site_url+'/audits/postnotify';        
        jQuery.ajax({
            url: editurl,
            type : 'POST',        
            data: {aun_atpq_id:aun_atpq_id,aun_adm_id:aun_adm_id,deleted:1},
            success: function(response){

            }
        }); 

    }
});


jQuery(document).on('change','.ak_keyfinding',function(){
    var quefrmid=jQuery(this).closest('form').attr('id');
    var ak_keyfinding=jQuery(this).val();
    if(ak_keyfinding==''){return false;}
    var ak_atpq_id=jQuery('#'+quefrmid+' input[name="atpq_id"]').val();
    var ak_atp_id=jQuery('#'+quefrmid+' input[name="atpq_atp_id"]').val();
    var ak_atm_id=jQuery('#'+quefrmid+' input[name="atpq_atm_id"]').val();
    var ak_adm_id=jQuery('#'+quefrmid+' input[name="adm_id"]').val();
    var editurl=site_url+'/audits/postkeyfindings';        
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {ak_keyfinding:ak_keyfinding,ak_atpq_id:ak_atpq_id,ak_atp_id:ak_atp_id,ak_atm_id:ak_atm_id,ak_adm_id:ak_adm_id},
        success: function(response){
            jQuery('.keyfinfindincount').html('Key Finding(s) ('+response+')');
            jQuery('.keyfinfindincountright').html(response);
        }
    }); 
});

jQuery(document).on('change','.audit_notify',function(){
    var quefrmid=jQuery(this).closest('form').attr('id');    
    var audit_notify=jQuery(this).val();    
    if(audit_notify==''){return false;}
    var aun_atpq_id=jQuery('#'+quefrmid+' input[name="atpq_id"]').val();
    var aun_atp_id=jQuery('#'+quefrmid+' input[name="atpq_atp_id"]').val();
    var aun_atm_id=jQuery('#'+quefrmid+' input[name="atpq_atm_id"]').val();
    var aun_adm_id=jQuery('#'+quefrmid+' input[name="adm_id"]').val();
    var editurl=site_url+'/audits/postnotify';        
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {audit_notify:audit_notify,aun_atpq_id:aun_atpq_id,aun_atp_id:aun_atp_id,aun_atm_id:aun_atm_id,aun_adm_id:aun_adm_id},
        success: function(response){

        }
    }); 
});

jQuery(document).on('click','.gcspaddactiontoaudit',function(event){
    var quefrmid=jQuery(this).closest('form').attr('id'); 
    var atpq_id=jQuery('#'+quefrmid+' input[name="atpq_id"]').val();    
    var adm_id=jQuery('#'+quefrmid+' input[name="adm_id"]').val();
    var atp_id=jQuery('#'+quefrmid+' input[name="atpq_atp_id"]').val();
    var editurl=site_url+'/audits/getactionpopup';        
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {atpq_id:atpq_id,adm_id:adm_id,atp_id:atp_id},
        success: function(response){
            jQuery("#AuditActionModal").html(response);
            jQuery("#AuditActionModal").modal('toggle');
            jQuery(document).find('.multipleSelect').fastselect();      
        }
    });     
});

jQuery(document).on('submit','#addauditaction',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#addauditaction")[0]);     
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            jQuery('body').addClass('loaded');  
            jQuery("#AuditActionModal").modal('toggle');
            jQuery('.actionitemscount').html('Action Items ('+response+')');             
        }
    });
    return false;
});

jQuery(document).on('click','.auditactionsedit',function(event){
    var am_id=jQuery(this).data('am_id');
    var editurl=site_url+'/audits/geteditactionpopup';        
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {am_id:am_id},
        success: function(response){
            jQuery("#AuditActionModal").html(response);
            jQuery("#AuditActionModal").modal('toggle');
            jQuery(document).find('.multipleSelect').fastselect();      
        }
    });     
});

jQuery(document).on('click','.removeactiondoc',function(){
    event.preventDefault(); 
    if(confirm('Are you sure you want to delete this file, this file will not recoverd once deleted.?')){
        jQuery('body').removeClass('loaded');  
        jQuery.ajax({
            url: jQuery(this).attr('href'),
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

jQuery(document).on('submit','#Editauditaction',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#Editauditaction")[0]);     
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            window.location.reload();
        }
    });
    return false;
});

jQuery(document).on('click','.auditactionsdelete',function(event){
    var am_id=jQuery(this).data('am_id');
    if(confirm('Are you sure you want to delete this action, this file will not recoverd once deleted.?')){
        var editurl=site_url+'/audits/deleteactionitem';        
        jQuery.ajax({
            url: editurl,
            type : 'POST',        
            data: {am_id:am_id},
            success: function(response){
                window.location.reload();
            }
        });  
    }       
});


jQuery(document).on('change','.gcspansewertoaudit',function(){
    var quefrmid=jQuery(this).closest('form').attr('id'); 
    var atpq_id=jQuery('#'+quefrmid+' input[name="atpq_id"]').val();
    var editurl=jQuery(this).closest('form').attr('action'); 
    var answer=jQuery(this).val();    
    if(answer==''){return false;}
    var data = new FormData(jQuery("#"+quefrmid)[0]);         
    jQuery.ajax({
        url: editurl,
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            if(response!=1){
                jQuery('.gcspsubquestionwpr'+atpq_id).html(response);
            }else{
                jQuery('.gcspsubquestionwpr'+atpq_id).html('');
            }
            jQuery('#'+quefrmid+' .keyfnotifysection').addClass('showkfandnotify');

            if(jQuery('.site_id_audit').length){
                jQuery(".site_id_audit").each(function() {
                  var selectid=jQuery(this).attr('id');
                  jQuery("#"+selectid).select2ToTree();
                });
            }                

        }
    });    


});


jQuery(document).on('change', '.file-upload-audit', function(e) {
    var fileNameExt = '';
    var fileName = '';
    var files = e.target.files,
        filesLength = parseInt(files.length);
    var maxfile=jQuery(this).data('maxfile');
    if(maxfile==''){maxfile=100;}
    var quefrmid=jQuery(this).closest('form').attr('id'); 
    var addedfilecount=parseInt(jQuery('#'+quefrmid+' .pip').length);
    var totalfile=addedfilecount+filesLength;   
    
    if(totalfile>maxfile){ alert('Uploading more than '+maxfile+' attachment(s) is not allowed !'); return false;}    
    var atpq_divid=jQuery('#'+quefrmid+' input[name="atpq_divid"]').val();    
    var editurl=site_url+'/audits/ansewertoauditfiles';        
    var answer=jQuery(this).val();    
    if(answer==''){return false;}
    var data = new FormData(jQuery("#"+quefrmid)[0]);         
    jQuery.ajax({
        url: editurl,
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            jQuery(response).insertAfter('#fileinstedtimg'+atpq_divid);  
            jQuery('#'+quefrmid+' .keyfnotifysection').addClass('showkfandnotify');
            jQuery('#'+quefrmid+' .file-upload-audit').removeClass('required'); 
            jQuery('#'+quefrmid+' .file-upload-audit').val('');         
        }
    });    

    
});

jQuery(document).on('click','.removeimgaudit',function(event){
    event.preventDefault();
    var quefrmid=jQuery(this).closest('form').attr('id');
    if(confirm('Are you sure you want to delete this attachment?')){
        var aam_id=jQuery(this).data('aam_id');     
        var editurl=site_url+'/audits/deleteansattachment';
        
        jQuery.ajax({
            url: editurl,
            type : 'POST',        
            data: {aam_id:aam_id},
            success: function(response){
                jQuery('.pip'+aam_id).remove(); 
                if(jQuery('#'+quefrmid+' .pip').length==0){
                    jQuery('#'+quefrmid+' .file-upload-audit').removeClass('valid');
                    jQuery('#'+quefrmid+' .file-upload-audit').addClass('required');

                }
            }
        }); 
    } 
});


jQuery(document).on('change','.addgridvalueadans',function(){
    var quefrmid=jQuery(this).closest('form').attr('id');    
    var aam_answer=jQuery(this).val();    
    var aam_opt_id=jQuery(this).data('aam_opt_id');    
    if(aam_answer==''){return false;}
    var aun_atpq_id=jQuery('#'+quefrmid+' input[name="atpq_id"]').val();
    var aun_atp_id=jQuery('#'+quefrmid+' input[name="atpq_atp_id"]').val();
    var aun_atm_id=jQuery('#'+quefrmid+' input[name="atpq_atm_id"]').val();
    var aun_adm_id=jQuery('#'+quefrmid+' input[name="adm_id"]').val();
    var editurl=site_url+'/audits/postgridanswer';        
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {aam_answer:aam_answer,aam_opt_id:aam_opt_id,aun_atpq_id:aun_atpq_id,aun_atp_id:aun_atp_id,aun_atm_id:aun_atm_id,aun_adm_id:aun_adm_id},
        success: function(response){
            jQuery('#'+quefrmid+' .keyfnotifysection').addClass('showkfandnotify');
        }
    }); 
});

jQuery(document).on('click','.getauditbystatus',function(event){
    var editurl=site_url+'/audits'; 
    var status=jQuery(this).data('value'); 
    jQuery('.searchaudittop input[name="status"]').val(status);       
    jQuery('.audittopfilter input[name="status"]').val(status);       
    jQuery('body').removeClass('loaded');                    
    jQuery.get(
        editurl, {status:status}, 
        function (response) {
            //jQuery('.gcspauditlistresponce').html(data);            
            var obj = jQuery.parseJSON(response);
            jQuery('.gcspajaxresponcesitevise').html(obj.view); 
            jQuery('.active.getauditbystatus span').html(obj.curentcount);            
            jQuery('body').addClass('loaded');                    
        }
    );
});

jQuery(document).on('click','.hidekeyfindindsec',function(event){    
    var ak_atp_id=jQuery(this).data('ak_atp_id');        
    jQuery('.gcspquetionwpr'+ak_atp_id).slideToggle(200);    
});

jQuery(document).on('click','.gcspshowtimeline',function(event){        
    jQuery('.timelinearea').slideToggle(200);    
});

jQuery('.templaterightpanel form').each(function () {        
    jQuery(jQuery(this).attr('id')).validate({
        debug: true
    });
}); 
jQuery(document).on('click','.checkallvalidation',function(event){ 
    event.preventDefault();  
    var sectionsuccess=1;
    jQuery('.templaterightpanel form').each(function () {
        if (!jQuery(this).valid()) {
            jQuery('html, body').animate({  scrollTop: jQuery('#'+jQuery(this).attr('id')).offset().top  }, 200);
            sectionsuccess=2;
            return false;            
        }
    }); 
    if(sectionsuccess==1){
        jQuery('body').removeClass('loaded'); 
        var adm_id=jQuery('input[name="cadm_id"]').val();
        var atp_id=jQuery('input[name="catp_id"]').val(); 
        var editurl=site_url+'/audits/auditsectioncomplete'; 
        jQuery.ajax({
            url: editurl,
            type : 'POST',        
            data: {adm_id:adm_id,atp_id:atp_id},
            success: function(response){
                jQuery('body').addClass('loaded'); 
                jQuery('.gcspauditcompletebtn').prop('disabled',false); 
                  
            }
        });
    }    
});

jQuery(document).on('click','.gcspredirecturl ',function(event){
    var redirecturl=jQuery(this).data('href');
    window.location.href = redirecturl;    
});

jQuery(document).on('click','.checknextpagevalidation',function(event){ 
event.preventDefault(); 
    var redirecturl=jQuery(this).data('href');
    var adm_id=jQuery('input[name="cadm_id"]').val();
    var atp_id=jQuery('input[name="catp_id"]').val();
    
    var redirect = 1;
    jQuery('.templaterightpanel form').each(function () {
        if (!jQuery(this).valid()) {
            jQuery('html, body').animate({  scrollTop: jQuery('#'+jQuery(this).attr('id')).offset().top  }, 200);
            redirect=2;
            return false;
        }
    }); 
    if(redirect==1){
        var editurl=site_url+'/audits/auditsectioncomplete'; 
        jQuery.ajax({
            url: editurl,
            type : 'POST',        
            data: {adm_id:adm_id,atp_id:atp_id},
            success: function(response){
                window.location.href = redirecturl;    
            }
        });
    }
    
});


jQuery(document).on('click','.gcspviewbymonthday',function(event){    
    var site_id=jQuery(this).data('site_id');    
    var atm_id=jQuery(this).data('atm_id');    
    var month=jQuery(this).data('month');    
    var year=jQuery(this).data('year');    
    var editurl=site_url+'/audits/getauditbymonth';        
    jQuery.ajax({
        url: editurl,
        type : 'POST',        
        data: {site_id:site_id,atm_id:atm_id,month:month,year:year},
        success: function(response){
            jQuery("#AuditViewMonth").html(response);
            jQuery("#AuditViewMonth").modal('toggle');            
        }
    });     
});

jQuery(document).on('click','.searchaudittopclose',function(event){
    jQuery('#auditsitewisefilter')[0].reset();
    jQuery('#auditsitewisesearch')[0].reset();
    jQuery('.searchaudittop').slideUp();
    jQuery('.audittopfilter').slideUp();
    jQuery('#auditsitewisefilter').trigger('submit');
    jQuery(".site_id3").prop('selectedIndex',0);
    jQuery(".site_id3").select2ToTree(); 
});

jQuery(document).on('click','.filtersearch',function(event){
    jQuery('.audittopfilter').slideUp();
    jQuery('.searchaudittop').slideToggle();
    jQuery('#auditsitewisefilter')[0].reset();
    jQuery('#auditsitewisesearch')[0].reset(); 
    jQuery(".site_id3").prop('selectedIndex',0);
    jQuery(".site_id3").select2ToTree();    
});

jQuery(document).on('click','.filternormal',function(event){
    jQuery('.searchaudittop').slideUp();
    jQuery('.audittopfilter').slideToggle();
    jQuery('#auditsitewisefilter')[0].reset();
    jQuery('#auditsitewisesearch')[0].reset();
    jQuery(".site_id3").prop('selectedIndex',0);
    jQuery(".site_id3").select2ToTree(); 
});


jQuery(document).on('submit','#auditsitewisefilter',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#auditsitewisefilter")[0]);     
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            var obj = jQuery.parseJSON(response);
            jQuery('.gcspajaxresponcesitevise').html(obj.view);
            jQuery('.active.getauditbystatus span').html(obj.curentcount);             
            jQuery('body').addClass('loaded');                          
        }
    });
    return false;
});

jQuery(document).on('submit','#auditsitewisesearch',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#auditsitewisesearch")[0]);     
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            var obj = jQuery.parseJSON(response);
            jQuery('.gcspajaxresponcesitevise').html(obj.view);
            jQuery('.active.getauditbystatus span').html(obj.curentcount);             
            jQuery('body').addClass('loaded');                          
        }
    });
    return false;
});
