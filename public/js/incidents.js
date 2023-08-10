jQuery(document).on('click change','.incidentslist',function(e){
    var eventname=e.type;
    var inputname=jQuery(this).attr('name');
    if(eventname=='click' && inputname=='filterdate'){return false;}
    if(eventname=='change' && inputname=='filterdate'){jQuery('input[name="ifchaneddate"]').val(1);}
    jQuery('.incidentscreate').trigger('click');
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
    jQuery(".oc_id").prop('selectedIndex',0);
    jQuery(".site_id").prop('selectedIndex',0);
    jQuery(".oc_id").select2ToTree(); 
    jQuery(".site_id").select2ToTree();
    jQuery("input[name='filterdate']").val('');
    var status=jQuery('.nav-link.active').data('value');
    var url      = window.location.href;
    jQuery.get(
        url, {status:status,filterdate:'',filtercat:'',filtersite:''}, 
        function (data) {
            jQuery('.gc-observation-userdtl').html(data);            
            jQuery('body').addClass('loaded');                    
        }
    );
});


jQuery(document).on('submit','#incidentsstore',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#incidentsstore")[0]); 
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            jQuery('#gc-incidentopen .gc-observation-userdtl .row').append(response);
            jQuery('#incidentsstore')[0].reset();
            jQuery('.gcsphideactionsmain').hide();            
            jQuery('.rowobjacrionwp').remove();  
            jQuery('.pip').remove();                          
            jQuery(".oc_id1").select2ToTree(); 
            jQuery(".site_id1").select2ToTree();              
            srno=0;
            jQuery('body').addClass('loaded');  
        }
    });
});

jQuery(document).on('submit','.updaterating',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery(this)[0]); 
    var im_id=jQuery(this).find("input[name='im_id']").val();
    jQuery('body').removeClass('loaded');  
    jQuery('.close').trigger('click');
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){ 
            jQuery('.close').trigger('click');
            jQuery('.gcobseritem'+im_id).html(response);
            jQuery('body').addClass('loaded');  
        }
    });
});

jQuery(document).on('click','.incidentscreate',function(){
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
            jQuery(".oc_id1").select2ToTree(); 
            jQuery(".site_id1").select2ToTree();
            jQuery('body').addClass('loaded');              
        }
    });
});

jQuery(document).on('click','.incidentsedit',function(){
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
            jQuery(".oc_id1").select2ToTree(); 
            jQuery(".site_id1").select2ToTree();
            jQuery('body').addClass('loaded');              
        }
    });
});

jQuery(document).on('submit','#incidentsupdate',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#incidentsupdate")[0]); 
    var im_id=jQuery("#incidentsupdate input[name='im_id']").val();    
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            jQuery('.gcobseritem'+im_id).html(response);
            jQuery('.incidentscreate').trigger('click');  
            jQuery('body').addClass('loaded');                          
        }
    });
});

jQuery(document).on('click','.incidentsdelete',function(){
    event.preventDefault();
    if(confirm('Are you sure you want to delete this Incidents?')){ 
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

jQuery(document).on('click','.incidentsdeletefile',function(){
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
