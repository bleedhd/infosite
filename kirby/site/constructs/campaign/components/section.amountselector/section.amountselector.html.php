
<?php echo $page->sectionImage()->responsive('slick-slider-image', ['class' => ['hidden-lg-up'], 'data-parent' => '.section-amountselector']); ?>

	<?php if ($page->shortHeadline()->isNotEmpty()): ?>
		<div class="container short-headline-wrapper">
			<div class="row">
				<div class="col-12">
					<h3 class="short-headline"><?php echo $page->shortHeadline()->html(); ?></h3>
				</div><!-- /.col-12 -->
			</div><!-- /.row -->
		</div><!-- /.container -->
	<?php endif ?><!-- /.short-headline-wrapper -->

<div class="container amountselector-content-wrapper">
	<div class="row amountselector-content <?php echo $page->layout(); ?>">
		<div class="col-12 col-md-12 col-lg-6 <?php echo ($page->layout() == 'text-right') ? 'push-lg-6' : ''; ?>">

		<?php if ($page->sectionHeadline()->isNotEmpty()): ?>
			<h3><?php echo $page->sectionHeadline()->html(); ?></h3>
		<?php endif ?>

		<?php if ($page->sectionContent()->isNotEmpty()): ?>
			<div class="section-content">
				<?php echo $page->sectionContent()->kirbytext(); ?>
			</div><!-- /.section-content -->
		<?php endif; ?>

		</div><!-- /.col-12 col-md-6 -->

		<div class="col-12 col-md-12 col-lg-6 <?php echo ($page->layout() == 'text-right') ? 'pull-lg-6' : ''; ?>">

			<div class="donation-box donation-box-4 <?php echo ($page->layout() == 'text-left') ? 'push-right' : ''; ?>"
				 data-default-amount-onetime="<?php echo $box->defaultAmountOnetime(); ?>"
				 data-default-amount-recurring="<?php echo $box->defaultAmountRecurring(); ?>"
				 data-default-interval="<?php echo $box->defaultInterval(); ?>"
				 data-checkout-url="<?php echo $donationUrl; ?>"
			>
				<form>

					<div class="donation-box-top">

						<div class="donation-box-title">
							<h4><?php echo $page->boxTitle()->value(); ?></h4>
						</div><!-- /.donation-box-title -->

						<fieldset class="donation-box-amounts">
							<legend class="sr-only"><?php echo l::get('amountselector.legend'); ?></legend>

							<?php for ($i = 0; $i < 3; $i++): ?>
								<label for="donation-radio-<?php echo $i; ?>" class="donation-box-amount" data-amount-onetime="<?php echo $box->amounts()[$i]->onetime(); ?>" data-amount-recurring="<?php echo $box->amounts()[$i]->recurring(); ?>">
									<span class="donation-box-amount-currency donation-amount-currency-offset" aria-hidden="true"><?php echo l::get('currency'); ?></span>
									<span class="donation-box-amount-amount" aria-hidden="true" data-placeholder="amount"></span>
									<span class="sr-only"><?php echo l::get('currency'); ?> <span data-placeholder="amount"></span></span>
									<input type="radio" id="donation-radio-<?php echo $i; ?>" class="sr-only" value="" name="amount-radios">
								</label>
							<?php endfor; ?>

							<label for="donation-radio-custom" class="donation-box-amount donation-box-amount-custom">
								<span class="donation-box-amount-currency donation-amount-currency-offset" aria-hidden="true"><?php echo l::get('currency'); ?></span>
								<span class="donation-box-amount-amount donation-box-amount-amount-custom" aria-hidden="true"></span>
								<span class="sr-only"><?php echo l::get('amountselector.custom.amount.option.label'); ?></span>
								<input type="radio" id="donation-radio-custom" class="sr-only" value="custom" name="amount-radios">
							</label>

						</fieldset><!-- /.donation-box-amounts -->

					</div><!-- /.donation-box-top -->

					<div class="donation-box-custom-overlay">
						<button class="donation-box-custom-overlay-close"><?php echo l::get('amountselector.overlay.close.text'); ?></button>

						<div class="donation-box-title">
							<h4><?php echo $page->boxTitle()->value(); ?></h4>
						</div><!-- /.donation-box-title -->

						<div class="donation-box-custom-input">
							<div class="form-group"> <!-- .has-error -->
								<span class="donation-box-custom-input-currency"><?php echo l::get('currency'); ?></span>
								<span class="donation-box-custom-input-placeholder"><?php echo $page->customAmountLabel()->value(); ?></span>
								<label for="input-donate-custom" class="sr-only"><?php echo structure(l::get('amountselector.custom.amount.label'))->replace(['currency' => l::get('currency'), 'minAmount' => $box->minAmount(), 'maxAmount' => $box->maxAmount()]); ?></label>
								<input type="text" id="input-donate-custom" class="form-control input-lg input-donate-custom" value=""
									   data-min-amount-onetime="<?php echo $box->minAmountOnetime(); ?>"
									   data-max-amount-onetime="<?php echo $box->maxAmountOnetime(); ?>"
									   data-min-amount-recurring="<?php echo $box->minAmountRecurring(); ?>"
									   data-max-amount-recurring="<?php echo $box->maxAmountRecurring(); ?>">
								<div class="donation-box-custom-input-error">
									<div class="donation-box-error donation-box-error-min"><?php echo structure(l::get('amountselector.validation.error.min'))->replace(['currency' => l::get('currency'), 'minAmount' => $box->minAmount()]); ?></div>
									<div class="donation-box-error donation-box-error-max"><?php echo structure(l::get('amountselector.validation.error.max'))->replace(['currency' => l::get('currency'), 'maxAmount' => $box->maxAmount()]); ?></div>
									<div class="donation-box-error donation-box-error-default"><?php echo l::get('amountselector.validation.error.default'); ?></div>
								</div><!-- /.donation-box-custom-input-error -->
							</div><!-- /.form-group -->
						</div><!-- /.donation-box-custom-input -->

					</div><!-- /.donation-box-custom-overlay -->

					<div class="donation-box-select">
						<div class="form-group">

							<label for="donation-box-select-interval" class="sr-only"><?php echo l::get('amountselector.interval.label'); ?></label>
							<select class="form-control input-lg" name="donation-box-interval" id="donation-box-select-interval" placeholder="Select a option ..." tabindex="-1" style="display: none;">
								<?php foreach ($box->intervals() as $interval): ?>
									<option value="<?php echo $interval->value(); ?>"><?php echo $interval->label(); ?></option>
								<?php endforeach; ?>
							</select>

						</div><!-- /.form-group -->
					</div>

					<button class="btn btn-primary btn-lg btn-block donation-box-btn donation-box-donate"><?php echo $page->buttonLabel()->value(); ?></button>

				</form>
			</div>

		</div><!-- /.col-12 col-md-6 -->
	</div><!-- /.row -->
</div><!-- /.container amountselector-content-wrapper -->
