jQuery(document).ready(function($) {
    "use strict";
    $('.cq-datatable').each(function(index) {
        var _this = $(this);
        var _headerArr = [];
        var _header = $('.cq-datatable-header', _this);
        var _dataArr = [];
        $('.cq-datatable-cell', _header).each(function(index) {
            _headerArr[index] = $(this).data('title');
        });
        $('.cq-datatable-data', _this).each(function() {
            $('.cq-datatable-cell', $(this)).each(function(index) {
                $(this).attr('data-title', _headerArr[index]);
            });
        });


    });

});
