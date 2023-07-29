// VERY IMPORTANT
// --------------
// In line 355 - fullcalendar.min.css
// white-space: nowrap;
// was commented to wrap text inside calendar cell


$(document).ready(function() {
  $("#calendar_type").focus();
});

$('#calendar_type').on("change focus", function(){
// $("#calendar_type").change(function(){
  var calendar_type = $("#calendar_type").val();
  var data = new FormData();                     
    data.append("calendar_type", calendar_type);  
     $.ajax({
      url:"ajax/calendar.ajax.php",   
      method: "POST",                
      data: data,                    
      cache: false,                  
      contentType: false,            
      processData: false,            
      dataType:"json",               
      success:function(answer){
         var calendarContent = [];
         for(var i = 0; i < answer.length; i++) {
             var calendarInfo = answer[i];
             var task_count = calendarInfo.taskLabel + ' (' + formatNumber(calendarInfo.taskCount) + ')'; 
             calendarContent.push({"title": task_count, "start": calendarInfo.tdate});
         }

         $('#calendar').fullCalendar('removeEvents');
         //Getting new event json data
         $("#calendar").fullCalendar('addEventSource', calendarContent);
         //Updating new events
         $('#calendar').fullCalendar('rerenderEvents');
         //getting latest Events
         $('#calendar').fullCalendar( 'refetchEvents' );
         //getting latest Resources
         $('#calendar').fullCalendar( 'refetchResources' );
         
         $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          defaultDate: '2020-11-01',
          navLinks: true,      // can click day/week names to navigate views
          selectable: false,   //disable click on calendar cell
          selectHelper: true,
          select: function(start, end) {
            var title = prompt('Event Title:');
            var eventData;
            if (title) {
              eventData = {
                title: title,
                start: start,
                end: end
              };
              $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
            }
            $('#calendar').fullCalendar('unselect');
          },


          // editable: true,
          // eventLimit: true, // allow "more" link when too many events
          editable: false,
          eventLimit: false, 


          events: calendarContent
         });         
    
      } /*success*/
  })   
});