/**
 * Copyright © 2023 Lingaro sp. z o.o. All rights reserved.
 * See LICENSE for license details.
 */

define([
    'jquery',
    'mage/translate',
    'Magento_Customer/js/customer-data',
    'Magento_Ui/js/modal/alert'
], function ($, $t, customerData, alert) {
    'use strict';

    $.widget('lingaro.upsertQty',{

        _create: function () {
            var self = this;

            this.inputPattern = '[0-9,.]';
            this.addToCartButtonText = this.options.addToCartButtonText || $t('Add to Cart');
            this.updateCartButtonText = this.options.updateCartButtonText || $t('Update Cart');
            this.updateUrl = this.options.url;
            this.productType = this.options.productType;
            this.product = this.options.productId;
            this.sku = this.options.sku;
            this.input = this.createInput(this.product);
            this.buttons = this.createButtons();
            this.successBlockDuration = this.options.successBlockDuration || 2000;
            this.successBlock = this.createSuccessBlock();
            this.successBlockTimeout = null;
            this.element.append(this.buttons.subButton);
            this.element.append(this.input);
            this.element.append(this.buttons.addButton);
            this.element.append(this.buttons.toCartButton)
            this.element.append(this.successBlock);
            this.cart = customerData.get('cart');
            this.actualQuantity = 0;

            this.input.click(() => {
                this.input.select();
            });

            this.input.keypress((event) => {
                if (!String.fromCharCode(event.which).match(new RegExp(this.inputPattern))) {
                    return false;
                }
            });

            this.input.on('input', () => {
                this.updateCartButton(this.input.val());
            });

            this.input.change(() => {
                this.updateCartButton(this.input.val());
            });

            this.buttons.toCartButton.on('click', () => {
                this.fireUpdateQuantity();
            });

            this.setActualQuantity(this.cart(), this.product);
            this.cart.subscribe(function (cart) {
                self.setActualQuantity(cart, self.product);
            });

            $(document).on('ajax:removeFromCart', (event, data) => {
                if ($.inArray(this.product, data.productIds) != -1) {
                    this.actualQuantity = 0;
                    this.updateInputQty(0);
                    this.updateCartButton(0);
                }
            });
        },

        /**
         * @param qty
         */
        updateInputQty: function (qty) {
            this.input.val(qty);
        },

        /**
         * @param qty
         */
        updateCartButton: function (qty) {
            this.buttons.toCartButton.val(
                this.actualQuantity > 0 ? this.updateCartButtonText : this.addToCartButtonText
            );

            if (qty != this.actualQuantity) {
                this.buttons.toCartButton.prop('disabled', false);
            } else {
                this.buttons.toCartButton.prop('disabled', true);
            }
        },

        /**
         * @param product
         * @returns {*|n.fn.init|jQuery|HTMLElement}
         */
        createInput: function (product) {
            var input = $('<input>');
            input.attr({
                id: 'upsert-qty-' + product,
                type: 'number',
                name: 'qty',
                min: '0',
                value: '0',
                class: 'input-text qty',
                'data-validate': ''
            });
            return input;
        },

        /**
         * @return {object}
         */
        createButtons: function () {
            var self = this;
            var addButton = $('<input type="button" name="add-button" class="qty-input-button" value="+">');
            var subButton = $('<input type="button" name="sub-button" class="qty-input-button" value="-">');
            var toCartButton = $('<input type="button" disabled="disabled" class="action to-cart-button primary" value="' + this.addToCartButtonText + '">');

            var setNewValue = type => {
                var currentValue = parseInt(self.input.val(), 10),
                    newValue;

                if (type === 'add') {
                    newValue = currentValue + 1;
                } else {
                    newValue = currentValue - 1;
                }

                if (newValue !== currentValue && newValue > -1) {
                    self.updateInputQty(newValue);
                    self.updateCartButton(newValue);
                }
            };

            addButton.click(setNewValue.bind(this, 'add'));
            subButton.click(setNewValue.bind(this, 'sub'));

            return { addButton, subButton, toCartButton };
        },

        /**
         * @return {object}
         */
        createSuccessBlock: function () {
            var block = $('<div>');
            block.addClass('lingaro-upsert-qty-success');
            block.text($t('Cart updated successfully!'));

            return block;
        },

        /**
         * @param cart
         * @param productId
         */
        setActualQuantity: function (cart, productId) {
            $.each(cart.items, (index, item) => {
                if (item.product_id == productId) {
                    this.actualQuantity = item.qty;
                    this.updateInputQty(item.qty);
                    this.updateCartButton(item.qty);
                    return false;
                }
            });
            this.input.prop('disabled', false);
        },

        fireUpdateQuantity: function () {
            if (this.input.val().length > 0) {
                this.updateQuantity();
            }
        },

        updateQuantity: function () {
            this.input.prop('disabled', true);
            this.buttons.addButton.prop('disabled', true);
            this.buttons.subButton.prop('disabled', true);
            this.buttons.toCartButton.prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: this.updateUrl,
                data: {
                    'ajax': true,
                    'product': this.product,
                    'qty': this.input.val(),
                    'form_key': $.mage.cookies.get('form_key')
                }
            })
            .done(this.onUpdateDone.bind(this))
            .always(this.onUpdateAlways.bind(this));
        },

        onUpdateDone: function (response) {
            var self = this;

            if (response.success === false) {
                this.updateInputQty(this.actualQuantity);
                alert({
                    title: $t('An error occurred'),
                    content: response.message,
                    actions: {
                        always: function () {}
                    }
                });
            } else {
                customerData.reload(['cart'], true);
                this.actualQuantity = this.input.val();

                this.updateCartButton(this.input.val());

                if (this.successBlockTimeout) {
                    clearTimeout(this.successBlockTimeout);
                }
                this.successBlock.addClass('active');
                this.successBlockTimeout = setTimeout(function () {
                    self.successBlock.removeClass('active');
                }, this.successBlockDuration);
            }
        },

        onUpdateAlways: function () {
            this.input.prop('disabled', false);
            this.buttons.addButton.prop('disabled', false);
            this.buttons.subButton.prop('disabled', false);
        }
    });

    return $.lingaro.upsertQty;
});
