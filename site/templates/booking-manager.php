<?php snippet('header') ?>

  <main class="main" role="main">

    <div class="text">
      <h1><?php echo $page->title()->html() ?></h1>
      <?php echo $page->description()->kirbytext() ?>
    </div>

    <hr />

	<?php snippet('bookingManager_bookingForm') ?>

  </main>

<?php snippet('footer') ?>