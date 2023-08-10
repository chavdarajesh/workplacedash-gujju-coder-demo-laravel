jQuery(document).on('click change','.actionslist',function(e){
    var eventname=e.type;
    var inputname=jQuery(this).attr('name');
    if(eventname=='click' && inputname=='filterdate'){return false;}
    if(eventname=='change' && inputname=='filterdate'){jQuery('input[name="ifchaneddate"]').val(1);}    
    var status=jQuery('.nav-link.active').data('value');
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
        url, {status:status,filterdate:filterdate,filtercat:filtercat,filtersite:filtersite}, 
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
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){
            jQuery('.gcactionitem'+am_id).html(response);
            jQuery('.innnerrightpanel .rightpanelinnerbox').html('');
            jQuery('body').addClass('loaded');      
        }
    });
    return false;
});

jQuery(document).on('click','.actionsdelete',function(){
    event.preventDefault();
    if(confirm('Are you sure you want to delete this Action?')){ 
        jQuery('body').removeClass('loaded');  
        jQuery.ajax({
            url: jQuery(this).attr('href'),
            type : 'POST',
            cache: false,
            contentType: false,
            processData: false,   
            data: 1,
            success: function(response){
                jQuery('.gcactionitem'+response).remove();
                jQuery('body').addClass('loaded');              
            }
        });
    }
});

jQuery(document).on('click','.actioncloseclick',function(){
    event.preventDefault();
    jQuery('body').removeClass('loaded');
    jQuery('.innnerrightpanel .rightpanelinnerbox').html('');
    jQuery('body').addClass('loaded');
});

jQuery(document).on('click','.gcspactiondetails',function(){
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


jQuery(document).on('submit','#detailsupdate',function(){
    event.preventDefault(); 
    var data = new FormData(jQuery("#detailsupdate")[0]); 
    var am_id=jQuery("#detailsupdate input[name='am_id']").val();    
    jQuery('body').removeClass('loaded');  
    jQuery.ajax({
        url: jQuery(this).attr('action'),
        type : 'POST',
        cache: false,
        contentType: false,
        processData: false,   
        data: data,
        success: function(response){            
            jQuery('.actionslist.active').trigger('click');
        }
    });
    return false;
});