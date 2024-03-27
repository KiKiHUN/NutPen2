<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/css/bootstrap.min.css">
 
  <script src="/js/jquery-3.3.1.min.js"></script>
  <script src="/js/jquery-calendar.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/jquery.touchSwipe.min.js"></script>
  <script src="/js/moment.withlocales.js"></script>

  <link rel="stylesheet" href="/css/jquery-calendar.min.css">
  <link rel="stylesheet" href="/css/fontawesome.min.css">
  <link rel="stylesheet" href="/css/solid.min.css">
 
  <title>Calendar</title>
</head>
<body>
  <script>
    $(document).ready(function(){
      moment.locale('hu');
      var now = moment();
    console.log(now.startOf('week').add(9, 'h').format('X'));
      /**
       * Many events
       */
       var events = [

       @foreach ( $eventsData as $oneevent)
       {
           start: "{{ $oneevent->start }}",
           end: "{{ $oneevent->end }}",
           title: "{{ $oneevent->title }}",
           content: "{{ $oneevent->content }}",
           category:"{{ $oneevent->category }}"
       },
      @endforeach
      
      ];

      /**
       * A daynote
       */
      var daynotes = [
       /* {
          time: now.startOf('week').add(60, 'h').add(30, 'm').format('X'),
          title: 'Leo\'s holiday',
          content: 'yo',
          category: 'holiday'
        }*/
      ];

      /**
       * Init the calendar
       */
      var calendar = $('#calendar').Calendar({
        locale: 'hu',
        defaultView: {
              largeScreen:'week',
              smallScreen:'week',
              smallScreenThreshold: 1000
            },
          
        weekday: {
          timeline: {
            intervalMinutes: 60,
            fromHour: 5,
            format:'HH:mm'
            
          },
          dayline: {
                  weekdays: [0, 1, 2, 3, 4, 5, 6],
                  format:'dddd MM/DD',
                  heightPx: 31,
                  month: {
                    format:'YYYY MMMM',
                    heightPx: 30,
                    weekFormat:'w'
                  }
                }
            
        },
        month: 
        {
            format:'YYYY MMMM',
            heightPx: 31,
            weekline: {
                format:'w',
                heightPx: 80
            },
            dayheader: {
                weekdays: [0, 1, 2, 3, 4, 5, 6],
                format:'dddd',
                heightPx: 30
            },
            day: {
                format:'MM/DD'
            }
        },
        
          

            
        events: events,
        daynotes: daynotes
      }).init();

      /**
       * Listening for events
       */

      $('#calendar').on('Calendar.init', function(event, instance, before, current, after){
        console.log('event : Calendar.init');
        console.log(instance);
        console.log(before);
        console.log(current);
        console.log(after);
      });
      $('#calendar').on('Calendar.daynote-mouseenter', function(event, instance, elem){
        console.log('event : Calendar.daynote-mouseenter');
        console.log(instance);
        console.log(elem);
      });
      $('#calendar').on('Calendar.daynote-mouseleave', function(event, instance, elem){
        console.log('event : Calendar.daynote-mouseleave');
        console.log(instance);
        console.log(elem);
      });
      $('#calendar').on('Calendar.event-mouseenter', function(event, instance, elem){
        console.log('event : Calendar.event-mouseenter');
        console.log(instance);
        console.log(elem);
      });
      $('#calendar').on('Calendar.event-mouseleave', function(event, instance, elem){
        console.log('event : Calendar.event-mouseleave');
        console.log(instance);
        console.log(elem);
      });
      $('#calendar').on('Calendar.daynote-click', function(event, instance, elem, evt){
        console.log('event : Calendar.daynote-click');
        console.log(instance);
        console.log(elem);
        console.log(evt);
      });
      $('#calendar').on('Calendar.event-click', function(event, instance, elem, evt){
        console.log('event : Calendar.event-click');
        console.log(instance);
        console.log(elem);
        console.log(evt);
      });
    });
  </script>


    <div class="container-fluid px-4">
            <div class="row">
                <div class="col-xs-12">
                    <h1>Naptár</h1>
                    <div id="calendar"></div>
                </div>
            </div>
    </div>


</body>
</html>
