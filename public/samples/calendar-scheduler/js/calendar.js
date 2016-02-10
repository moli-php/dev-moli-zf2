/*init vars*/
var aDay = ['sun','mon','tue','wed','thu','fri','sat'];
var aMonth = ['January','February','March','April','May','June','July','August','September','October','November','December'];
var $li = "";
var d = new Date();
var iDay = d.getDate(), iMonth = d.getMonth()+1, iYear = d.getFullYear(), iNum_of_days = new Date(iYear,iMonth,0).getDate();
var c = new Date();
c.setDate(1);
var	iGetday = c.getDay();
var day_start = iGetday;
var oTitle = $('#title'), oMessage = $('#message');
var oImg = '<tr><td colspan="4"><img src="./img/loader_small.gif" /></td></tr>';

$(document).ready(function(){

    /*display calendar day title on the top*/
    for(i=0;i<=6;i++){
        var sClass = (i!= 0 && i!=6) ? "week_days" : "week_ends";
        $li += "<li class='"+sClass+"'>"+aDay[i]+"</li>";
    }
    $('#holder').append("<div class='heading_title'><ul class='class_ul'>"+$li+"</ul></div>");

    /*display calendar*/
    oCalendar.viewCalendar(iDay,iMonth,iYear,iNum_of_days,day_start);
	
    /* navigation left and right button of calendar */
    $('.date_navi').click(function(){
        var hidden_month = parseInt($('#hidden_month').val());
        var hidden_year = parseInt($('#hidden_year').val());
        oCalendar.navi($(this).attr('id'),d,hidden_month,hidden_year);
    });
	
    /* init */
    $(".time_field").timepicker();
    $(".time_field").val("");

    // add event 
    $('#btn_add').click(function() {
	
        var event = $('#event').val();
        var from = $('#from').val();
        var to = $('#to').val();
        var location = $('#location').val();
        var date = $('#hidden_selected_date').val();
		
        $.ajax({
            url : oCalendar.base_url() +'add-calendar',
            type : 'post',
            data : {
                event:event,
                from_time:from,
                to_time:to,
                location:location,
                date:date
            },
            success : function(data){
                if(data.response == 200){
                    // update new total event
                    oCalendar.updateTotalEvent('plus',date);
                    // update event list
                    oCalendar.clickDay(false,date);
                    $('#btn_add').attr('disabled',true);
                }
            }
        });
		
    });
	
	
    $(document).on('click', '#calendar_table tbody tr', function() {
        var obj = $(this);

        // check if now record
        if(obj.find('td').length === 1) return false;

        var id = obj.attr('id');
        var event = obj.find('td:eq(1)').text();
        var aTime = obj.find('td:eq(2)').text();
        aTime = aTime.split('~');
        var from = $.trim(aTime[0]);
        var to = $.trim(aTime[1]);
        var location = obj.find('td:eq(3)').text();
		
        //hide add btn and show update and delete btn
        $('#btn_add').hide();
        $('#btn_update').attr('disabled',false);
        $('#btn_update').show();
        $('#btn_delete').show();
        $('#btn_cancel').show();
		
        //inject vars on the input fields
        $('#event').val(event);
        $('#from').val(from);
        $('#to').val(to);
        $('#location').val(location);
        $('#hidden_id').val(id);
    });
	
    // update event
    $('#btn_update').click(function() {
        var event = $('#event').val();
        var from = $('#from').val();
        var to = $('#to').val();
        var location = $('#location').val();
        var id = $('#hidden_id').val();
		
        $.ajax({
            url : oCalendar.base_url() + 'update-calendar/'+id,
            type : 'put',
            data : {event:event, from_time:from, to_time:to, location:location},
        success : function(data){
            if(data.response == 200 || data.response == 100){ 
                // update event list
                oCalendar.clickDay(false,$('#hidden_selected_date').val());
                // hide update and delete btn, show add btn
                oCalendar.resetButtons();
            }
        }
		
        });
    });
	
// delete event
$('#btn_delete').click(function() {
	
    $.ajax({
        url : oCalendar.base_url() + 'delete-calendar',
        type : 'delete',
        data : { id : $('#hidden_id').val() },
        success : function(data){
            if(data.response == 200){
                // update new total event
                oCalendar.updateTotalEvent('minus',$('#hidden_selected_date').val());
                // update event list
                oCalendar.clickDay(false,$('#hidden_selected_date').val());
                // hide update and delete btn, show add btn
                oCalendar.resetButtons();
            }
        }
    });
}); 

$('#btn_cancel').click(function(){

    oCalendar.resetButtons();
    $('#event, #from, #to, #location').val('');

});

oCalendar.checkDataField();
    });


var oCalendar = {

    base_url : function() {
        return  $('#base_url').val();
    },
	
    getRecord : function(iCmonth,iCyear)
    {
        $.ajax({
            url : oCalendar.base_url()+'get-calendar',
            type : 'get',
            dataType : 'json',
            data : {
                month:iCmonth,
                year:iCyear
            },
            success : function(data){
                $.each(data,function(k,v){
                    var iDate = v.date.split("-");
                    var iDay = parseInt(iDate[2]-1);
                    var d = ($.trim($('#holder').find('.days').eq(iDay).find('span:last').text()) == "") ? 0 : $('#holder').find('.days').eq(iDay).find('span:last').text();
				
                    if(iDate[1] == iCmonth && iDate[0] == iCyear){
                        d = parseInt(d) + 1;
                        $('#holder').find('.days').eq(iDay).find('span:last').text(d);
                    }
                });
				
            }
        });
    },
	
    updateTotalEvent : function(flag,date) {
        var aDate = date.split('-');
        var iDay = parseInt(aDate[2]);
        var current_total = $.trim($('.days').eq(iDay-1).find('.numDate2').text());
        current_total = current_total == "" ? 0 : parseInt(current_total);
			
        if(flag == 'plus'){
            $('.days').eq(iDay-1).find('.numDate2').text(current_total+1);
        }else{
            if(current_total == 1){
                $('.days').eq(iDay-1).find('.numDate2').html("&nbsp;");
            }else{
                $('.days').eq(iDay-1).find('.numDate2').text(current_total-1);
            }	
        }
    },
		
    checkDataField : function() {
	
        $('#event, #location').keyup(function(){
		
            var event = $.trim($('#event').val());
            var location = $.trim($('#location').val());
            var from = $.trim($('#from').val());
            var to = $.trim($('#to').val());
			
            if(event.length > 0 && location.length > 0 && from.length > 0 && to.length > 0){
                $('#btn_add, #btn_update').attr('disabled',false);
            }else{
                $('#btn_add, #btn_update').attr('disabled',true);
            }
        });
		
        $('#from, #to').click(function(){
            var event = $.trim($('#event').val());
            var location = $.trim($('#location').val());
            var from = $.trim($('#from').val());
            var to = $.trim($('#to').val());
			
            if(event.length > 0 && location.length > 0 && from.length > 0 && to.length > 0){
                $('#btn_add, #btn_update').attr('disabled',false);
            }else{
                $('#btn_add, #btn_update').attr('disabled',true);
            }	
        });	
    },

    clickDay : function(flag,sSearch)
    {
        $.ajax({
            url : oCalendar.base_url()+'get-by-date-calendar',
            type : 'get',
            dataType : 'json',
            data : {
                search:sSearch
            },
            success : function(data){
                var str = "";
				
                if(data.length == 0){
                    $('#calendar_table tbody').html('<tr><td colspan="4"><center>No event</center></td></tr>');
                    return false;
                }
				
                $.each(data,function(k,v){
                    str += '<tr id="'+v.id+'">';
                    str += '<td>'+(k+1)+'</td>';
                    str += '<td>'+v.event+'</td>';
                    str += '<td>'+v.from_time+' ~ '+v.to_time+'</td>';
                    str += '<td>'+v.location+'</td>';
                    str += '</tr>';
                });
				
                $('#calendar_table tbody').html(str);
				
            }
		
        }).done(function(){
		
            // reset fields
            $('#event, #from, #to, #location').val('');
            // insert date selected
            $('#hidden_selected_date').val(sSearch);
			
            if(flag == true){
                oCalendar.resetButtons();
                $('#calendarModal').modal('show');
            }
			
        });

    },

    navi : function(oId,d,iMonth,iYear)
    {

        if(oId === "left_navi"){
            iMonth--;
            if(iMonth == 0){
                iYear--;
                iMonth = 12;
            }
        }else if(oId === "right_navi"){
            iMonth++;
            if(iMonth == 13){
                iYear++;
                iMonth = 1;
            }
        }
		
        var c = new Date(), cDay = c.getDate(), cMonth = c.getMonth()+1, cYear = c.getFullYear();
		
        d.setDate(1);
        d.setMonth(iMonth-1);
        d.setYear(iYear);
		
		
        if(cMonth == iMonth && cYear == iYear){
            var iNum_of_days = new Date(cYear,cMonth,0).getDate();
            var day_start = d.getDay();
            var iDay = cDay;
        }else{
            var iNum_of_days = new Date(iYear,iMonth,0).getDate();
            var day_start = d.getDay();
            var iDay = "";
        }
        oCalendar.viewCalendar(iDay,iMonth,iYear,iNum_of_days,day_start);
    },
	
    viewCalendar : function(iDay,iMonth,iYear,iNum_of_days,day_start)
    {
        /*init */
        if(iMonth == 0)
            iMonth = 12;
        else if(iMonth >= 13)
            iMonth = 1;
		
        $('#hidden_month').val(iMonth);
        $('#hidden_year').val(iYear);
        $('.class_ul2').remove();
        var Boxes = "";
		
        $('#month_title').html(aMonth[iMonth-1]+" "+iYear);
		
        /* set number of box */
        Boxes = 34; // default number of boxes
        if(iMonth != 2){
            if(day_start === 5) {
                Boxes = iNum_of_days == 31 ? 41 : 34;
            }else if(day_start === 6) {
                Boxes = iNum_of_days >= 30 ? 41 : 34;
            }
        }else{
            Boxes = (day_start === 0 && iNum_of_days === 28) ? 27 : 34;
        }

        /* fill in the box with number days*/
        var j="", k="", $li ="", box_class = "days";
        for(i=0;i<=Boxes;i++){
            k = (day_start <= i) ? ((j++ >= iNum_of_days) ? "&nbsp;" : j ) : "&nbsp;";
            box_class = (day_start <= i) ? ((j > iNum_of_days) ? "box" : "days" ) : "box";
            $li +=  "<li class='"+box_class+"'><span class='numDate'>"+k+"</span><span class='numDate2'>&nbsp;</span></li>";	
        }
        $('#holder').append("<ul class='class_ul2'>"+$li+"</ul>");

        /*highlight today's date*/
        if(iDay !== "")	$('#holder').find('.days').eq(iDay-1).addClass('today');
		
        oCalendar.getRecord(iMonth,iYear);
		
        /* click day event */
        $('.days').click(function(){
            var sSearch = iYear + '-' + iMonth + '-' + $(this).find('span:first').text();
            oCalendar.clickDay(true,sSearch);
        });
    },

    resetButtons : function() {

        $('#btn_add').attr('disabled',true).show();
        $('#btn_update,#btn_delete,#btn_cancel').hide();
    }

}