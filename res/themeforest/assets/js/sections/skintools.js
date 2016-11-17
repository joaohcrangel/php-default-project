/*!
 * remark v1.0.2 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
(function(window, document, $) {
  'use strict';

  var $body = $(document.body);

  $.site.skintools = {
    tpl: '<div class="site-skintools">' +
      '<div class="site-skintools-inner">' +
      '<div class="site-skintools-toggle">' +
      '<i class="icon wb-settings primary-600"></i>' +
      '</div>' +
      '<div class="site-skintools-content">' +
      '<div class="nav-tabs-horizontal">' +
      '<ul role="tablist" data-plugin="nav-tabs" class="nav nav-tabs nav-tabs-line">' +
      '<li role="presentation" class="active"><a role="tab" aria-controls="skintoolsSidebar" href="#skintoolsSidebar" data-toggle="tab" aria-expanded="true">Sidebar</a></li>' +
      '<li role="presentation"><a role="tab" aria-controls="skintoolsNavbar" href="#skintoolsNavbar" data-toggle="tab" aria-expanded="false">Navbar</a></li>' +
      '<li role="presentation"><a role="tab" aria-controls="skintoolsPrimary" href="#skintoolsPrimary" data-toggle="tab" aria-expanded="false">Primary</a></li>' +
      '</ul>' +
      '<div class="tab-content">' +
      '<div role="tabpanel" id="skintoolsSidebar" class="tab-pane active"></div>' +
      '<div role="tabpanel" id="skintoolsNavbar" class="tab-pane"></div>' +
      '<div role="tabpanel" id="skintoolsPrimary" class="tab-pane"></div>' +
      '<button class="btn btn-outline btn-block btn-primary margin-top-20" id="skintoolsReset" type="button">Reset</button>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>',
    skintoolsSidebar: ['dark', 'light'],
    skintoolsNavbar: ['primary', 'brown', 'cyan', 'green', 'grey', 'indigo', 'orange', 'pink', 'purple', 'red', 'teal', 'yellow'],
    navbarSkins: 'bg-primary-600 bg-brown-600 bg-cyan-600 bg-green-600 bg-grey-600 bg-indigo-600 bg-orange-600 bg-pink-600 bg-purple-600 bg-red-600 bg-teal-600 bg-yellow-700',
    skintoolsPrimary: ['primary', 'brown', 'cyan', 'green', 'grey', 'indigo', 'orange', 'pink', 'purple', 'red', 'teal', 'yellow'],
    localStorageName: 'skintools',
    defaultSettings: {
      'sidebar': 'dark',
      'navbar': 'primary',
      'navbarInverse': 'false',
      'primary': 'primary'
    },
    init: function() {
      var self = this;

      this.path = this.getLevel(window.location.pathname, 'html');

      this.$siteSidebar = $('.site-menubar');
      this.$siteNavbar = $('.site-navbar');

      this.$container = $(this.tpl);
      this.$toggle = $('.site-skintools-toggle', this.$container);
      this.$content = $('.site-skintools-content', this.$container);

      this.$sidebar = $('#skintoolsSidebar', this.$content);
      this.$navbar = $('#skintoolsNavbar', this.$content);
      this.$primary = $('#skintoolsPrimary', this.$content);

      this.build(this.$sidebar, this.skintoolsSidebar, 'skintoolsSidebar', 'radio', 'Sidebar Skins');
      this.build(this.$navbar, ['inverse'], 'skintoolsNavbar', 'checkbox', 'Navbar Type');
      this.build(this.$navbar, this.skintoolsNavbar, 'skintoolsNavbar', 'radio', 'Navbar Skins');
      this.build(this.$primary, this.skintoolsPrimary, 'skintoolsPrimary', 'radio', 'Primary Skins');

      this.$container.appendTo($body);

      this.$toggle.on('click', function() {
        self.$container.toggleClass('is-open');
      });

      $('#skintoolsSidebar input').on('click', function() {
        self.sidebarEvents(this);
      });
      $('#skintoolsNavbar input').on('click', function() {
        self.navbarEvents(this);
      });
      $('#skintoolsPrimary input').on('click', function() {
        self.primaryEvents(this);
      });

      $('#skintoolsReset').on('click', function() {
        self.reset();
      });

      //$(document).ready(function() {
      self.initLocalStorage();
      //});
    },
    initLocalStorage: function() {
      var self = this;

      this.settings = localStorage.getItem(this.localStorageName);

      if (this.settings === null) {
        this.settings = JSON.stringify($.extend(true, {}, this.defaultSettings));
        localStorage.setItem(this.localStorageName, this.settings);
      }

      var settingsParse = JSON.parse(this.settings);
      if (settingsParse) {
        $.each(settingsParse, function(n, v) {
          switch (n) {
            case 'sidebar':
              $('input[value="' + v + '"]', self.$sidebar).prop('checked', true);
              self.sidebarImprove(v);
              break;
            case 'navbar':
              $('input[value="' + v + '"]', self.$navbar).prop('checked', true);
              self.navbarImprove(v);
              break;
            case 'navbarInverse':
              var flag = v === 'false' ? false : true;
              $('input[value="inverse"]', self.$navbar).prop('checked', flag);
              self.navbarImprove('inverse', flag);
              break;
            case 'primary':
              $('input[value="' + v + '"]', self.$primary).prop('checked', true);
              self.primaryImprove(v);
              break;
          }
        });
      }
    },

    updateSetting: function(item, value) {
      var settingsParse = JSON.parse(this.settings);
      settingsParse[item] = value;
      this.settings = JSON.stringify(settingsParse);
      localStorage.setItem(this.localStorageName, this.settings);
    },

    title: function(content) {
      return $('<h4 class="site-skintools-title">' + content + '</h4>')
    },
    item: function(type, name, id, content) {
      var item = '<div class="' + type + '-custom ' + type + '-' + content + '">' +
        '<input id="' + id + '" type="' + type + '" name="' + name + '" value="' + content + '">' +
        '<label for="' + id + '">' + content + '</label>' +
        '</div>';
      return $(item);
    },
    build: function($wrap, data, name, type, title) {
      if (title) {
        this.title(title).appendTo($wrap)
      }
      for (var i = 0; i < data.length; i++) {
        this.item(type, name, name + '-' + data[i], data[i]).appendTo($wrap);
      }
    },
    sidebarEvents: function(self) {
      var val = $(self).val();

      this.sidebarImprove(val);
      this.updateSetting('sidebar', val);
    },
    navbarEvents: function(self) {
      var val = $(self).val(),
        checked = $(self).prop('checked');

      this.navbarImprove(val, checked);

      if (val === 'inverse') {
        this.updateSetting('navbarInverse', checked.toString());
      } else {
        this.updateSetting('navbar', val);
      }
    },
    primaryEvents: function(self) {
      var val = $(self).val();

      this.primaryImprove(val);

      this.updateSetting('primary', val);
    },
    sidebarImprove: function(val) {
      if (val === 'dark') {
        this.$siteSidebar.removeClass('site-menubar-light');
      } else if (val === 'light') {
        this.$siteSidebar.addClass('site-menubar-' + val);
      }
    },
    navbarImprove: function(val, checked) {
      if (val === 'inverse') {
        checked ? this.$siteNavbar.addClass('navbar-inverse') : this.$siteNavbar.removeClass('navbar-inverse');
      } else {
        var bg = 'bg-' + val + '-600'
        if (val === 'yellow') {
          bg = 'bg-yellow-700';
        }
        this.$siteNavbar.removeClass(this.navbarSkins).addClass(bg);
      }
    },
    primaryImprove: function(val) {
      var $link = $('#skinStyle', $('head')),
        href = this.path + 'assets/skins/' + val + '.css';
      if (val === 'primary') {
        $link.remove();
        return;
      }
      if ($link.length === 0) {
        $('head').append('<link id="skinStyle" href="' + href + '" rel="stylesheet" type="text/css"/>');
      } else {
        $link.attr('href', href);
      }
    },
    getLevel: function(url, tag) {
      var arr = url.split('/').reverse(),
        level, path = '';

      $.each(arr, function(i, n) {
        if (n === tag) {
          level = i;
        }
      });
      for (var m = 0; m < level; m++) {
        path += '../'
      }
      return path;
    },
    reset: function() {
      localStorage.clear();
      var self = this;

      setTimeout(function() {
        self.initLocalStorage();
      }, 1);
    }
  };
})(window, document, jQuery);
