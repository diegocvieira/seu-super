// require('./bootstrap');

$(function() {
    $('body').css('opacity', '1');

    $('.mask-money').mask('000.000.000.000.000,00', {reverse: true});
    $('.mask-rg').mask('0000000000', { clearIfNotMatch: true });
    $('.mask-cep').mask('00000-000', { reverse: false, clearIfNotMatch: true });
    $('.mask-date').mask('00/00/0000', { clearIfNotMatch: true });
    $('.mask-cellphone').mask('(000) 0 0000-0000', { clearIfNotMatch: true });
    $('.mask-telephone').mask('(000) 0000-0000', { clearIfNotMatch: true });
    var options = {
        onKeyPress: function (cpf, ev, el, op) {
            var masks = ['000.000.000-000', '00.000.000/0000-00'];
            $('.mask-cpf-cnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
        }
    }
    $('.mask-cpf-cnpj').length > 11 ? $('.mask-cpf-cnpj').mask('00.000.000/0000-00', options) : $('.mask-cpf-cnpj').mask('000.000.000-00#', options);

    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });

    $.validator.setDefaults({
        ignore: []
    });

    $.datepicker.regional['pt-BR'] = {
        closeText: 'Fechar',
        prevText: 'Anterior',
        nextText: 'Próximo',
        currentText: 'Hoje',
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
        dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
    };
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

    // Modal close
    $(document).on('click', '.modal-close, .modal-background, .modal-btn-close', function() {
        $(this).parents('.modal').removeClass('is-active');
        $('html').removeClass('is-clipped');
    });

    // Open logged menu
    $(document).on('click', 'header .open-menu', function() {
        $('header').find('.dropdown').addClass('active');
    });

    // Close logged menu
    $(document).click(function(event) {
        const dropdown = $('header nav').find('.dropdown');

        if (!$(event.target).closest('nav .logged').length && dropdown.is(':visible')) {
            dropdown.removeClass('active');
        }
    });

    // Show market header
    $(window).scroll(function() {
        const header = $('header');

        if (!header.hasClass('header-scroll')) {
            return false;
        }

        if ($(window).scrollTop() > $('.market-header').height()) {
            header.removeClass('header-market-simple');
        } else {
            header.addClass('header-market-simple');
        }
    });

    // Form contact
    $('#form-contact').validate({
        rules: {
            email: {
                required: true,
                minlength: 1,
                email: true
            },
            name: {
                required: true,
                minlength: 1
            },
            message: {
                required: true,
                minlength: 1
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        errorPlacement: function(error, element) {
        },
        submitHandler: function(form) {
            $(form).find('button').text('ENVIANDO').attr('disabled', true);

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
                        $(form).find('input, textarea').val('');
                    }

                    $(form).find('button').text('ENVIAR').attr('disabled', false);

                    modalAlert(data.message);
                },
                error: function (request, status, error) {
                    $(form).find('button').text('ENVIAR').attr('disabled', false);

                    modalAlert(defaultErrorMessage());
                }
            });

            return false;
        }
    });

    // Form user register
    $('#form-user-register').validate({
        rules: {
            email: {
                required: true,
                minlength: 1,
                email: true
            },
            name: {
                required: true,
                minlength: 1
            },
            password: {
                required: true,
                minlength: 8
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        errorPlacement: function(error, element) {
        },
        submitHandler: function(form) {
            $(form).find('button').text('CADASTRANDO').attr('disabled', true);

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
                        $(form).find('button').text('CADASTRAR').attr('disabled', false);

                        modalAlert(data.message);
                    }
                },
                error: function (request, status, error) {
                    $(form).find('button').text('CADASTRAR').attr('disabled', false);

                    modalAlert(defaultErrorMessage());
                }
            });

            return false;
        }
    });

    // Form user login
    $('#form-user-login').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        errorPlacement: function(error, element) {
        },
        submitHandler: function(form) {
            $(form).find('button').text('ENTRANDO').attr('disabled', true);

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
                        $(form).find('button').text('ENTRAR').attr('disabled', false);

                        modalAlert(data.message);
                    }
                },
                error: function (request, status, error) {
                    $(form).find('button').text('ENTRAR').attr('disabled', false);

                    modalAlert(defaultErrorMessage());
                }
            });

            return false;
        }
    });

    // Form user config
    $('#form-user-config').validate({
        rules: {
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
            password_new: {
                minlength: 8
            },
            password_confirmation: {
                minlength: 8,
                equalTo: "#password-new"
            },
            email_current: {
                email: true
            },
            email_new: {
                email: true
            },
            email_confirmation: {
                email: true,
                equalTo: "#email-new"
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);

            if ($(element).hasClass('radio-field')) {
                $(element).next().addClass('error');
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);

            if ($(element).hasClass('radio-field')) {
                $(element).next().removeClass('error');
            }
        },
        errorPlacement: function(error, element) {
        },
        submitHandler: function(form) {
            $(form).find('button').text('SALVANDO').attr('disabled', true);

            $.ajax({
                url: $(form).attr('action'),
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: $(form).serialize(),
                success: function (data) {
                    $(form).find('button').text('SALVAR DADOS').attr('disabled', false);

                    modalAlert(data.message);
                },
                error: function (request, status, error) {
                    $(form).find('button').text('SALVAR DADOS').attr('disabled', false);

                    modalAlert(defaultErrorMessage());
                }
            });

            return false;
        }
    });

    $(document).on('click', '.open-modal-delete-account', function(event) {
        event.preventDefault();

        modalAlert('Informe a sua senha atual.');

        const url = $(this).attr('href'),
            modal = $('.modal-alert');

        modal.find('.modal-btn').before("<input type='password' placeholder='Digite sua senha' class='current-password' />");
        modal.find('.modal-btn').append("<button type='button' class='btn btn-send'>ENVIAR</button>");
        modal.find('.modal-btn-close').addClass('invert-color');

        modal.find('.btn-send').on('click', function() {
            const password = modal.find('.current-password').val();

            modal.find('.btn-send').text('ENVIANDO').attr('disabled', false);

            $.ajax({
                url: url,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: { password : password },
                success: function (data) {
                    if (data.success) {
                        window.location = data.route;
                    } else {
                        modalAlert('A senha atual não confere.');
                    }
                },
                error: function (request, status, error) {
                    modalAlert(defaultErrorMessage());
                }
            });
        });
    });

    // Open modals
    $(document).on('click', '.show-modal', function(event) {
        event.preventDefault();

        $('.modal.modal-' + $(this).data('type')).addClass('is-active');
        $('html').addClass('is-clipped');
    });

    // Tabs in modal rules
    $(document).on('click', '.modal-rules .navigation button', function() {
        const modal = $('.modal-rules');

        modal.find('.text, .navigation button').removeClass('active');

        $(this).addClass('active');
        modal.find('.text-' + $(this).data('type')).addClass('active');
    });

    $(document).on('click', '.department-filter', function(event) {
        const department = $(this).parents('.department');

        if (department.hasClass('active') || $(event.target).closest('.department-close').length) {
            return false;
        }

        department.addClass('active');
        department.find('.department-close, .categories').removeClass('is-hidden');
        $('.department').not(department).addClass('is-hidden');

        $('.form-department').val(department.attr('data-slug'));

        $('.form-search:first').submit();
    });

    $(document).on('click', '.department-close', function() {
        $('.department').removeClass('is-hidden active');
        $('.departments').find('.department-close, .categories, .subcategories').addClass('is-hidden');

        $('.form-department, .form-category, .form-subcategory').val('');

        $('.form-search:first').submit();
    });

    $(document).on('click', '.category-filter, .subcategory-filter', function() {
        const type = $(this).hasClass('category-filter') ? 'category' : 'subcategory',
            item = $(this).parents('.' + type),
            slug = item.attr('data-slug'),
            formValue = $('.form-' + type).val(),
            newFormValue = formValue ? formValue.split(',') : [];

        if (type == 'category') {
            item.find('.subcategories').toggleClass('is-hidden');
        }

        item.toggleClass('active');

        if (item.hasClass('active')) {
            newFormValue.push(slug);
        } else {
            const index = newFormValue.indexOf(slug);

            if (index !== -1) {
                newFormValue.splice(index, 1);
            }
        }

        $('.form-' + type).val(newFormValue);

        $('.form-search:first').submit();
    });

    $(document).on('submit', '.form-search', function() {
        $.ajax({
            url: $(this).attr('action'),
            method: 'GET',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                $('.products-json').html(data.body);

                window.document.title = data.headerTitle;
                window.history.pushState(null, data.headerTitle, data.headerUrl);
            },
            error: function (request, status, error) {
                modalAlert(defaultErrorMessage());
            }
        });

        return false;
    });

    $(document).on('mouseover', '#image-destaque', function() {
        $(this).children('#photo-zoom').css('transform', 'scale(1.5)');
    });
    $(document).on('mouseout', '#image-destaque', function() {
        $(this).children('#photo-zoom').css('transform', 'scale(1)');
    });
    $(document).on('mousemove', '#image-destaque', function(e) {
        $(this).children('#photo-zoom').css('transform-origin', ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 + '%');
    });
    $(document).on('click', '.image-thumb', function() {
        $('#image-destaque').find('#photo-zoom').attr('src', $(this).attr('src'));
    });

    // Get CEP
    $(document).on('blur', '#cep', function() {
        const cep = this.value.replace(/\D/g,''),
            url = "https://viacep.com.br/ws/" + cep + "/json/";

        if (cep.length != 8) {
            modalAlert('Não identificamos o CEP que você informou, verifique se digitou corretamente.');

            return false;
        }

        $.getJSON(url, function(data) {
            if (data.erro == true) {
                $('#street').val('');
                $('#city').val('');
                $('#state').val('');

                modalAlert('Não identificamos o CEP que você informou, verifique se digitou corretamente.');
            } else {
                $('#street').val(data.logradouro);
                $('#city').val(data.localidade);
                $('#state').val(data.uf);

                $("#number").focus();
            }
        }).fail(function() {
            modalAlert('Houve um erro ao identificar o seu CEP.');

            return false;
        });
    });
    $(document).on('keyup', '#cep', function() {
        if (this.value.length == 9) {
            $('#cep').trigger('blur');
        }
    });
});

function defaultErrorMessage() {
    return 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.';
}

function modalAlert(body, btn = 'FECHAR') {
    $('.modal-alert').remove();
    $('html').addClass('is-clipped');

    $('body').append(
        "<div class='modal modal-alert is-active'>" +
            "<div class='modal-background'></div>" +
            "<div class='modal-content'>" +
                "<div class='box'>" +
                    body +
                    "<div class='modal-btn'>" +
                        "<button class='btn modal-btn-close'>" + btn + "</button>" +
                    "</div>" +
                "</div>" +
            "</div>" +
            "<button class='modal-close is-large' aria-label='close'></button>" +
        "</div>"
    );
}

function number_format(numero, decimal, decimal_separador, milhar_separador) {
    numero = (numero + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+numero) ? 0 : +numero,
        prec = !isFinite(+decimal) ? 0 : Math.abs(decimal),
        sep = (typeof milhar_separador === 'undefined') ? ',' : milhar_separador,
        dec = (typeof decimal_separador === 'undefined') ? '.' : decimal_separador,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };

    // Fix para IE: parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if(s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }

    return s.join(dec);
}

function formatDolarToReal(value) {
    return number_format(value, 2, ',', '.');
}

function formatRealToDolar(value) {
    return number_format(value.replace('.', '').replace(',', '.'), 2, '.', '');
}
