
<!-- referer page can be passed as parameter /source: -->
<?php $sourcePage = rawurldecode(param('source')); ?>

<?php if (count($form->errors()) > 0): ?>
	<div class="alert alert-danger" role="alert">
		<?php echo l::get('contactForm.error') ?>
	</div>
<?php endif; ?>

<form id="contact-form" action="<?php echo $page->url() ?>" method="post">

	<input type="hidden" name="source" value="<?php echo $sourcePage ?>">

	<?php echo l::get('contactForm.salutation') ?>

	<div class="form-check">
		<label>
		<input class="form-check-inpu getunik-radio" type="radio" name="salutation" value="<?php echo l::get('contactForm.salutationMs') ?>" <?php echo ( $form->old('salutation') === l::get('contactForm.salutationMs') || $form->old('salutation') === '' ) ? 'checked' : '' ?>>
			<span><?php echo l::get('contactForm.salutationMs') ?></span>
		</label>
		<label>
		<input class="form-check-inpu getunik-radio" type="radio" name="salutation" value="<?php echo l::get('contactForm.salutationMr') ?>" <?php echo ($form->old('salutation') === l::get('contactForm.salutationMr')) ? 'checked' : '' ?>>
			<span><?php echo l::get('contactForm.salutationMr') ?></span>
		</label>
	</div>

	<div class="form-group <?php if ($form->error('name')): ?>error<?php endif; ?>">
		<label for="name"><?php echo l::get('contactForm.name') ?> <sup>*</sup></label>
		<input class="form-control" type="text" id="name" name="name" value="<?php echo $form->old('name'); ?>" />
	</div>

	<div class="form-group <?php if ($form->error('surname')): ?>error<?php endif; ?>">
		<label for="surname"><?php echo l::get('contactForm.surname') ?> <sup>*</sup></label>
		<input class="form-control" type="text" id="surname" name="surname" value="<?php echo $form->old('surname'); ?>" />
	</div>

	<div class="form-group <?php if ($form->error('address')): ?>error<?php endif; ?>">
		<label for="address"><?php echo l::get('contactForm.address') ?> <sup>*</sup></label>
		<input class="form-control" type="text" id="address" name="address" value="<?php echo $form->old('address'); ?>" />
	</div>

	<div class="row">
		<div class="col-6 form-group <?php if ($form->error('zip')): ?>error<?php endif; ?>">
			<label for="zip"><?php echo l::get('contactForm.zip') ?> <sup>*</sup></label>
			<input class="form-control" type="text" id="zip" name="zip" value="<?php echo $form->old('zip'); ?>" />
		</div>

		<div class="col-6 form-group <?php if ($form->error('city')): ?>error<?php endif; ?>">
			<label for="city"><?php echo l::get('contactForm.city') ?> <sup>*</sup></label>
			<input class="form-control" type="text" id="city" name="city" value="<?php echo $form->old('city'); ?>" />
		</div>
	</div><!-- /.row -->

	<div class="form-group <?php if ($form->error('email')): ?>error<?php endif; ?>">
		<label for="email"><?php echo l::get('contactForm.email') ?> <sup>*</sup></label>
		<input class="form-control" type="text" name="email" id="email" value="<?php echo $form->old('email'); ?>" />
	</div>

	<div class="form-group">
		<label for="phone"><?php echo l::get('contactForm.phone') ?></label>
		<input class="form-control" type="text" id="phone" name="phone" value="<?php echo $form->old('phone'); ?>" />
	</div>

	<div class="form-group <?php if ($form->error('message')): ?>error<?php endif; ?>">
		<label for="message"><?php echo l::get('contactForm.message') ?> <sup>*</sup></label>
		<textarea class="form-control" name="message" id="message"  rows="8"><?php echo $form->old('message') ?></textarea>
	</div>

	<?php echo csrf_field(); ?>
	<?php echo honeypot_field(); ?>

	<input class="btn btn-primary btn-lg" type="submit" value="<?php echo l::get('contactForm.submit'); ?>">

</form>

