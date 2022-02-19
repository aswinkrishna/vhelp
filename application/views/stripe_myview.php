<?php $this->load->config('stripe'); ?>
<!-- Load Stripe.js on your website. -->
<script src="https://js.stripe.com/v3"></script>
<style>
    #loading-bar-spinner.spinner {
    left: 50%;
    margin-left: -20px;
    top: 50%;
    margin-top: -20px;
    position: absolute;
    z-index: 19 !important;
    animation: loading-bar-spinner 400ms linear infinite;
}

#loading-bar-spinner.spinner .spinner-icon {
    width: 40px;
    height: 40px;
    border:  solid 4px transparent;
    border-top-color:  #00C8B1 !important;
    border-left-color: #00C8B1 !important;
    border-radius: 50%;
}

@keyframes loading-bar-spinner {
  0%   { transform: rotate(0deg);   transform: rotate(0deg); }
  100% { transform: rotate(360deg); transform: rotate(360deg); }
}

</style>
<div id="loading-bar-spinner" class="spinner"><div class="spinner-icon"></div></div>
<!-- Create a button that your customers click to complete their purchase. Customize the styling to suit your branding. -->
<button
  style="background-color:#6772E5;color:#FFF;padding:8px 12px;border:0;border-radius:4px;font-size:1em;display: none;"
  id="checkout-button-sku_GiKmqgquMlUjYm"
  role="link"
>
  Checkout
</button>

<div id="error-message"></div>

<script>
(function() {
  $key = '<?php echo $this->config->item('stripe_publishable_key'); ?>';
  var stripe = Stripe($key);

    // When the customer clicks on the button, redirect
    // them to Checkout.
    stripe.redirectToCheckout({
      // test
      sessionId: '<?php echo $session_id; ?>'
    })
    .then(function (result) {
      if (result.error) {
        // If `redirectToCheckout` fails due to a browser or network
        // error, display the localized error message to your customer.
        var displayError = document.getElementById('error-message');
        displayError.textContent = result.error.message;
      }
    });
})();
</script>