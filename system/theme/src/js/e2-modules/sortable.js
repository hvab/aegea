import e2Ajax from '../e2-modules/e2Ajax';
import Sortable from '../lib/sortable';

function initSortable() {
  $('.e2-js-menu-reorderable').each(function() {
    var $el = $(this);
    var sortable = $el.data('sortable');
    var options = {
      draggable: '.e2-js-menu-reorderable-item',
      ghostClass: 'e2-js-menu-reorderable-item-ghost',
      chosenClass: 'e2-js-menu-reorderable-item-chosen',
      dragClass: 'e2-js-menu-reorderable-item-drag',
      animation: 400,
      forceFallback: true, // чтобы элемент возвращался туда, куда его перетащили
      dataIdAttr: 'data-id',
      fallbackOnBody: true,
      fallbackTolerance: 4,
      onStart: function(evt) {
        evt.from.classList.add('e2-js-menu-reorderable-in-process')
      },
      onEnd: function(evt) {
        evt.from.classList.remove('e2-js-menu-reorderable-in-process')
      },
      currentOrder: [],
      store: {
        set: function(sortable) {
          var order = sortable.toArray();
          e2Ajax({
            url: $el.attr('data-action-save-order'),
            data: {
              order: order,
            },
            success: function(response) {
              sortable.options.currentOrder = order;
              console.log(response);
            },
            error: function(response) {
              sortable.sort(sortable.options.currentOrder, true);
            },
          });
        },

        get: function(sortable) {
          var order = sortable.toArray();
          sortable.options.currentOrder = order;
          return [];
          // Если первоначальная сортировка будет на клиенте, то:
          // return order;
        },
      },
    };

    if (!sortable) {
      sortable = new Sortable(this, options);
      $el.data('sortable', sortable);
    }
  });
}

export default initSortable;
