/*!
 * remark v1.0.3 (http://getbootstrapadmin.com/remark)
 * Copyright 2015 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */
$.components.register("table", {
  mode: "api",
  defaults: {},
  api: function() {
    /* selectable */
    var selectRow = function(item, value) {
      if (value) {
        item.closest("tr").addClass("active");
      } else {
        item.closest("tr").removeClass("active");
      }
    };

    $(document).on('click', '[data-table="selectable"] .select-all', function() {
      var value = $(this).prop("checked");

      var $table = $(this).parents('[data-table="selectable"]');
      $table.find(".select-row").each(function() {
        var $one = $(this);
        $one.prop("checked", value);

        selectRow($one, value);
      });
    });

    $(document).on('click', '[data-table="selectable"] .select-row', function() {
      var $one = $(this);
      value = $one.prop("checked");
      selectRow($one, value);
    });

    $(document).on('click', '[data-row-selectable="true"] > tbody > tr', function(e) {
      if ("checkbox" !== e.target.type && "button" !== e.target.type && "a" !== e.target.tagName.toLowerCase() && !$(e.target).parent("div.checkbox-custom").length) {
        var $checkbox = $(".select-row", this),
          value = $checkbox.prop("checked");
        $checkbox.prop("checked", !value);
        selectRow($checkbox, !value);
      }
    });

    $(document).on('change', '[data-table="selectable"] .select-row', function() {
      var $table = $(this).parents('[data-table="selectable"]');
      $all = $table.find('.select-all'),
        $row = $table.find('.select-row'),
        total = $row.length,
        checked = $('.select-row', $table).filter(':checked').length;

      if (total === checked) {
        $all.prop('checked', true);
      } else {
        $all.prop('checked', false);
      }
    });

    /* section */
    $(document).on('click', '.table-section', function(e) {
      if ("checkbox" !== e.target.type && "button" !== e.target.type && "a" !== e.target.tagName.toLowerCase() && !$(e.target).parent("div.checkbox-custom").length) {
        if ($(this).hasClass("active")) {
          $(this).removeClass("active")
        } else {
          $(this).siblings('.table-section').removeClass("active");
          $(this).addClass("active");
        }
      }
    });
  }
});
