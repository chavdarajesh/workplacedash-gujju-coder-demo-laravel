jQuery(document).on('change','.dashboardchange',function(e){
    var eventname=e.type;
    var inputname=jQuery(this).attr('name');
    if(eventname=='click' && inputname=='filterdate'){return false;}
    if(eventname=='change' && inputname=='filterdate'){jQuery('input[name="ifchaneddate"]').val(1);}    
    var url      = window.location.href;
    var ifchaneddate = jQuery("input[name='ifchaneddate']").val();
    var filterdate='';
    if(ifchaneddate==1){
        filterdate = jQuery("input[name='filterdate']").val();    
    }    
    var site_id = jQuery("select[name='site_id[]']").val();      
    var moduletype = [1,2,3,4];    
    jQuery.get(
        url, {filterdate:filterdate,site_id:site_id,moduletype:moduletype}, 
        function (data) {
            var response = JSON.parse(data); 
            if($('#ObservationsbyCategories').length){           
            Highcharts.chart('ObservationsbyCategories', {
                chart: {type: 'column'},
                title: {text: ''},
                subtitle: {text: ''},
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title:false
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{y}'
                        }
                    }
                },
                tooltip: false,
                series: [
                    {
                        name: "Observations ",
                        colorByPoint: false,
                        data: response.ObservationbyRatingArrFinal
                    }
                ],    
            }, function(chart) { // on complete
                if(response.ObservationbyRatingArrFinal==''){
                    chart.renderer.text('No Data Available', 35, 85).css({color: '#000000', fontSize: '16px'}) .add();
                }else{
                    chart.renderer.text('', 35, 85).css({color: '#ffffff', fontSize: '16px'}) .add();
                }
                
            });
        }
    if($('#IncidentsbyCategories').length){ 
        Highcharts.chart('IncidentsbyCategories', {
            chart: {type: 'column'},
            title: {text: ''},
            subtitle: {text: ''},
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title:false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{y}'
                    }
                }
            },
            tooltip: false,
            series: [
                {
                    name: "Incident ",
                    colorByPoint: false,
                    data: response.IncidentsbyCategoriesArr
                }
            ],    
        }, function(chart) { // on complete
                if(response.IncidentsbyCategoriesArr==''){
                    chart.renderer.text('No Data Available', 35, 85).css({color: '#000000', fontSize: '16px'}) .add();
                }else{
                    chart.renderer.text('', 35, 85).css({color: '#ffffff', fontSize: '16px'}) .add();
                }
                
            });
        }
        if($('#IncidentsbyRating').length){
        Highcharts.chart('IncidentsbyRating', {
            chart: {type: 'column'},
            title: {text: ''},
            subtitle: {text: ''},
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title:false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{y}'
                    }
                }
            },
            tooltip: false,
            series: [
                {
                    name: "Incident Rating",
                    colorByPoint: false,
                    data: response.IncidentsbyRatingArrFinal
                }
            ],    
        }, function(chart) { // on complete
                if(response.IncidentsbyRatingArrFinal==''){
                    chart.renderer.text('No Data Available', 35, 85).css({color: '#000000', fontSize: '16px'}) .add();
                }else{
                    chart.renderer.text('', 35, 85).css({color: '#ffffff', fontSize: '16px'}) .add();
                }
                
            });

        }
        if($('#ActionsByStatus').length){
        Highcharts.chart('ActionsByStatus', {
            chart: {type: 'column'},
            title: {text: ''},
            subtitle: {text: ''},
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title:false
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{y}'
                    }
                }
            },
            tooltip: false,
            series: [
                {
                    name: "Actions By Status",
                    colorByPoint: false,
                    data: response.ActionsByStatusArrFinal
                }
            ],    
        }, function(chart) { // on complete
                if(response.ActionsByStatusArrFinal==''){
                    chart.renderer.text('No Data Available', 35, 85).css({color: '#000000', fontSize: '16px'}) .add();
                }else{
                    chart.renderer.text('', 35, 85).css({color: '#ffffff', fontSize: '16px'}) .add();
                }
                
            });
        }

        var all_events = response.FinalDayEvent

            jQuery('#calendar1').fullCalendar('removeEvents');
            jQuery('#calendar1').fullCalendar('addEventSource', all_events);         
            jQuery('#calendar1').fullCalendar('rerenderEvents' );
            jQuery('#calendar2').fullCalendar('removeEvents');
            jQuery('#calendar2').fullCalendar('addEventSource', all_events);         
            jQuery('#calendar2').fullCalendar('rerenderEvents' );
            jQuery('#calendar3').fullCalendar('removeEvents');
            jQuery('#calendar3').fullCalendar('addEventSource', all_events);         
            jQuery('#calendar3').fullCalendar('rerenderEvents' );    

        }
    );    
    
});


jQuery(document).on('change','.dashboardmodulechange',function(e){
    var eventname=e.type;
    var inputname=jQuery(this).attr('name');
    if(eventname=='click' && inputname=='filterdate'){return false;}
    if(eventname=='change' && inputname=='filterdate'){jQuery('input[name="ifchaneddate"]').val(1);}    
    var url      = window.location.href;
    var ifchaneddate = jQuery("input[name='ifchaneddate']").val();
    var filterdate='';
    if(ifchaneddate==1){
        filterdate = jQuery("input[name='filterdate']").val();    
    }    
    var site_id = jQuery("select[name='site_id[]']").val();      
    var moduletype = [];
    jQuery("input[name='moduletype[]']:checked").each(function(i){            
      moduletype[i] = $(this).val();
    }); 


    jQuery.get(
        url, {filterdate:filterdate,site_id:site_id,moduletype:moduletype}, 
        function (data) {
        var response = JSON.parse(data);                        
        var all_events = response.FinalDayEvent

            jQuery('#calendar1').fullCalendar('removeEvents');
            jQuery('#calendar1').fullCalendar('addEventSource', all_events);         
            jQuery('#calendar1').fullCalendar('rerenderEvents' );
            jQuery('#calendar2').fullCalendar('removeEvents');
            jQuery('#calendar2').fullCalendar('addEventSource', all_events);         
            jQuery('#calendar2').fullCalendar('rerenderEvents' );
            jQuery('#calendar3').fullCalendar('removeEvents');
            jQuery('#calendar3').fullCalendar('addEventSource', all_events);         
            jQuery('#calendar3').fullCalendar('rerenderEvents' );    

        }
    );    
    
});