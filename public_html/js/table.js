var table = {
    init: function () {
        this.events();
    },
    scrollTo: function (scroll_el) {
        if ($(scroll_el).length != 0) {
            $('html, body').animate({ scrollTop: $(scroll_el).offset().top - 100 }, 500); // анимируем скроолинг к элементу scroll_el
        }
    },
    updateTable: function (query) {
        if(!query || query == 'undefined'){
            query = '';
        }
        this.scrollTo('.content');
        var destination = $('.content').offset().top;
        if ($.browser.safari) {
            $('body').animate({ scrollTop: destination }, 1100); //1100 - скорость
        } else {
            $('html').animate({ scrollTop: destination }, 1100);
        }
        $('#notesTableCover').addClass('updatingTable');
        $.ajax({
            type: "GET",
            url: '/notes/updateTable' + query,
            success: function (response) {
                if (response) {
                    $('#notesTable').remove();
                    $('#notesTableCover').append(response).removeClass('updatingTable');
                } else {
                    alert('ERROR');
                }
            }
        });
    },
    events: function () {
        var self = this;
        $(document).on('click', '.sort_link', function (event) {
            event.preventDefault();
            var href = $(this).attr('href');
            history.pushState('', '', href);
            self.updateTable(href.substr(1));
        });


        $("#sendNoticeForm").validate({
            validClass: "success-validate",
            errorClass: "error-validate",
            errorElement: "div",
            errorPlacement: function (error, element) {
                return false;
            },
            rules: {
                name: {
                    required: true,
                    minlength: 2,
                    maxlength: 40
                },
                email: {
                    required: true,
                    fullEmail: true,
                    maxlength: 40
                },
                message: {
                    required: true,
                    minlength: 2
                },
                site: {
                    maxlength: 200
                },
                CaptchaCode: {
                    required: true
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: '/',
                    data: $(form).serialize(),
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response.error != false) {
                            swal(response.error, '', "error");
                            Captcha.ReloadImage();
                        } else {
                            var loc = location.href;
                            self.updateTable('?' + loc.split('?')[1]);
                            $(form)[0].reset();
                            Captcha.ReloadImage();

                        }
                    }
                });
                return false;
            }
        });
    }
};
