<?php

  $boxes = $page->boxes()->toStructure();
  $count = $boxes->count();
  $index = 0;

  if ($count > 3) {
    $responsiveCols = 'col-12 col-md-6';
  } else {
    $responsiveCols = 'col-12 col-md-6 col-lg-4';
  }

?>

<div class="container">

	<div class="row">
		<div class="col-12">

			<?php if ($page->sectionHeadline()->isNotEmpty()): ?>
				<h3><?php echo $page->sectionHeadline()->html(); ?></h3>
			<?php endif ?>

			<?php if ($page->sectionContent()->isNotEmpty()): ?>
				<div class="section-content">
					<?php echo $page->sectionContent()->kirbytext(); ?>
				</div><!-- /.section-content -->
			<?php endif; ?>

		</div><!-- /.col-12 -->
	</div><!-- /.row -->

	<div class="row">

			<?php foreach ($page->boxes()->toStructure() as $box): ?>

				<div class="<?php echo $responsiveCols; ?>">

					<div class="donation-sample">

						<div class="donation-sample-head">
							<?php echo $box->image()->responsive('donate-sample-image'); ?>
						</div><!-- /.donation-sample-head -->

						<div data-mh="match-height" class="donation-sample-body">

							<?php if ($box->amount()->int()): ?>

								<div class="donation-sample-amount-box">
									<div class="donation-sample-amount-col">
										<div class="donation-sample-currency">CHF</div><!-- /.donation-sample-currency -->
										<div class="donation-sample-amount"><?php echo $box->amount()->value(); ?></div><!-- /.donation-sample-amount -->
										<?php if ($box->intervalType()->value() !== 'none'): ?>
											<div class="donation-sample-interval"><?php echo l::get('interval.' . $box->intervalType()->value()); ?></div><!-- /.donation-sample-interval -->
										<?php endif; ?>
									</div><!-- /.donation-sample-amount-col -->
								</div><!-- /.donation-sample-amount-box -->

								<div class="donation-sample-text">
									<?php echo $box->text()->html(); ?>
								</div><!-- /.donation-sample-text -->

								<div class="donation-sample-button-wrapper">
									<a class="btn btn-primary" href="<?php echo $donationUrl($box->amount()->int(), $box->intervalType()->value()); ?>"><?php echo $box->buttonLabel()->html(); ?></a>
								</div><!-- /.donation-sample-button-wrapper -->

							<?php else: ?>
								<?php
								/**
								 * The donation-* classes on the container, the amount text field and the checkout link are required
								 * for JS integration.
								 */
								?>
								<div class="donation-custom">

									<?php if ($page->customAmountTitle()->isNotEmpty()): ?>
										<div class="custom-amount-title">
											<?php echo $page->customAmountTitle(); ?>
										</div><!-- /.custom-amount-title -->
									<?php endif ?>

									<div class="donation-sample-text">
										<?php echo $box->text()->html(); ?>
									</div><!-- /.donation-sample-text -->

									<div class="amount-col">
										<div class="donation-currency">CHF</div><!-- /.donation-currency -->
										<input type="text" class="donation-amount" min="<?php echo $getLimit($box, 'min'); ?>" max="<?php echo $getLimit($box, 'max'); ?>" />
									</div><!-- /.amount-col -->

									<?php if ($box->intervalType()->value() !== 'none'): ?>
										<div class="donation-interval">
											<?php echo l::get('interval.' . $box->intervalType()->value()); ?>
										</div><!-- /.donation-interval -->
									<?php endif; ?>

									<div class="donation-sample-button-wrapper">
										<a class="btn btn-primary donation-checkout" href="<?php echo $donationUrl(NULL, $box->intervalType()->value()); ?>"><?php echo $box->buttonLabel()->html(); ?></a>
									</div><!-- /.donation-sample-button-wrapper -->
								</div><!-- /.donation-custom -->

							<?php endif; ?>

						</div><!-- /.donation-sample-body -->

					</div><!-- /.donation-sample -->

				</div><!-- /.col-12 col-md-6 col-lg-4 -->
			<?php endforeach; ?>

	</div><!-- /.row -->
</div><!-- /.container -->
