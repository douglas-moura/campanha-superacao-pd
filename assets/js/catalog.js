var btnAdd = $('.js-add-cart');
var btnRemove = $('.js-remove-cart');

btnAdd.on('click', function() {
  var order = getOrder();
  var cod = $(this).data("cod");
  var voltage = $(this).data("voltage");
  addItem(cod, voltage);
  $(this).addClass('is-used').addClass('harlem-shake');

  if($('#buy-' + (voltage || '') + '-' + cod)) {
    $('#buy-' + (voltage || '') + '-' + cod).hide();
  }

  $('#go-' + cod).show();
});

btnRemove.on('click', function() {
  removeItem($(this).data("cod"));
  $(this).closest('.product-cart').hide();

});

function getOrder() {
  var orderCookie = $.cookie('mxo');
  var orderJsonCookie = [];
  try {
    orderJsonCookie = orderCookie ? JSON.parse(orderCookie) : []
  } catch (e) {return}
  return orderJsonCookie;
}

function setOrder(order) {
  var orderJson = JSON.stringify(order);
  $.cookie('mxo', orderJson, { expires: 7, path: '/' });
}

function addItem(cod, voltage) {
  var order = getOrder();
  order.push({c: cod, v: voltage});
  setOrder(order);
}

function removeItem(cod) {
  var order = getOrder()
    .filter(function(item){
      return item.c !== cod;
    });
  setOrder(order);
    location.reload();
}
