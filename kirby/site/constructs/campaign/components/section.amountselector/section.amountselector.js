var AmountSelector = (function($, Kirby, Utils) {

	// when applied to the onkeypress event, this prevents all non-numeric keys from being used.
	function blockNonNumeric(e) {
		if (e.charCode != 0 && (e.charCode < 48 || e.charCode > 57)) {
			e.preventDefault();
		}
	}

	function Interval(name, factor, isRecurring) {
		this.name = name;
		this.factor = factor;
		this.isRecurring = isRecurring === undefined ? true : isRecurring;
	}

	$.extend(Interval.prototype, {
		scaleAmount: function (amount) {
			return this.factor * amount;
		},
		suffix: function (base) {
			return base + '-' + (this.isRecurring ? 'recurring' : 'onetime');
		},
	});

	var intervalFactors = {
		none: new Interval('none', 1, false),
		weekly: new Interval('weekly', 0.25),
		monthly: new Interval('monthly', 1),
		quarterly: new Interval('quarterly', 3),
		semestral: new Interval('semestral', 6),
		yearly: new Interval('yearly', 12),
	};



	function CustomAmountOverlay($overlay) {
		this.$overlay = $overlay;
		this.$closeButton = $overlay.find('.donation-box-custom-overlay-close');
		this.$customAmount = $overlay.find('.input-donate-custom');
		this.$placeholder = $overlay.find('.donation-box-custom-input-placeholder');
		this.$currency = $overlay.find('.donation-box-custom-input-currency');
		this.$errors = $overlay.find('.donation-box-error');
		this.interval = intervalFactors.none;

		var that = this;

		that.rules = [
			{
				validate: function (val) {
					return !that.getData('min-amount') || val >= that.getData('min-amount');
				},
				message: '.donation-box-error-min',
			},
			{
				validate: function (val) {
					return !that.getData('max-amount') || val <= that.getData('max-amount');
				},
				message: '.donation-box-error-max',
			},
		];

		that.$closeButton
			.on('click', $.proxy(that.onOverlayClose, that));

		that.$customAmount
			.on('keypress', blockNonNumeric)
			.on('focus', $.proxy(this.onFocus, this))
			.on('blur', $.proxy(this.onBlur, this));
	}

	$.extend(CustomAmountOverlay.prototype, {
		element: function () { return this.$overlay; },
		show: function () { this.$overlay.show(); },
		hide: function () { this.$overlay.hide(); },
		onOverlayClose: function (e) {
			e.preventDefault();
			this.$overlay.trigger($.Event('close'));
		},
		setInterval: function (interval) {
			this.interval = interval;
			Utils.replace(this.$overlay, {
				minAmount: this.getData('min-amount'),
				maxAmount: this.getData('max-amount'),
			});
		},
		getData: function (base) {
			return this.interval.scaleAmount(this.$customAmount.data(this.interval.suffix(base)));
		},
		validate: function () {
			var that = this,
				amount = parseInt(that.$customAmount.val()),
				valid = true;

			that.$customAmount.removeClass('error');
			that.$errors.hide();

			$.each(that.rules, function (index, rule) {
				if (!rule.validate(amount)) {
					valid = false;
					that.$customAmount.addClass('error');
					that.$overlay.find(rule.message).show();
				}
			});

			return (valid ? amount : false);
		},
		onFocus: function () {
			this.$currency.show();
			this.$placeholder.hide();
		},
		onBlur: function () {
			if (!this.$customAmount.val()) {
				this.$currency.hide();
				this.$placeholder.show();
			}
		},
	});


	function DonationBox($container) {
		this.$container = $container;
		this.$topBox = $container.find('.donation-box-top');
		this.overlay = new CustomAmountOverlay($container.find('.donation-box-custom-overlay'));
		// Selectize instance
		this.intervalSelect = $container.find('[name=donation-box-interval]').selectize().get(0).selectize;
		this.amountsAll = $container.find('.donation-box-amount');
		this.amounts = this.amountsAll.filter(':not(.donation-box-amount-custom)');
		this.interval = intervalFactors.none;

		var that = this;

		// The order of the event registrations and triggering is important - all event handlers need to be set up
		// before one of them is triggered.

		that.$container.find('.donation-box-donate')
			.on('click', $.proxy(that.donate, that));

		that.overlay.element()
			.on('close', $.proxy(that.onOverlayClose, that));

		that.amountsAll.find('[name=amount-radios]')
			.on('change', $.proxy(that.onAmountSelected, that));

		that.amountsAll.filter('.donation-box-amount-custom')
			.on('click', $.proxy(that.onCustomAmountClicked, that));

		that.intervalSelect.on('change', $.proxy(that.onIntervalSelected, that));
		that.intervalSelect.setValue($container.data('default-interval'));

		if (Object.keys(that.intervalSelect.options).length < 2) {
			that.$container.find('.donation-box-select').hide();
		}
	}

	$.extend(DonationBox.prototype, {
		onAmountSelected: function (e) {
			var item = $(e.target).parents('.donation-box-amount');

			this.amountsAll.removeClass('active');
			item.addClass('active');

			this.amount = $(e.target).val();
		},
		onIntervalSelected: function (e) {
			var that = this,
				interval = that.intervalSelect.getValue();

			that.interval = intervalFactors[interval] || intervalFactors.none;
			that.overlay.setInterval(that.interval);
			that.amounts.each(function () {
				var item = $(this),
					amount = that.interval.scaleAmount(parseInt(item.data(that.interval.suffix('amount'))));

				item.find('[name=amount-radios]').attr('value', amount);

				Utils.replace(item, {
					amount: amount,
				});
			});

			// do not reset the selected amount if the custom amount overlay is currently shown
			if (that.amount !== 'custom') {
				that._selectAmountOption(that.interval.scaleAmount(that.$container.data(that.interval.suffix('default-amount'))));
			}
		},
		onCustomAmountClicked: function (e) {
			this.prevState = {
				interval: this.intervalSelect.getValue(),
				amount: this.amount,
			};

			this.$topBox.hide();
			this.overlay.show();
		},
		onOverlayClose: function (e) {
			e.preventDefault();

			this.intervalSelect.setValue(this.prevState.interval);

			this._selectAmountOption(this.prevState.amount);

			this.overlay.hide();
			this.$topBox.show();
		},
		donate: function (e) {
			e.preventDefault();

			var amount = this.amount;

			if (amount === 'custom') {
				amount = this.overlay.validate();
			}

			if (amount) {
				e.preventDefault();

				var url = this.$container.data('checkout-url'),
					params = { amount: 100 * amount };

				if (this.interval.isRecurring) {
					params.interval = this.interval.name;
				}

				url = url + (url.indexOf('?') < 0 ? '?' : '&') + $.param(params);
				window.location.href = url;
			}
		},
		_selectAmountOption: function (amount) {
			this.amounts.find('[value="' + amount + '"]').first()
				.prop('checked', true)
				.change();
		},
	});



	function init() {
		$('.donation-box').each(function () {
			new DonationBox($(this));
		});
	}

	// EventEmitter listen for apps init
	ee.addListener('document-ready', init);

	// Public API
	return {
		init: init
	};

})(jQuery, Kirby, Utils);
