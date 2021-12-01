/**
 * Copyright © O2TI. All rights reserved.
 * @author    Bruno Elisei <brunoelisei@o2ti.com>
 * See COPYING.txt for license details.
 */

/*global define*/
define([
	"jquery",
	"ko",
	"underscore",
	"Magento_Ui/js/form/form",
	"Magento_Customer/js/model/customer",
	"O2TI_CheckoutIdentificationStep/js/action/create-account",
	"Magento_Checkout/js/model/quote",
	"Magento_Checkout/js/checkout-data",
	"Magento_Checkout/js/model/checkout-data-resolver",
	"Magento_Customer/js/customer-data",
	"O2TI_CheckoutIdentificationStep/js/model/create-account-messages",
	"mage/translate",
	"Magento_Checkout/js/model/full-screen-loader",
	"mage/validation"
], function(
	$,
	ko,
	_,
	Component,
	customer,
	createAccountAction,
	quote,
	checkoutData,
	checkoutDataResolver,
	customerData,
	createAccountMessageList,
	$t,
	fullScreenLoader
) {
	"use strict";
	
	return Component.extend({
		defaults: {
			formId: '#createAccount',
			formData: "createAccount"
		},

		/**
		 * Extends instance with defaults
		 */
		initialize: function () {
			this._super();
		},

		currentEmailIdentification() {
			return checkoutData.getValidatedEmailValue();
		},

		/**
		 * Initializes observable properties of instance
		 *
		 * @returns {Object} Chainable.
		 */
		initObservable() {
			this._super()
				.observe('disabled visible value');

			return this;
		},

		/**
		 * Text for Form Create Account
		 * 
		 * @returns string;
		 */
		textCreateAccount(){
			if(window.checkoutConfig.identificationConfig.isContiuneAsGuest){
				return $t('Create account or continue as guest');
			}
			return $t('Create account');
		},

		/**
		 * Change Email
		 */
		changeEmail(){
			checkoutData.setInputFieldEmailValue('');
			checkoutData.setCheckedEmailValue();
			checkoutData.setValidatedEmailValue();
			var loginFormSelector = "form[data-role=email-with-possible-login]",
				usernameSelector = loginFormSelector + " input[name=username]";
			$(usernameSelector).val('');
			$(usernameSelector).focus();
		},

		/**
		 * Is Remember Me Checkbox Visible
		 * 
		 * @returns {bool} isRememberMeCheckboxVisible.
		 */
		isRememberMeCheckboxVisible(){
			return window.checkoutConfig.persistenceConfig.isRememberMeCheckboxVisible;
		},

		/**
		 * Is Remember Me Checkbox Checked
		 * 
		 * @returns {bool} isRememberMeCheckboxChecked.
		 */
		isRememberMeCheckboxChecked(){
			if(window.checkoutConfig.persistenceConfig.isRememberMeCheckboxChecked){
				return 'checked';
			}
		},

		/**
		 * Form submit handler
		 *
		 * @param {HTMLElement} createAccount - form element.
		 */
		createAccount: function(createAccount) {
			var accountData = {},
                formDataArray = $(createAccount).serializeArray();

            this.source.set('params.invalid', false);
			this.source.trigger(this.dataScopePrefix + '.data.validate');

			if (this.source.get(this.dataScopePrefix + '.create_account')) {
				this.source.trigger(this.dataScopePrefix + '.create_account.data.validate');
			}

			if (!this.source.get('params.invalid')) {
				fullScreenLoader.startLoader();
				accountData = this.source.get(this.dataScopePrefix);
				formDataArray.forEach(function (entry) {
	                accountData[entry.name] = entry.value;
	            });
				accountData.email = this.currentEmailIdentification();
				console.log(accountData);
				createAccountAction(accountData).always(function () {
                    fullScreenLoader.stopLoader();
                });
			}
		}
	});
});
