<div class="text">
  <h1><?php echo $page->bookingTitle()->html() ?></h1>
  <?php echo $page->bookingDescription()->kirbytext() ?>
</div>

<?php
  $messages = s::get('response');
  if(is_array($messages)) {
    foreach($messages as $message) {
      ?>
  <div class="message message-<?php echo $message['type']; ?>">
    <p><?php echo $message['message']; ?></p>
  </div>
<?php

    }
  }
  s::set('response', null);
?>

<form class="booking-manager" id="booking-manager-form" role="form" action="bookingManagerSend" method="post" >
  <div class="form-group">
    <label for="productSelect">Select a product:</label>
    <select class="form-control" id="productSelect" name="productSelect" required="required">
      <option value=""> Please select product </option>
      <?php 
        $product_array = $page->content()->get('products')->yaml();
        foreach($product_array as $key => $value): 
      ?>
      <option value="<?php echo BookingManager::seoUrl($value['title']); ?>"
      <?php if(isset($value['booking_frame']) ) { ?> data-date-start="<?php echo $value['booking_start']; ?>" 
          data-date-end="<?php echo $value['booking_end']; ?>" <?php } ?>> 
      <?php echo $value['title'];?>


      </option>
      <?php endforeach ?>
    </select>
    <!-- The Description of our products are shown if a product is selected -->
    <div id="description_container">
      <?php foreach($product_array as $key => $value): ?>
      <div id="product_<?php echo BookingManager::seoUrl($value['title']); ?>" style="display: none;">
        <p><?php echo $value['description'];?></p>
        <p>Price: <?php echo number_format($value['price'], 2, '.', ' '); ?> <?php echo $page->currency()->text(); ?></p>
      </div>
      <?php endforeach ?>
    </div>
  </div>

  <div class="form-group">
    <label for="date">Pick Date</label>
    <input type="text" class="datepicker form-control" name="date" id="date" placeholder="Pick Date" required="required">
  </div>

  <div class="form-group">
    <label for="name">Your Name</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required="required">
  </div>

  <div class="form-group">
    <label for="firstname">Your First Name</label>
    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter First Name" >
  </div>

  <div class="form-group">
    <label for="street">Street</label>
    <input type="text" class="form-control" name="street" id="street" placeholder="Enter Street" >
  </div>

  <div class="form-group">
    <label for="city">City</label>
    <input type="text" class="form-control" name="city" id="city" placeholder="Enter City">
  </div>

  <div class="form-group">
    <label for="zip">ZIP-Code</label>
    <input type="text" class="form-control" name="zip" id="zip" placeholder="Enter ZIP Code">
  </div>

  <div class="form-group">
    <label for="email">Your Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"  required="required">
  </div>

  <div class="form-group">
    <label for="tel">Your Telephone Number</label>
    <input type="number" class="form-control" id="tel" name="tel" placeholder="Enter Telephone Number">
  </div>

  <div class="form-group">
    <label for="message">Message</label>
    <textarea name="message" id="message" class="form-control" rows="5" ></textarea>
  </div>

  <div class="form-group"><?php $activeMethods = $page->paymentMethods()->value(); ?>
    <?php if(strpos($activeMethods, 'prepay') !== false): ?>
    <div class="radio">
      <label><input type="radio" name="payment" value="prePay">Pre-Pay</label>
    </div><?php endif; ?><?php if(strpos($activeMethods, 'paypal') !== false): ?>
    <div class="radio">
      <label><input type="radio" name="payment" value="payPal">PayPal</label>
    </div><?php endif; ?>
  </div>

  <div class="form-group">
    <div class="cf"></div>
    <input type="hidden" name="originId" value="<?php echo $page->id() ?>">
    <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
  </div>

</form>
