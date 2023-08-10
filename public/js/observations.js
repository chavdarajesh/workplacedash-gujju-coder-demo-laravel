jQuery(document).on('change','input[name="listing_type"]',function(){
   jQuery(this).closest("form").find('button[type="submit"]').removeClass('btn-secondary').addClass('btn-primary');
});


jQuery(document).on('submit','#observationsstore',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#observationsstore")[0]); 
    jQuery('body').removeClass('loaded');  
    jQuery('.is-invalid').removeClass('is-invalid');
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            //jQuery('#gc-observsnopen .gc-observation-userdtl .row').append(response);
            jQuery('.observationlist.active').trigger('click');                          
            jQuery('#observationsstore')[0].reset();
            jQuery('.gcsphideactionsmain').hide();            
            jQuery('.rowobjacrionwp').remove();  
            jQuery('.pip').remove();                          
            jQuery(".oc_id2").select2ToTree(); 
            jQuery(".site_id2").select2ToTree();              
            srno=0;
            jQuery('body').addClass('loaded');  
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            var err = eval("(" + xhr.responseText + ")");            
            if(err.errors.oc_id){jQuery('.classoc_id').addClass('is-invalid'); }
            if(err.errors.description){jQuery('.classdescription').addClass('is-invalid');}
            if(err.errors.site_id){jQuery('.classsite_id').addClass('is-invalid');}
            if(err.errors.obdatetime){jQuery('.classobdatetime').addClass('is-invalid');}
            if(err.errors.action_required){jQuery('.classaction_required').addClass('is-invalid');}
            if(err.errors.riskpotentiallevel){jQuery('.classriskpotentiallevel').addClass('is-invalid');}
            if(err.errors.Comments){jQuery('.classComments').addClass('is-invalid');}
            if(err.errors.listing_type){jQuery('.classlisting_type').addClass('is-invalid');}
            jQuery("#observationsstore").find('button[type="submit"]').addClass('btn-secondary').removeClass('btn-primary');
            jQuery('body').addClass('loaded');  
        }
    });
});

jQuery(document).on('click','.observationedit',function(){
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
            jQuery(".oc_id2").select2ToTree(); 
            jQuery(".site_id2").select2ToTree();
            jQuery('body').addClass('loaded');              
        }
    });
});

jQuery(document).on('click','.observationscreate',function(){
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
            jQuery(".oc_id2").select2ToTree(); 
            jQuery(".site_id2").select2ToTree();
            jQuery('body').addClass('loaded');              
        }
    });
});

jQuery(document).on('click','.observationscreatehide',function(){
    jQuery('.innnerrightpanel .rightpanelinnerbox').html('');
});


jQuery(document).on('submit','#observationupdate',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#observationupdate")[0]); 
    var ob_id=jQuery("#observationupdate input[name='ob_id']").val();    
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            var obj = jQuery.parseJSON( response );
            jQuery('.gcobseritem'+ob_id).html(obj.respond);
            //jQuery('.observationscreate').trigger('click');
            jQuery('.observationlist.active').trigger('click');                          
            jQuery('#gc-observsnopen-tab').html('open <sub>('+obj.open+')</sub>');
            jQuery('#gc-observsnclose-tab').html('closed <sub>('+obj.closed+')</sub>');                          
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            var err = eval("(" + xhr.responseText + ")");            
            if(err.errors.oc_id){jQuery('.classoc_id').addClass('is-invalid'); }
            if(err.errors.description){jQuery('.classdescription').addClass('is-invalid');}
            if(err.errors.site_id){jQuery('.classsite_id').addClass('is-invalid');}
            if(err.errors.obdatetime){jQuery('.classobdatetime').addClass('is-invalid');}
            if(err.errors.action_required){jQuery('.classaction_required').addClass('is-invalid');}
            if(err.errors.riskpotentiallevel){jQuery('.classriskpotentiallevel').addClass('is-invalid');}
            if(err.errors.Comments){jQuery('.classComments').addClass('is-invalid');}            
            jQuery('body').addClass('loaded');  
        }
    });
});


jQuery(document).on('click','.observationdelete',function(){
    
    if(confirm('Are you sure you want to delete this Near Miss?')){ 
        event.preventDefault();
        jQuery('body').removeClass('loaded');  
        jQuery.ajax({
            url: jQuery(this).attr('href'),
            type : 'POST',
            cache: false,
            contentType: false,
            processData: false,   
            data: 1,
            success: function(response){
                jQuery('.gcobseritem'+response).remove();
                jQuery('body').addClass('loaded');              
            }
        });
    }
});

jQuery(document).on('click','.observationrestore',function(){
    event.preventDefault();
    if(confirm('Are you sure you want to restore this Near Miss?')){ 
        jQuery('body').removeClass('loaded');  
        jQuery.ajax({
            url: jQuery(this).attr('href'),
            type : 'POST',
            cache: false,
            contentType: false,
            processData: false,   
            data: 1,
            success: function(response){
                jQuery('.gcobseritem'+response).remove();
                jQuery('body').addClass('loaded');              
            }
        });
    }
});


jQuery(document).on('click','.removeimgobserve',function(){
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


jQuery(document).on('click','.removeimgobserveora',function(){
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
                jQuery('.pipora'+response).remove();
                jQuery('body').addClass('loaded');              
            }
        });
    }
});


jQuery(document).on('click change','.observationlist',function(e){
    var eventname=e.type;
    var inputname=jQuery(this).attr('name');
    if(eventname=='click' && inputname=='filterdate'){return false;}
    if(eventname=='change' && inputname=='filterdate'){jQuery('input[name="ifchaneddate"]').val(1);}
    jQuery('.observationscreate').trigger('click');
    var status=jQuery('.nav-link.active').data('value');
    var riskpotentiallevel = jQuery("input[name='riskpotentiallevel']:checked").val();
    jQuery('.gc-observsntitle-rightlbl label').removeClass('active');
    jQuery('.riskpotentiallevelinput'+riskpotentiallevel).addClass('active');
    jQuery('body').removeClass('loaded');  
    var url      = window.location.href;
    var ifchaneddate = jQuery("input[name='ifchaneddate']").val();
    var filterdate='';
    if(ifchaneddate==1){
        filterdate = jQuery("input[name='filterdate']").val();    
    }    
    var filtercat = jQuery("select[name='filtercat']").val();
    var filtersite = jQuery("select[name='filtersite']").val();    
    jQuery.get(
        url, {status:status,riskpotentiallevel:riskpotentiallevel,filterdate:filterdate,filtercat:filtercat,filtersite:filtersite}, 
        function (data) {
            jQuery('.gc-observation-userdtl').html(data);            
            jQuery('body').addClass('loaded');                    
        }
    );
    jQuery('.gcspfilterreset').slideDown();  
    return false;  
});

jQuery(document).on('click','.gcspfilterreset',function(e){
    jQuery('.gcspfilterreset').slideUp();
    jQuery('input[name="ifchaneddate"]').val('');  
    jQuery('.gc-observsntitle-rightlbl label').removeClass('active');
    jQuery("#riskpotentiallevel0").prop("checked", true);
    jQuery(".oc_id").prop('selectedIndex',0);
    jQuery(".site_id").prop('selectedIndex',0);
    jQuery(".oc_id").select2ToTree(); 
    jQuery(".site_id").select2ToTree();
    jQuery("input[name='filterdate']").val('');
    var status=jQuery('.nav-link.active').data('value');
    var url      = window.location.href;
    jQuery.get(
        url, {status:status,riskpotentiallevel:'',filterdate:'',filtercat:'',filtersite:''}, 
        function (data) {
            jQuery('.gc-observation-userdtl').html(data);            
            jQuery('body').addClass('loaded');                    
        }
    );
});


jQuery(document).on('click','.gcspobservationdetails',function(){
    event.preventDefault(); 
    var detailsurl=jQuery(this).data('href');    
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: detailsurl,
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: 1,
        success: function(response){
            jQuery('.innnerrightpanel .rightpanelinnerbox').html(response);            
            jQuery('body').addClass('loaded'); 
            srno=0;             
        }
    });
});


jQuery(document).on('submit','#observationsstoreaction',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#observationsstoreaction")[0]); 
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            jQuery('.gcobseritem'+response+' .gcspobservationdetails').trigger('click');             
        }
    });
});


jQuery(document).on('click','.actionsedit',function(){
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

jQuery(document).on('submit','#actionsupdate',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#actionsupdate")[0]); 
    var am_id=jQuery("#actionsupdate input[name='am_id']").val();    
    var am_parent_id=jQuery("#actionsupdate input[name='am_parent_id']").val();    
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            jQuery('.gcobseritem'+am_parent_id+' .observationedit').trigger('click');       
        }
    });
    return false;
});


jQuery(document).on('click','.actioncloseclick',function(){
    event.preventDefault();
    var ob_id=jQuery(this).data('parentid');
    jQuery('.gcobseritem'+ob_id+' .observationedit').trigger('click'); 
});

jQuery(document).on('click','.actionsdelete',function(){
    event.preventDefault();
    if(confirm('Are you sure you want to delete this Action?')){ 
        var ob_id=jQuery(this).data('parentid');
        var type=jQuery(this).data('type');
        jQuery('body').removeClass('loaded');  
        jQuery.ajax({
            url: jQuery(this).attr('href'),
            type : 'POST',
            cache: false,
            contentType: false,
            processData: false,   
            data: 1,
            success: function(response){
                if(type=='edit'){
                    jQuery('.gcobseritem'+ob_id+' .observationedit').trigger('click');    
                }else{
                    jQuery('.gcobseritem'+ob_id+' .gcspobservationdetails').trigger('click');     
                }
                jQuery('body').addClass('loaded');              
            }
        });
    }
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

jQuery(document).on('change','.gcspchangeobsevationstatus',function(){
    event.preventDefault(); 
    var status= jQuery(this).val();
    if(status==1){
        jQuery('.ob_closing_comments').slideUp();
        jQuery('.ob_closing_comments textarea').attr('required',false);
    }else{
        jQuery('.ob_closing_comments').slideDown();
        jQuery('.ob_closing_comments textarea').attr('required',true);
    }
});    

jQuery(document).on('change','.gcspobservationsitelist',function(){
    event.preventDefault(); 
    var val= jQuery(this).val();    
    if($(this).prop("checked") == false){
        jQuery('.gcspobservationsite').slideUp();
        jQuery('.gcspobservationsite input[name="ob_describethelocation"]').attr('required',false);
    }else{
        jQuery('.gcspobservationsite').slideDown();
        jQuery('.gcspobservationsite input[name="ob_describethelocation"]').attr('required',true);
    }
});    


jQuery(document).on('change','#ob_more_information_required',function(){
    event.preventDefault();     
    if($(this).prop("checked") == false){
        jQuery('.ob_information_required').slideUp();
        jQuery('.ob_information_required textarea').attr('required',false);
    }else{
        jQuery('.ob_information_required').slideDown();
        jQuery('.ob_information_required textarea').attr('required',true);
    }
});

jQuery(document).on('click','.deleteaction i',function(){
    event.preventDefault();     
    var srno = jQuery(this).data('srno');
    if(confirm('Are you sure to delete this action')){
        jQuery('.rowobjacrionwp'+srno).remove();
    }

});

jQuery(document).on('click','.gcobjsearch,.searchaudittopclose',function(){
    jQuery('.searchaudittop').slideToggle()
});


jQuery(document).on('change','input[name="listing_type"]',function(){
    var listing_type=jQuery(this).val();
    if(listing_type==1){
        jQuery('.gcspuniversalnm').slideUp();
        jQuery('.gcspuniversalnm input').attr('required',false);
    }else{
        jQuery('.gcspuniversalnm').slideDown();
        jQuery('.gcspuniversalnm input').attr('required',true);
    }
});