jQuery(document).on('click change', '.vaccinationslist', function (e) {
    var eventname = e.type;
    var inputname = jQuery(this).attr('name');
    if (eventname == 'click' && inputname == 'filterdate') { return false; }
    if (eventname == 'change' && inputname == 'filterdate') {
        jQuery('input[name="ifchaneddate"]').val(1);
    }

    jQuery('body').removeClass('loaded');
    var url = window.location.href;
    var ifchaneddate = jQuery("input[name='ifchaneddate']").val();
    var filterdate = '';
    if (ifchaneddate == 1) {
        filterdate = jQuery("input[name='filterdate']").val();
    }
    var filtervaccinetype = jQuery("select[name='filtervaccinetype']").val();
    jQuery.get(
        url, { filterdate: filterdate, filtervaccinetype: filtervaccinetype },
        function (data) {
            jQuery('.gc-vaccinations-userdtl').html(data);
            jQuery('body').addClass('loaded');
        }
    );
    jQuery('.gcspfilterreset').slideDown();
    return false;
});

jQuery(document).on('change', "select[name='vaccine_type']", function (e) {
    const vaccine_type_val = jQuery(this).val()
    if (vaccine_type_val == 'Other') {
        jQuery(this).parent().append('<input type="text" placeholder="Vaccine Manufacturer" required name="other_vaccine_type" class="form-control classother_vaccine_type">')
    } else {
        jQuery('.classother_vaccine_type').remove();
    }
});
jQuery(document).on('change', "select[name='second_vaccine_type']", function (e) {
    const vaccine_type_val = jQuery(this).val()
    if (vaccine_type_val == 'Other') {
        jQuery(this).parent().append('<input type="text" placeholder="Vaccine Manufacturer" required name="second_other_vaccine_type" class="form-control classother_vaccine_type">')
    } else {
        jQuery('.classother_vaccine_type').remove();
    }
});

jQuery(document).on('click', '.gcspfilterreset', function (e) {
    jQuery('.gcspfilterreset').slideUp();
    jQuery('input[name="ifchaneddate"]').val('');
    jQuery("select[name='filtervaccinetype']").prop('selectedIndex', 0);
    jQuery("select[name='filtervaccinetype']").select2ToTree();
    jQuery("input[name='filterdate']").val('');
    var url = window.location.href;
    jQuery.get(
        url, { filterdate: '', filtervaccinetype: '' },
        function (data) {
            jQuery('.gc-vaccinations-userdtl').html(data);
            jQuery('body').addClass('loaded');
        }
    );
});

jQuery(document).on('click', '.vaccinationedit', function () {
    event.preventDefault();
    var editurl = jQuery(this).attr('href');
    jQuery('body').removeClass('loaded');
    jQuery.ajax({
        url: editurl,
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        data: 1,
        success: function (response) {
            jQuery('.innnerrightpanel .rightpanelinnerbox').html(response);
            jQuery("select[name='vaccine_type']").select2ToTree();
            jQuery("select[name='second_vaccine_type']").select2ToTree();
            jQuery('body').addClass('loaded');
        }
    });
});

jQuery(document).on('click', '.vaccinationdelete', function () {
    event.preventDefault();
    if (confirm('Are you sure you want to delete this Observation?')) {
        jQuery('body').removeClass('loaded');
        jQuery.ajax({
            url: jQuery(this).attr('href'),
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: 1,
            success: function (response) {
                jQuery('.gcobseritem' + response).remove();
                jQuery('body').addClass('loaded');
            }
        });
    }
});
jQuery(document).on('click', '.addsecondvaccinations', function (e) {
    jQuery(this).hide();
    jQuery('.secondvaccinations').slideDown();
});
jQuery(document).on('click', '.closesecondvaccinations', function (e) {
    jQuery('.secondvaccinations').slideUp();
    jQuery('.addsecondvaccinations').show();
});
jQuery(document).on('change', '.vc-file-upload', function (e) {
    var files = e.target.files,
        filesLength = files.length;
    for (var i = 0; i < filesLength; i++) {
        var f = files[i];
        fileName = f.name;
        var fileReader = new FileReader();
        fileReader.onload = (function (e) {
            var file = e.target;
            var filesrc = e.target.result;

            var fileNameExt = detectMimeType(filesrc);

            if (fileNameExt == 'xlsx' || fileNameExt == 'xls') { filesrc = site_url + '/images/excel.png'; }
            else if (fileNameExt == 'doc' || fileNameExt == 'docx') { filesrc = site_url + '/images/doc.png'; }
            else if (fileNameExt == 'ppt' || fileNameExt == 'pptx') { filesrc = site_url + '/images/ppt.png'; }
            else if (fileNameExt == 'pdf') { filesrc = site_url + '/images/pdf.png'; }
            else { filesrc = e.target.result; }

            jQuery("<span data-fileid=\"" + k + "\"  " + j + " class=\"pip\">" +
                "<img class=\"imageThumb\" src=\"" + filesrc + "\" title=\"" + fileName + "\"/>" +
                "<br/><span class=\"removeimg\"><i class=\"fa fa-times-circle\"></i></span>" +
                "</span>").insertAfter("#vcfileinstedtimg");

            jQuery(".removeimg").click(function () {
                var inputfileremove = jQuery(this).parent(".pip").data('fileid');
                jQuery(this).parent(".pip").remove();
                jQuery('#file-upload' + inputfileremove).remove();
            });
            k++;

        });
        fileReader.readAsDataURL(f);
        j++;
    }
    jQuery(this).parent(".gcspuploadedwpr").hide();
    number = 1 + Math.floor(Math.random() * 60000);
    jQuery('<div class="gcspuploadedwpr"> <label for="vc-file-upload' + number + '" class="custom-file-upload d-block"> <img src="' + site_url + '/images/attached-file.png" alt=""> </label> <input id="vc-file-upload' + number + '" class="vc-file-upload" name="attachedmain[]" type="file"  accept="image/*"> </div>').insertAfter("#newfiletypeadded");
});
jQuery(document).on('change', '.second-vc-file-upload', function (e) {
    var files = e.target.files,
        filesLength = files.length;
    for (var i = 0; i < filesLength; i++) {
        var f = files[i];
        fileName = f.name;
        var fileReader = new FileReader();
        fileReader.onload = (function (e) {
            var file = e.target;
            var filesrc = e.target.result;

            var fileNameExt = detectMimeType(filesrc);

            if (fileNameExt == 'xlsx' || fileNameExt == 'xls') { filesrc = site_url + '/images/excel.png'; }
            else if (fileNameExt == 'doc' || fileNameExt == 'docx') { filesrc = site_url + '/images/doc.png'; }
            else if (fileNameExt == 'ppt' || fileNameExt == 'pptx') { filesrc = site_url + '/images/ppt.png'; }
            else if (fileNameExt == 'pdf') { filesrc = site_url + '/images/pdf.png'; }
            else { filesrc = e.target.result; }

            jQuery("<span data-fileid=\"" + k + "\"  " + j + " class=\"pip\">" +
                "<img class=\"imageThumb\" src=\"" + filesrc + "\" title=\"" + fileName + "\"/>" +
                "<br/><span class=\"removeimg\"><i class=\"fa fa-times-circle\"></i></span>" +
                "</span>").insertAfter("#secondvcfileinstedtimg");

            jQuery(".removeimg").click(function () {
                var inputfileremove = jQuery(this).parent(".pip").data('fileid');
                jQuery(this).parent(".pip").remove();
                jQuery('#file-upload' + inputfileremove).remove();
            });
            k++;

        });
        fileReader.readAsDataURL(f);
        j++;
    }
    jQuery(this).parent(".gcspuploadedwpr").hide();
    number = 1 + Math.floor(Math.random() * 60000);
    jQuery('<div class="gcspuploadedwpr"> <label for="vc-file-upload' + number + '" class="custom-file-upload d-block"> <img src="' + site_url + '/images/attached-file.png" alt=""> </label> <input id="vc-file-upload' + number + '" class="vc-file-upload" name="attachedmain[]" type="file"  accept="image/*"> </div>').insertAfter("#newfiletypeadded");
});
