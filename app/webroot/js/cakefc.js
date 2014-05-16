/// Cakefc Calendar application similar to a google calendar
/// Creation date: 2014-03-01
!function() {

    "use strict"; // jslint ... ;_;
  
    // INITIAL VARIABLE DEFINITION
    // ----------------------------
    
    // minicalendar title
    var mTitleDefault = 'mini calendar';
    
    // loader dom
    var loading = $('#loading');
    
    // loading.gif's name
    var loadingGif = 'img/loading.gif';
    
    // baseURL
    // ドメイン名を抜いたパス。
    var baseURL = '/';
    
    // mfc
    // 小さいほうの fullCalendar を表現する DOM ID
    var mfc = $('#mfc');
    
    // hfc
    // 大きいほうの fullCalendar を表現する DOM ID
    var hfc = $('#hfc');
    
    // mTitle
    // 小さいほうの fullCalendar が描画している日付を示すタイトル用 DOM ID
    var mTitle = $('#current-view-mini');
    
    // hTitle
    // 大きいほうの fullCalendar が描画している日付を示すタイトル用 DOM ID
    var hTitle = $('#current-view');
    
    
    // control buttons
    // ----------------------------
    
    // btnToday
    var btnToday = $('#wfc-btn-today');
    
    // btnDay
    var btnDay = $('#wfc-btn-day');
    
    // btnWeek
    var btnWeek = $('#wfc-btn-week');
    
    // btnMonth
    var btnMonth = $('#wfc-btn-month');

    // btnPrev
    var btnPrev = $('#wfc-btn-prev');
    
    // btnNext
    var btnNext = $('#wfc-btn-next');
    

    // カレンダーを画面いっぱいに広げるため、画面の高さを得るが、
    // その際に既に利用している領域のサイズを確保する。
    var calMargin = 60;
    
    // minifcViewSwitch
    var minifcViewSwitch = true;
    
    // CONTROL FUNCTIONS DEFINITION
    // ----------------------------
    
    // add function :: getDayOfYear()
    Date.prototype.getDayOfYear = function() {
        var onejan = new Date(this.getFullYear(), 0, 1);
        return Math.ceil((this - onejan) / 86400000);
    };
    
    // add function :: getWeekOfYear()
    Date.prototype.getWeekOfYear = function() {
        var onejan = new Date(this.getFullYear(), 0, 1);
        var offset = onejan.getDay() -1;
        var weeks = Math.floor((this.getDayOfYear() + offset) / 7);
        return (onejan.getDay() == 0 ) ? weeks + 1 : weeks;
    };
    
    // fitMinicalDate -- adjust minical's view to the huge calendar's date.
    function fitMinicalDate() {
        if (minifcViewSwitch) {
            mfc.fullCalendar('gotoDate', hfc.fullCalendar('getDate'));
            mTitle.html(mfc.fullCalendar('getView').title);
        }
        $('td.fc-today').siblings().addClass('fc-thisweek');
    }
    
    // hfcPrev -- move view previous in huge fullCalendar
    function hfcPrev() {
        hfc.fullCalendar('prev');
        hTitle.html(hfc.fullCalendar('getView').title);
        fitMinicalDate();
    }
    
    // hfcNext -- move view next in huge calendar.
    function hfcNext() {
        hfc.fullCalendar('next');
        hTitle.html(hfc.fullCalendar('getView').title);
        fitMinicalDate();
    }
    
    // changeViewBtn
    function changeViewBtn(viewName) {
        btnWeek.removeClass('btn-success');
        btnMonth.removeClass('btn-success');
        btnDay.removeClass('btn-success');
        
        switch (viewName) {
        case 'agendaDay':
            btnDay.addClass('btn-success');
            break;
        case 'agendaWeek':
            btnWeek.addClass('btn-success');
            break;
        case 'month':
            btnMonth.addClass('btn-success');
            break;
        default: // unknwon status
            break;
        }
        hfc.fullCalendar('changeView', viewName);
        hTitle.html(hfc.fullCalendar('getView').title);
        $('td.fc-today').siblings().addClass('fc-thisweek');
    }
    
    // shorthands
    
    // change view agendaDay
    function changeViewDay() { changeViewBtn('agendaDay'); }
    
    // change view agendaWeek
    function changeViewWeek() { changeViewBtn('agendaWeek'); }
    
    // change view month
    function changeViewMonth() { changeViewBtn('month'); }
    
    // FULLCALRNDAR INITIALIZATION
    // ----------------------------
    
    $(document).ready(function () {
    
        // REQUIRED jQuery.QTIP2 PLUGIN
        // -----------------------
        
        // var tooltip = $('<div/>').qtip({
        // id: 'hfc', show: false, hide: false, prerender: true,
        // content: { text: $('#eventAdd'), title: { button: true } },
        // position: {
        //     adjust: {mouse:false,scroll:false},
        //     my: 'right bottom', at: 'left top',
        //     viewport: hfc,
        //     target: 'mouse'
        // },
        // style: 'qtip-shadow qtip-light my_width_setting_class'
        // }).qtip('api');
    
    
        // mini calendar
        // -----------------------
        mfc.fullCalendar({
            header: { left: '', center: '', right: '' },
            dayNamesShort: ['S', 'M', 'T', 'W', 'T', 'F', 'S'], // very short name
            height: 130, contentHeight: 130, aspectRatio: 1,
            selectable: true,
            
            select: function (start, end, allDay, jsEvent, view) {
                var currentView = hfc.fullCalendar('getView').name;
                var mfcDate = start,
                    hfcDate = hfc.fullCalendar('getDate');
                
                var viewName = currentView;
                
                // If user selet 1 week+ (>=60*60*24*7*1000) then change 'month' view
                if(end.getTime() - start.getTime() >= 604800000) {
                    viewName = 'month';
                } else if (end.getTime() != start.getTime()) {
                    viewName = 'agendaWeek';
                } else {
                    
                    // several situation
                    if (currentView == 'month') {
                        if(mfcDate.getFullYear() == hfcDate.getFullYear() && mfcDate.getMonth() == hfcDate.getMonth()) {
                            viewName = 'agendaWeek';
                        }
                    } else if (currentView == 'agendaWeek') {
                        if(mfcDate.getFullYear() == hfcDate.getFullYear() && mfcDate.getWeekOfYear() == hfcDate.getWeekOfYear()) {
                            viewName = 'agendaDay';
                        }
                    }
                }
                
                hfc.fullCalendar('gotoDate', start);
                changeViewBtn(viewName);
            }
        });
        
        // huge calendar
        // -----------------------
        hfc.fullCalendar({
            header: { left: '', center: '', right: '' },
            titleFormat: {
                day: 'ddd, MMM d, yyyy',
            },
            timeFormat: {
                month: 'H:mm{ - H:mm} '
            },
            axisFormat: 'H:mm',
            
            events: baseURL + 'events/', // EventsController::index() method
            defaultEventMinutes: 60,
            snapMinutes: 15,
            aspectRatio: 1,
            height: $(window).height() - calMargin,
            selectable: true,
            editable: true,
            selectHelper: true,
            
            // event handler 1: select
            // ---------------------
            select: function (start, end, allDay, jsEvent, view) {
                // tooltip.hide();
                
                // call dialog box for event-add, and save.
                // required moment.js
                $.ajax({
                    type: 'GET',
                    url: baseURL 
                        + 'events/add?start=' + moment(start).format('X') 
                        + '&end=' + moment(end).format('X')
                        + '&allDay=' + allDay,
                    timeout: 30000,
                    beforeSend: function (XMLHttpRequest) {
                        loading.html('<img src="' + baseURL + loadingGif + '"/>');
                    },
                    complete: function (XMLHttpRequest, testStatus) {
                        loading.html('');
                    },
                    success: function (html) {
                        // $('#eventAdd-content').html(html);
                        // tooltip.reposition(jsEvent).show(jsEvent);
                    }
                });
            },
            
            // event handler 2: eventClick
            // ---------------------
            eventClick: function (event, jsEvent, view) {
                // tooltip.hide();
                
                $.ajax({
                    type: 'GET',
                    url: baseURL + 'events/edit/' + event.id
                        + '?start=' + moment(event.start).format('X')
                        + '&end=' + moment(event.end).format('X')
                        + '&allDay=' + event.allDay,
                    timeout: 30000,
                    beforeSend: function (XMLHttpRequest) {
                        loading.html('<img src="' + baseURL + loadingGif + '"/>');
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        loading.html('');
                    },
                    success: function (html) {
                        // $('#eventAdd-content').html(html);
                        // tooltip.reposition(jsEvent).show(jsEvent);
                    }
                });
            },
            
            // event handler 3: eventResize
            // ---------------------
            eventResize: function (event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view) {
                
                // event.end empty problem occurs moment.js error!
                if (event.end == null) event.end = event.start;
                
                $.ajax({
                    type: 'GET',
                    url: baseURL + 'events/change/' + event.id
                        + '/' + moment(event.start).format('X')
                        + '/' + moment(event.end).format('X')
                        + '/' + event.allDay,
                    timeout: 30000
                });
            },
            
            // event handler 4: eventDrop
            // --------------------
            eventDrop: function (event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
                
                $.ajax({
                    type: 'GET',
                    url: baseURL + 'events/change/' + event.id
                        + '/' + moment(event.start).format('X')
                        + '/' + moment(event.end).format('X')
                        + '/' + allDay,
                    timeout: 30000
                });
            }
        });
    });
    
    // OTHER VIEW APPLYING
    // ----------------------------
    $(window).load(function (){
        
        // double calendar top
        // ------------------------
        
        // insert current date into title
        hTitle.html(hfc.fullCalendar('getView').title);
        
        // insert current date into tabbar
        mTitle.html(mfc.fullCalendar('getView').title);
        
        // apply style
        $('td.fc-today').siblings().addClass('fc-thisweek');
        
        
        // mini controller
        // ------------------------
        mfc.on('hidden.bs.collapse', function() {
            minifcViewSwitch = false;
            mTitle.html(mTitleDefault);
        });
        
        mfc.on('shown.bs.collapse', function() {
            minifcViewSwitch = true;
            fitMinicalDate();
        });
        
        // change minifc-side's view with MOUSE WHEEL EVENT.
        mfc.mousewhel(function (eo, delta, deltaX, deltaY) {
            if (delta > 0) {
                mfc.fullCalendar('prev');
                mTitle.html(mfc.fullCalendar('getView').title);
            } else if (delta < 0) {
                mfc.fullCalendar('next');
                mTitle.html(mfc.fullCalendar('getView').title);
            }
        });
        
        // change hugefc-side's view with MOUSEWHEEL EVENT.
        hfc.mousewheel(function (eo, delta, deltaX, deltaY) {
            
            // do nothing when huge calendar's view is 'month'.
            if (hfc.fullCalendar('getView').name != 'month') return;
            
            if (delta > 0) {
                hfcPrev();
            } else if (delta < 0) {
                hfcNext();
            }
        });
        
        // bind keyboard event to hugefc-side
        $(window).keydown(function (e) {
            if (e.keyCode == 37 || e.keyCode == 38) {
                hfcPrev();
            } else if (e.keyCode == 39 || e.keyCode == 40) {
                hfcNext();
            }
        });
        
        // bind prev/next buttons
        btnPrev.click(function () { hfcPrev(); });
        btnNext.click(function () { hfcNext(); });
        
        // huge full calendar resizing with window not resize ... but mouseup ...
        $(window).mouseup(function () {
            hfc.fullCalendar('option', 'height', $(window).height() - calMargin);
        });
        
        
        // changeView button configuration
        
        // 1. today button
        btnToday.click(function () {
            hfc.fullCalendar('today');
            hTitle.html(hfc.fullCalendar('getView').title);
            fitMinicalDate();
        });
        
        // 2. day (view change button)
        btnDay.click(function () { changeViewDay(); });
        
        // 3. week
        btnWeek.click(function () {changeViewWeek(); });
        
        // 4. month
        btnMonth.click(function () {changeViewMonth(); });
        
        // set MONTH view initially.
        changeViewMonth();
    });
}();
