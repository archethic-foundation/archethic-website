/* Credit for tab styles - http://tympanus.net/codrops/2014/09/02/tab-styles-inspiration/ */

jQuery(function ($) {

    // Don't do any of this if there are no tabs present here
    if ($('.lvca-tabs').length) {

        $('.lvca-tabs').each(function () {

            var $tabs = $(this);

            new LVCA_Tabs($tabs);

        });
    }

});

var LVCA_Tabs = function ($tabsElement) {

    this.tabs = $tabsElement;

    // tabs elems
    this.tabNavs = $tabsElement.find('.lvca-tab');

    // content items
    this.items = $tabsElement.find('.lvca-tab-pane');

    // show first tab item
    this.show(0);

    // init events
    this.initEvents();

    // make the tab responsive
    this.makeResponsive();
};

LVCA_Tabs.prototype.show = function (index) {

    // Clear out existing tab
    this.tabNavs.removeClass('lvca-active');
    this.items.removeClass('lvca-active');

    this.tabNavs.eq(index).addClass('lvca-active');
    this.items.eq(index).addClass('lvca-active');
};

LVCA_Tabs.prototype.initEvents = function () {

    var self = this;

    this.tabNavs.click(function (event) {

        event.preventDefault();

        var $anchor = jQuery(this).children('a').eq(0);

        var target = $anchor.attr('href').split('#').pop();

        self.show(self.tabNavs.index(jQuery(this)));

        history.pushState ? history.pushState(null, null, "#" + target) : window.location.hash = "#" + target;
    });

};

LVCA_Tabs.prototype.makeResponsive = function () {

    var self = this;

    /* Trigger mobile layout based on an user chosen browser window resolution */
    var mediaQuery = window.matchMedia('(max-width: ' + self.tabs.data('mobile-width') + 'px)');
    if (mediaQuery.matches) {
        self.tabs.addClass('lvca-mobile-layout');
    }
    mediaQuery.addListener(function (mediaQuery) {
        if (mediaQuery.matches)
            self.tabs.addClass('lvca-mobile-layout');
        else
            self.tabs.removeClass('lvca-mobile-layout');
    });

    /* Close/open the mobile menu when a tab is clicked and when menu button is clicked */
    this.tabNavs.click(function (event) {
        event.preventDefault();
        self.tabs.toggleClass('lvca-mobile-open');
    });

    this.tabs.find('.lvca-tab-mobile-menu').click(function (event) {
        event.preventDefault();
        self.tabs.toggleClass('lvca-mobile-open');
    });
};
