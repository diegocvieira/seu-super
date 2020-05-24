$(function() {
    // Add product to cart
    $(document).on('click', '.add-product-cart-specific-qtd, .add-product-cart .add, .add-product-cart .remove', function () {
        var product = $(this).parents('.product'),
            productId = product.attr('data-productId'),
            productCart = $('.cart').find('.product[data-productId=' + productId + ']'),
            productPrice = product.attr('data-productPrice'),
            productName = product.attr('data-productName'),
            productLink = product.attr('data-productLink'),
            productImage = product.attr('data-productImage'),
            qtdInput = $('.product[data-productId=' + productId + ']').find('.qtd'),
            qtdVal = parseInt(qtdInput.val());

        if (isNaN(qtdVal)) {
            qtdVal = 0;
        }

        if ($(this).hasClass('add')) {
            qtdVal += 1;
        } else if ($(this).hasClass('remove') && qtdVal >= 1) {
            qtdVal -= 1;
        }

        qtdInput.val(qtdVal);
        qtdVal > 0 ? qtdInput.addClass('fill') : qtdInput.removeClass('fill');

        if (productCart.length) {
            qtdVal > 0 ? productCart.find('.qtd').val(qtdVal) : productCart.remove();

            if (!$('.cart').find('.product').length) {
                $('.cart').find('.empty-cart').removeClass('is-hidden');
                $('.cart').find('.cart-finish, .cart-clear').addClass('is-hidden');
            }
        } else if (qtdVal > 0) {
            $('.cart').find('.empty-cart').addClass('is-hidden');
            $('.cart').find('.cart-finish, .cart-clear').removeClass('is-hidden');

            $('.cart').find('.list-products').append(
                "<div class='product' data-productId='" + productId + "' data-productPrice='" + productPrice + "'> " +
                    "<a href='" + productLink + "' target='_blank'>" +
                        "<img src='" + productImage + "' class='image' alt='" + productName + "'>" +

                        "<h4 class='price' data-price='" + productPrice + "'>R$" + number_format(productPrice * qtdVal, 2, ',', '.') + "</h4>" +

                        "<h3 class='name'>" + productName + "</h3>" +
                    "</a>" +

                    "<div class='add-product-cart'>" +
                        "<button class='remove'>-</button>" +
                        "<input type='text' class='qtd mask-number fill' value='" + qtdVal + "' autocomplete='off' readonly>" +
                        "<button class='add'>+</button>" +
                    "</div>" +

                    "<button class='open-description'></button>" +
                    "<div class='add-product-description'>" +
                        "<textarea placeholder='Deixe uma instrução para este item'></textarea>" +
                        "<button type='button' class='remove'>Apagar</button>" +
                        "<button type='button' class='save'>Salvar</button>" +
                    "</div>" +
                "</div>"
            );

            // productCart = $('.cart').find('.product[data-productId=' + productId + ']');
        }

        productCart.find('.price').text('R$' + formatDolarToReal(productPrice * qtdVal));

        let total = 0;
        $('.cart .product').each(function(index, element) {
            total += $(element).find('.price').attr('data-price') * $(element).find('.qtd').val();
        });

        $('.cart').find('.cart-finish .cart-total').text('R$' + formatDolarToReal(total));

        const pageFinish = $('.page-cart-finish');
        if (pageFinish.length) {
            let separation = parseFloat(formatRealToDolar(pageFinish.find('.separation-price').text().replace('R$', '')));

            pageFinish.find('.subtotal-price').text('R$' + formatDolarToReal(total));
            pageFinish.find('.total-price').text('R$' + formatDolarToReal(total + separation));
        }

        $.ajax({
            url: '/carrinho/produto/adicionar',
            method: 'POST',
            dataType: 'json',
            data: {
                productId: productId,
                qtdVal: qtdVal
            },
            success: function(data) {
                console.log(data);
            }
        });
    });

    // Clear cart
    $(document).on('click', '.cart .cart-clear', function() {
        const cart = $('.cart');

        cart.find('.empty-cart').removeClass('is-hidden');
        cart.find('.cart-finish, .cart-clear').addClass('is-hidden');
        cart.find('.list-products').html('');
        $('.add-product-cart').find('.qtd').val('0').removeClass('fill');

        $.ajax({
            url: $(this).data('route'),
            method: 'POST',
            dataType: 'json',
            success: function(data) {

            },
            error: function (request, status, error) {
                modalAlert(defaultErrorMessage());
            }
        });
    });

    // Open input message in product cart
    $(document).on('click', '.cart .open-description', function() {
        $(this).next().slideToggle('fast').find('textarea').focus();
    });

    // Save input message in product cart
    $(document).on('click', '.add-product-description .save, .add-product-description .remove', function() {
        const productId = $(this).parents('.product').attr('data-productId'),
            productCart = $('.cart').find('.product[data-productId=' + productId + ']'),
            textarea = productCart.find('.add-product-description textarea');

        if ($(this).hasClass('save')) {
            var message = textarea.val();
        } else {
            var message = null;

            textarea.val('');
        }

        $.ajax({
            url: '/carrinho/produto/mensagem',
            method: 'POST',
            dataType: 'json',
            data: {
                productId: productId,
                message: message
            },
            success: function(data) {
                productCart.find('.open-description').trigger('click');
            },
            error: function (request, status, error) {
                modalAlert(defaultErrorMessage());
            }
        });
    });

    $(document).on('click', '.page-cart-finish .data .header-section', function() {
        $(this).parents('.section').toggleClass('section-open');

        $(this).next().slideToggle(500);
    });

    if ($('.page-cart-finish').length) {
        const unavailableDates = $('input[name=unavailable_dates').val().split(';');
    }

    $("#datepicker").datepicker({
        minDate: new Date(),
        beforeShowDay: function(date) {
            const string = $.datepicker.formatDate('yy-mm-dd', date);
            return [unavailableDates.indexOf(string) == -1];
        },
        onSelect: function(date) {
            $('#delivery_date').val(date);

            previewAndValidate($('#delivery_date'));
        }
    }).find('a.ui-state-active').removeClass('ui-state-active');

    $('#form-cart-finish').validate({
        rules: {
            name: {
                required: true,
                minlength: 1
            },
            email: {
                required: true,
                minlength: 1,
                email: true
            },
            gender: {
                required: true,
                minlength: 1
            },
            birthdate: {
                required: true,
                minlength: 1
            },
            cellphone: {
                required: true,
                minlength: 1
            },
            cpf_cnpj: {
                required: true,
                minlength: 1
            },
            rg: {
                required: true,
                minlength: 1
            },
            cep: {
                required: true,
                minlength: 1
            },
            street: {
                required: true,
                minlength: 1
            },
            number: {
                required: true,
                minlength: 1
            },
            district_id: {
                required: true,
                minlength: 1
            },
            delivery_date: {
                required: true,
                minlength: 1
            },
            delivery_hour: {
                required: true,
                minlength: 1
            },
            payment_money: {
                required: true
            },
            payment_debit: {
                required: true
            },
            payment_credit: {
                required: true
            }
        },
        highlight: function (element, errorClass, validClass) {
            // $(element).addClass(errorClass).removeClass(validClass);

            // if ($(element).hasClass('radio-field')) {
            //     $(element).next().addClass('error');
            // }
        },
        unhighlight: function (element, errorClass, validClass) {
            // $(element).removeClass(errorClass).addClass(validClass);

            // if ($(element).hasClass('radio-field')) {
            //     $(element).next().removeClass('error');
            // }
        },
        errorPlacement: function(error, element) {
        },
        submitHandler: function(form) {
            $(form).find('.btn-submit').text('Finalizando...').attr('disabled', true);

            $.ajax({
                url: $(form).attr('action'),
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: $(form).serialize(),
                success: function (data) {
                    if (data.success) {
                        window.location = data.route;
                    } else {
                        $(form).find('.btn-submit').text('Finalizar pedido').attr('disabled', false);

                        modalAlert(data.message);
                    }
                },
                error: function (request, status, error) {
                    $(form).find('.btn-submit').text('Finalizar pedido').attr('disabled', false);

                    modalAlert(defaultErrorMessage());
                }
            });

            return false;
        }
    });

    $(document).on('change', '#district', function() {
        $.ajax({
            url: '/pedidos/frete/calcular/' + $('input[name=market_id]').val() + '/' + $(this).val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    let subtotal = parseFloat(formatRealToDolar($('.subtotal-price').text().replace('R$', ''))),
                        separation = parseFloat(formatRealToDolar($('.separation-price').text().replace('R$', ''))),
                        freight = parseFloat(data.price),
                        total = subtotal + separation + freight;

                    $('.freight-price').text('R$' + formatDolarToReal(freight));
                    $('.total-price').text('R$' + formatDolarToReal(total));
                } else {
                    modalAlert(data.message);
                }
            },
            error: function (request, status, error) {
                modalAlert(defaultErrorMessage());
            }
        });
    });

    $(document).on('change blur', '.form-field', function() {
        previewAndValidate($(this));
    });
});

function previewAndValidate(element = null) {
    if ($(element).hasClass('payment-type')) {
        const id = $(element).attr('id');

        if (id == 'payment-type1') {
            $('#payment-money').prop('checked', true);
            $('.payment-type2, .payment-type3').find('select').val('');

            $('#payment-card-debit').rules('remove');
            $('#payment-card-credit').rules('remove');
        } else if (id == 'payment-type2') {
            $('#payment-money').prop('checked', false);
            $('.payment-type3').find('select').val('');

            $('#payment-card-debit').rules('add', {
                required: true
            });

            $('#payment-money').rules('remove');
            $('#payment-card-credit').rules('remove');
        } else {
            $('#payment-money').prop('checked', false);
            $('.payment-type2').find('select').val('');

            $('#payment-card-credit').rules('add', {
                required: true
            });

            $('#payment-money').rules('remove');
            $('#payment-card-debito').rules('remove');
        }

        $('.payment-type-field').addClass('is-hidden');
        $('.' + id).removeClass('is-hidden');
    }

    const section = $(element).parents('.section'),
        btnSubmit = $('#form-cart-finish').find('.btn-submit');
    let sectionValid = true;

    section.find('.form-field').each(function(index, element2) {
        if (!$(element2).valid()) {
            sectionValid = false;
        }
    });

    if (sectionValid) {
        if (section.hasClass('personal')) {
            const name = $('input[name=name]').val(),
                cellphone = $('input[name=cellphone]').val();
            var preview = name + ' - ' + cellphone;
        } else if (section.hasClass('address')) {
            const street = $('input[name=street]').val(),
                number = $('input[name=number]').val(),
                district = $('select[name=district_id]'),
                complement = $('input[name=complement]').val();
            var preview = street + ', ' + number + (complement ? ' - ' + complement : '') + ' - ' + district.find('option:selected').text();
        } else if (section.hasClass('delivery-date')) {
            const deliveryDate = $('input[name=delivery_date]').val(),
                weekDay = deliveryDate ? $.datepicker.formatDate('DD', $('#datepicker').datepicker('getDate')) : '',
                deliveryHour = $('input[name=delivery_hour]:checked').next().text();
            var preview = deliveryDate + ' - ' + weekDay + ' - ' + deliveryHour;
        } else if (section.hasClass('instructions')) {
            const instructions = $('textarea[name=instructions]').val();
            var preview = instructions ? instructions : 'Sem instruções para o entregador';
        } else if (section.hasClass('payment')) {
            const paymentType = $('input[name=payment_type]:checked');
            var preview = paymentType.next().text();

            if (paymentType.attr('id') != 'payment-type1') {
                var preview = preview + ' - ' + $('.' + paymentType.attr('id')).find('select option:selected').text();
            }
        }

        section.find('.preview').text(preview);
        section.addClass('section-validate');
    } else {
        section.find('.preview').text('');
        section.removeClass('section-validate');
    }

    if ($('#form-cart-finish').validate().checkForm()) {
        btnSubmit.prop('disabled', false);
    } else {
        btnSubmit.prop('disabled', true);
    }
}
