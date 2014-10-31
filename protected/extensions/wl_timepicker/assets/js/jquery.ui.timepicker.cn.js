/* German initialisation for the jQuery UI date picker plugin. */
/* Written by Milian Wolff (mail@milianw.de). */
 
$.datepicker.regional['cn'] = {
    closeText: '关闭',
    prevText: '上翻',
    nextText: '下翻',
    currentText: '现在',
    monthNames: ['一月','二月','三月','四月','五月','六月',
    '七月','八月','九月','十月','十一月','十二月'],
    monthNamesShort: ['一','二','三','四','五','六',
    '七','八','九','十','十一','十二'],
    dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
    dayNamesShort: ['日','一','二','三','四','五','六'],
    dayNamesMin: ['日','一','二','三','四','五','六'],
    weekHeader: '周',
    dateFormat: 'dd.mm.yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''};
 
$.timepicker.regional['cn'] = {
    timeOnlyTitle: '选择时间',
    timeText: '时间',
    hourText: '时',
    minuteText: '分',
    secondText: '秒',
    currentText: '现在',
    closeText: '关闭',
    ampm: false
};
 
$.datepicker.setDefaults($.datepicker.regional['cn']);
$.timepicker.setDefaults($.timepicker.regional['cn']);