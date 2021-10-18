jQuery(function ($) {

    $(".lvca-datetime_picker-wrap .lvca_datetime_picker").datetimepicker({
        dateFormat: "yy/mm/dd",
        timeFormat: 'HH:mm:ss',
        stepHour: 2,
        stepMinute: 10,
        stepSecond: 10
    });

});