(function(document, window, $) {
  'use strict';

  var Site = window.Site;

  $(document).ready(function($) {
    Site.run();
  });

  // Example Tabledit Toolbars
  // -------------------------------
  (function() {
    $('#exampleTableditToolbars').Tabledit({
      columns: {
        identifier: [0, 'id'],
        editable: [
          [1, 'username'],
          [2, 'first'],
          [3, 'last']
        ]
      },
      buttons: {
        edit: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-wrench"></span>',
          action: 'edit'
        },
        delete: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-close"></span>',
          action: 'delete'
        }
      }
    });
  })();

  // Example Inline Tabledit Toolbars
  // -------------------------------
  (function() {
    $('#exampleTableditInlineEdit').Tabledit({
      eventType: 'dblclick',
      editButton: false,
      columns: {
        identifier: [0, 'id'],
        editable: [
          [1, 'username'],
          [2, 'last', '{"1": "May", "2": "Green", "3": "Brant"}']
        ]
      },
      buttons: {
        edit: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-wrench"></span>',
          action: 'edit'
        },
        delete: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-close"></span>',
          action: 'delete'
        }
      }
    });
  })();

  // Example Inline Tabledit without identifier
  // -------------------------------
  (function() {
    $('#InlineEditWithoutIndentify').Tabledit({
      editButton: false,
      deleteButton: false,
      hideIdentifier: true,
      columns: {
        identifier: [0, 'id'],
        editable: [
          [2, 'firstname'],
          [3, 'lastname']
        ]
      },
      buttons: {
        edit: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-wrench"></span>',
          action: 'edit'
        },
        delete: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-close"></span>',
          action: 'delete'
        }
      }
    });
  })();

  // Example Tabledit With Editbutton Only
  // -------------------------------
  (function() {
    $('#tableditWithEditButtonOnly').Tabledit({
      deleteButton: false,
      saveButton: false,
      autoFocus: false,
      columns: {
        identifier: [0, 'id'],
        editable: [
          [1, 'car'],
          [2, 'color']
        ]
      },
      buttons: {
        edit: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-wrench"></span>',
          action: 'edit'
        },
        delete: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-close"></span>',
          action: 'delete'
        }
      }
    });
  })();

  // Example Toolbar With Deletebutton only
  // -------------------------------
  (function() {
    $('#tableditWithDeleteButtonOnly').Tabledit({
      rowIdentifier: 'data-id',
      editButton: false,
      restoreButton: false,
      columns: {
        identifier: [0, 'id'],
        editable: [
          [1, 'nickname'],
          [2, 'firstname'],
          [3, 'lastname']
        ]
      },
      buttons: {
        edit: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-wrench"></span>',
          action: 'edit'
        },
        delete: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-close"></span>',
          action: 'delete'
        },
        confirm: {
          class: 'btn btn-sm btn-default',
          html: 'Are you sure?'
        }
      }
    });
  })();

  // Example Toolbar With Log All Hooks
  // -------------------------------
  (function() {
    $('#tableditLogAllHooks').Tabledit({
      rowIdentifier: 'data-id',
      editButton: true,
      restoreButton: true,
      columns: {
        identifier: [0, 'id'],
        editable: [
          [1, 'username'],
          [2, 'email'],
          [3, 'avatar', '{"1": "Black Widow", "2": "Captain America", "3": "Iron Man"}']
        ]
      },
      buttons: {
        edit: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-wrench"></span>',
          action: 'edit'
        },
        delete: {
          class: 'btn btn-sm btn-icon btn-flat btn-default',
          html: '<span class="icon wb-close"></span>',
          action: 'delete'
        }
      },
      onDraw: function() {
        console.log('onDraw()');
      },
      onSuccess: function(data, textStatus, jqXHR) {
        console.log('onSuccess(data, textStatus, jqXHR)');
        console.log(data);
        console.log(textStatus);
        console.log(jqXHR);
      },
      onFail: function(jqXHR, textStatus, errorThrown) {
        console.log('onFail(jqXHR, textStatus, errorThrown)');
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
      },
      onAlways: function() {
        console.log('onAlways()');
      },
      onAjax: function(action, serialize) {
        console.log('onAjax(action, serialize)');
        console.log(action);
        console.log(serialize);
      }
    });
  })();
})(document, window, jQuery);
