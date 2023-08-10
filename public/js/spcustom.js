jQuery(document).ready(function() {

  setTimeout(function(){
    jQuery('body').addClass('loaded');
  }, 1500);

});

jQuery(document).on('click','.gcspcategorydelete',function(){
      if(!confirm('Are you sure you want to delete this category')){
        return false;
      }
});

jQuery(document).on('change','.filterobservation',function(){
     jQuery(this).closest("form").submit();
});

jQuery(document).on('change blur ','input,textarea,select',function(){

     jQuery(this).removeClass('is-invalid');
     jQuery(this).closest(".btn-group").removeClass('is-invalid');
     jQuery(this).closest(".form-group").find('.is-invalid').removeClass('is-invalid');
});

jQuery(document).on('click','.card-header',function(){
     if(jQuery(this).hasClass('opensub')){
        jQuery(this).toggleClass('opensub');
     }else{
        jQuery('.card-header').removeClass('opensub');
        jQuery(this).toggleClass('opensub');
     }
});

/*jQuery(document).on('change blur','input[name="companyname"]',function(){
        var string = jQuery(this).val();
        jQuery(this).val(string.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, ''));
});*/

jQuery(document).on('change','.action_required',function(){
    var action_required=jQuery(this).val();
    if(action_required==1){ jQuery('.gcsphideactionsmain').slideDown(500); }else{ jQuery('.gcsphideactionsmain').slideUp(500); jQuery('.rowobjacrionwp').remove(); }
});
var srno=0;
jQuery(document).on('click','.gcspaddaction',function(){
    jQuery.ajax({
    method: "GET",
        url: site_url+'/near-miss/addaction',
        data: { srno: srno }
    })
    .done(function(responce){
        jQuery('.actionhtmlbefore').before(responce);
        setTimeout(function(){
          jQuery(document).find('#multipleSelect'+srno).fastselect();
          jQuery(document).find('#multipleSelect2'+srno).fastselect();
          instance = new dtsel.DTS('.gcspdatetimepicker'+srno,  {
            direction: 'BOTTOM',
            dateFormat: "mm/dd/yyyy",
            showTime: true,
            timeFormat: "hh:mm"
          });
          srno++;
        },500);
        jQuery('.observationsstoreaction').show(responce);
    });
});


jQuery(document).on('click focus','.gcspdatetimepickerclick',function(){
      if(jQuery(this).val()==''){
          var d = new Date($.now());
          var month = d.getMonth()+1;
          var day = d.getDate();
          var hour = d.getHours();
          var minite = d.getMinutes();
          //alert(d.getDate()+"-"+(d.getMonth()+1)+"-"+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds());
          var output = (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day+'/' +d.getFullYear()+', '+(hour<10 ? '0' : '') + hour+':'+(minite<10 ? '0' : '') + minite;
          $(this).val(output);
      }
  });

jQuery(document).on('change click','.im_anyvictim',function(){
    var im_anyvictim=jQuery(this).data('value');
    if(im_anyvictim==1){jQuery('.gcsphidevictimmain').slideDown(500);}else{jQuery('.gcsphidevictimmain').slideUp(500);}
});

jQuery(document).on('click','.iv_taken_hospital',function(){
    var im_anyvictim=jQuery(this).data('value');
    if(im_anyvictim==1){
      jQuery(this).closest('.row').find('.gcsptakentotahehospital').slideDown(1);
    }else{
      jQuery(this).closest('.row').find('.gcsptakentotahehospital').slideUp(1);
    }
});

jQuery(document).on('click','.gcspvictomfrmdelete a',function(){
    var srnodelete=jQuery(this).data('srno');
    jQuery('.gcspvictomfrmmain'+srnodelete).remove();
});

jQuery(document).on('click','.gcspaddvictim',function(){
    jQuery.ajax({
    method: "GET",
        url: site_url+'/incidents/addvictim',
        data: { srno: srno }
    })
    .done(function(responce){
        jQuery('.victomhtmlbefore').before(responce);
        setTimeout(function(){
          jQuery(document).find('#multipleSelect'+srno).fastselect();
          jQuery(document).find('#multipleSelect2'+srno).fastselect();

          jQuery( function() {
            jQuery( "#slider-range"+srno ).slider({
            range: true,
            min: 18,
            max: 70,
            values: [ 18, 25 ],

            slide: function( event, ui ) {
              console.log(ui.values[0]+'-'+ui.values[1]);



              if(ui.values[ 0 ]>=18){
                  $(this).slider( "option", "values", [ 18, 25 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("18 - 25");
              }
              if(ui.values[ 0 ]>=25){
                  $(this).slider( "option", "values", [ 25, 30 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("25 - 30");
              }
              if(ui.values[ 0 ]>=30){
                  $(this).slider( "option", "values", [ 30, 40 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("30 - 40");
              }
              if(ui.values[ 0 ]>=40){
                  $(this).slider( "option", "values", [ 40, 50 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("40 - 50");
              }
              if(ui.values[ 0 ]>=50){
                  $(this).slider( "option", "values", [ 50, 60 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("50 - 60");
              }
              if(ui.values[ 0 ]>=60){
                  $(this).slider( "option", "values", [ 60, 70 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("60 - 70");
              }
              if(ui.values[ 0 ]>=70){
                  $(this).slider( "option", "values", [ 70, 70 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("70+");
              }

              if(ui.values[ 1 ]<25){
                  $(this).slider( "option", "values", [ 18, 25 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("18 - 25");
              }
              if(ui.values[ 1 ]>25 && ui.values[ 1 ]<30){
                  $(this).slider( "option", "values", [ 25, 30 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("25 - 30");
              }
              if(ui.values[ 1 ]>30 && ui.values[ 1 ]<40){
                  $(this).slider( "option", "values", [ 30, 40 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("30 - 40");
              }
              if(ui.values[ 1 ]>40 && ui.values[ 1 ]<50){
                  $(this).slider( "option", "values", [ 40, 50 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("40 - 50");
              }
              if(ui.values[ 1 ]>50 && ui.values[ 1 ]<60){
                  $(this).slider( "option", "values", [ 50, 60 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("50 - 60");
              }
              if(ui.values[ 1 ]>60 && ui.values[ 1 ]<70){
                  $(this).slider( "option", "values", [ 60, 70 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("60 - 70");
              }
              if(ui.values[ 1 ]>70){
                  $(this).slider( "option", "values", [ 70, 70 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("70+");
              }


              /*if(ui.values[ 1 ]>=26){
                  $( this).slider( "option", "values", [ 25, 30 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("25 - 30");
              }
              if(ui.values[ 1 ]>=31){
                  $( this).slider( "option", "values", [ 30, 40 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("30 - 40");
              }
              if(ui.values[ 1 ]>=41){
                  $( this).slider( "option", "values", [ 40, 50 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("40 - 50");
              }
              if(ui.values[ 1]>=51){
                  $( this).slider( "option", "values", [ 50, 60 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("50 - 60");
              }
              if(ui.values[ 1 ]>=61){
                  $( this).slider( "option", "values", [ 60, 70 ] );
                  jQuery(this).closest('.col-md-4').find( ".agerang" ).val("60 - 70");
              }*/





            }
            });
          } );

          srno++;
        },500);

    });
});

jQuery('.gcspparentrc').on('change', function(e) {
  var parentcheckid=jQuery(this).data('paparentid');
  if(jQuery(this).prop("checked")) {
      jQuery('#collapse'+parentcheckid+' input').prop('checked', true);
  }else{
      jQuery('#collapse'+parentcheckid+' input').prop('checked', false);
  }
  var count = jQuery('#collapse'+parentcheckid).find('input:checked').length;
  jQuery('#heading'+parentcheckid+' span').html(' ('+count+')');
});


jQuery('.gcspchildrc').on('change', function(e) {
  var parentcheckid=jQuery(this).data('paparentid');
  var count = jQuery('#collapse'+parentcheckid).find('input:checked').length;
  jQuery('#heading'+parentcheckid+' span').html(' ('+count+')');
  if(count!=0){
    jQuery('.gcspparentrc'+parentcheckid).prop('checked', true);
  }else{
    jQuery('.gcspparentrc'+parentcheckid).prop('checked', false);
  }
});

if(jQuery( ".gcspparentrc" ).length){
  jQuery( ".gcspparentrc" ).each(function( index ) {
      var parentcheckid=jQuery(this).data('paparentid');
      var count = jQuery('#collapse'+parentcheckid).find('input:checked').length;
      jQuery('#heading'+parentcheckid+' span').html(' ('+count+')');
  });
}


jQuery(document).on('click','.gcspincidentaddaction',function(){
    jQuery.ajax({
    method: "GET",
        url: site_url+'/incidents/addaction',
        data: { insrno: insrno }
    })
    .done(function(responce){
        jQuery('.actionhtmlbefore').before(responce);
        setTimeout(function(){
          jQuery(document).find('#multipleSelect'+insrno).fastselect();
          jQuery(document).find('#multipleSelect2'+insrno).fastselect();
          insrno++;
          jQuery('.opacityzero').removeClass('opacityzero');
        },500);

    });
});


jQuery('.gcsppermissionwapper th input').on('change', function(e) {
  var checkedvalue=jQuery(this).val();
  if(jQuery(this).prop("checked")) {
      jQuery(this).closest('tr').find('input').prop('checked', true);
        jQuery('.gcsppermitcheck'+checkedvalue).prop('checked', true);
  }else{
      jQuery(this).closest('tr').find('input').prop('checked', false);
      jQuery('.gcsppermitcheck'+checkedvalue).prop('checked', false);
  }
});

jQuery('.gcsppermissionwapper td input').on('change', function(e) {
  var parent=jQuery(this).data('parent');
  if(jQuery(this).prop("checked")) {
      jQuery(this).closest('tr').find('th input').prop('checked', true);
      //if(jQuery(this).hasClass('gcsppermitcheck')){
        jQuery('th .gcspparent'+parent).prop('checked', true);
   //   }
  }
});


jQuery(document).on('click','.gcspactivefrmdelete a',function(){
    var srnodelete=jQuery(this).data('srno');
    jQuery('.gcspactionrowfrmmain'+srnodelete).remove();
});


jQuery(document).on('click','.actionsfieldsrequred',function(){
   jQuery(document).find('select.selectControl').each(function() {
      if(jQuery(this).val()==''){ alert("Recommended Actions Type Control must be selected."); return false; }
   });
   jQuery(document).find('select.selectResponsibility').each(function() {
        var selectResponsibility=jQuery(this).val();
        if(selectResponsibility==null){ alert("Recommended Actions Responsibility must be selected."); return false; }
   });
});

var signatures = {
  JVBERi0: "pdf",
  image: "image",
  UEsDBBQABgAIAAAAIQBx: "xlsx",
  UEsDBBQABgAIAAAAIQDd: "doc",
  UEsDBBQABgAIAAAAIQA2: "pptx",

};

function detectMimeType(b64) {
  var b64exp=b64.split('base64,');

  for (var s in signatures) {
    if (b64exp[1].indexOf(s) === 0) {
      return signatures[s];
    }
  }
}
var j=0; var k=0;
jQuery(document).ready(function() {
  var fileNameExt=''; var fileName='';

    //jQuery(".file-upload").on("change", function(e) {
      jQuery(document).on('change','.file-upload',function(e){
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i];
        fileName = f.name;

        jQuery('<input id="file-upload'+j+'" value="'+fileName+'" name="attachedimgname[]" type="hidden" />').insertAfter("#fileinstedt");


        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          var filesrc=e.target.result;

          var fileNameExt=detectMimeType(filesrc);

          if(fileNameExt=='xlsx' || fileNameExt=='xls'){filesrc=site_url+'/images/excel.png';}
          else if(fileNameExt=='doc' || fileNameExt=='docx'){filesrc=site_url+'/images/doc.png';}
          else if(fileNameExt=='ppt' || fileNameExt=='pptx'){filesrc=site_url+'/images/ppt.png';}
          else if(fileNameExt=='pdf'){filesrc=site_url+'/images/pdf.png';}
          else{filesrc=e.target.result;}

          jQuery("<span data-fileid=\""+k+"\"  "+j+" class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + filesrc + "\" title=\"" + fileName + "\"/>" +
            "<br/><span class=\"removeimg\"><i class=\"fa fa-times-circle\"></i></span>" +
            "</span>").insertAfter("#fileinstedtimg");


          jQuery(".removeimg").click(function(){
            var inputfileremove=jQuery(this).parent(".pip").data('fileid');
            jQuery(this).parent(".pip").remove();
            jQuery('#file-upload'+inputfileremove).remove();
          });
          k++;

        });
        fileReader.readAsDataURL(f);
        j++;
      }

      jQuery(this).parent(".gcspuploadedwpr").hide();
      number = 1 + Math.floor(Math.random() * 60000);
      jQuery('<div class="gcspuploadedwpr"> <label for="file-upload'+number+'" class="custom-file-upload d-block"> <img src="'+site_url+'/images/attached-file.png" alt=""> </label> <input id="file-upload'+number+'" class="file-upload" name="attachedmain[]" type="file" multiple="" accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf"> </div>').insertAfter("#newfiletypeadded");
    });



      jQuery(document).on('change','.file-upload-ora',function(e){
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i];
        fileName = f.name;

        jQuery('<input id="file-upload-ora'+j+'" value="'+fileName+'" name="attachedimgname_ora[]" type="hidden" />').insertAfter("#fileinstedtora");


        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          var filesrc=e.target.result;

          var fileNameExt=detectMimeType(filesrc);

          if(fileNameExt=='xlsx' || fileNameExt=='xls'){filesrc=site_url+'/images/excel.png';}
          else if(fileNameExt=='doc' || fileNameExt=='docx'){filesrc=site_url+'/images/doc.png';}
          else if(fileNameExt=='ppt' || fileNameExt=='pptx'){filesrc=site_url+'/images/ppt.png';}
          else if(fileNameExt=='pdf'){filesrc=site_url+'/images/pdf.png';}
          else{filesrc=e.target.result;}

          jQuery("<span data-fileid=\""+k+"\"  "+j+" class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + filesrc + "\" title=\"" + fileName + "\"/>" +
            "<br/><span class=\"removeimg\"><i class=\"fa fa-times-circle\"></i></span>" +
            "</span>").insertAfter("#fileinstedtimgora");


          jQuery(".removeimg").click(function(){
            var inputfileremove=jQuery(this).parent(".pip").data('fileid');
            jQuery(this).parent(".pip").remove();
            jQuery('#file-upload-ora'+inputfileremove).remove();
          });
          k++;

        });
        fileReader.readAsDataURL(f);
        j++;
      }

      jQuery(this).parent(".gcspuploadedwpr").hide();
      number = 1 + Math.floor(Math.random() * 60000);
      jQuery('<div class="gcspuploadedwpr"> <label for="file-upload-ora'+number+'" class="custom-file-upload d-block"> <img src="'+site_url+'/images/attached-file.png" alt=""> </label> <input id="file-upload-ora'+number+'" class="file-upload-ora" name="attachedmain_ora[]" type="file" multiple="" accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf"> </div>').insertAfter("#newfiletypeaddedora");
      });


    jQuery(document).on('change','.file-upload-single',function(e){
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i];
        fileName = f.name;

        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          var filesrc=e.target.result;

          var fileNameExt=detectMimeType(filesrc);

          if(fileNameExt=='xlsx' || fileNameExt=='xls'){filesrc=site_url+'/images/excel.png';}
          else if(fileNameExt=='doc' || fileNameExt=='docx'){filesrc=site_url+'/images/doc.png';}
          else if(fileNameExt=='ppt' || fileNameExt=='pptx'){filesrc=site_url+'/images/ppt.png';}
          else if(fileNameExt=='pdf'){filesrc=site_url+'/images/pdf.png';}
          else{filesrc=e.target.result;}
           jQuery(".pip").remove();
          jQuery("<span data-fileid=\""+k+"\"  "+j+" class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + filesrc + "\" title=\"" + fileName + "\"/>" +
            "<br/><span class=\"removeimgsingle\"><i class=\"fa fa-times-circle\"></i></span>" +
            "</span>").insertAfter("#fileinstedtimg");


          jQuery(".removeimgsingle").click(function(){
            var control = jQuery(".file-upload-single");
            control.val("");
            var inputfileremove=jQuery(this).parent(".pip").data('fileid');
            jQuery(this).parent(".pip").remove();
            jQuery('#file-upload'+inputfileremove).remove();
          });
          k++;

        });
        fileReader.readAsDataURL(f);
        j++;
      }


    });

});

jQuery(document).on('click','.gc-new-list-click',function(){
  jQuery('.gc-new-list-click-show').show();
  jQuery('.gc-userlogin-top-click-show').hide();
});
jQuery(document).on('click','.gc-userlogin-top-click',function(){
  jQuery('.gc-userlogin-top-click-show').show();
  jQuery('.gc-new-list-click-show').hide();
});

jQuery(document).click(function(e) {
    if(e.target.id != 'navbarDropdown') {
        jQuery('.gc-userlogin-top-click-show').hide();
        jQuery('.gc-new-list-click-show').hide();
    }
});
jQuery(document).on('keydown','.gcspinputtype2',function(event){
  var keycode = event.which;
    if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57) || (keycode >= 96 && keycode <= 105)))) {
        event.preventDefault();
    }
});
jQuery(document).on('keydown','.gcspinputtype3',function(event){
        var keyCode = event.which;
        if ((keyCode < 65 || keyCode > 90) && keyCode != 32 && keyCode != 16){
          event.preventDefault();
        }
});
