// Stripe Checkout
var handler = StripeCheckout.configure({
  key: 'pk_test_xxxxxxxxxxxxxxxxxxxxx',
  image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
  locale: 'auto',
  token: function(token) {
    // ...manejo del token...
  }
});
// ...código truncado por longitud, contiene integración Stripe Checkout...
