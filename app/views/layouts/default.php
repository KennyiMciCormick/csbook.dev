<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>Книга скарг і пропозицій</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/assets/css/animate.min.css" rel="stylesheet"/>
    <link href="/assets/css/style.min.css" rel="stylesheet"/>
    <link href="/botdetect/public/bdc-layout-stylesheet.css" rel="stylesheet"/>
    <link href="/assets/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="/assets/css/theme/default.css" id="theme" rel="stylesheet"/>
    <link href="/assets/plugins/DataTables/css/data-table.css" id="theme" rel="stylesheet"/>
    <!-- ================== END BASE CSS STYLE ================== -->
    <?php if (!empty($admin)) { ?>
        <link href="/bower_components/sweetalert/dist/sweetalert.css" rel="stylesheet">
    <?php } ?>
    <style>
        .updatingTable {
            background-image: url(/assets/img/spinner.gif);
            background-position: center;
            opacity: 0.3;
        }
    </style>

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="/assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body>
<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">
                <img src="/assets/img/icom.jpg" width="30px" height="30px" alt="">
            </a>
        </div>
        <?php if (!empty($admin)) { ?>
            <div class="collapse navbar-collapse" id="header-navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/admin/logout">Вийти</a></li>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>

<?= $content ?>

<div id="footer-copyright" class="footer-copyright">
    <div class="container">
        &copy; 2014 - 2017
    </div>
</div>


<!-- ================== BEGIN BASE JS ================== -->
<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="/assets/js/apps.min.js"></script>

<!-- ================== END BASE JS ================== -->
<script src="/assets/js/jquery.validate.js"></script>

<script>
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
            this.scrollTo('.content');
            var destination = $('.content').offset().top;
            console.log(destination);
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

    $(document).ready(function () {
        App.init();
        jQuery.validator.addMethod("fullEmail", function (value, element) {
            return this.optional(element) || /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
        }, 'Please enter a valid email address.');
        table.init();
    });


</script>

<?php if (!empty($admin)) { ?>
    <script src="/bower_components/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $('.verifyRe').click(function (event) {
            event.preventDefault();
            var t = $(this);
            var href = t.attr('href');
            swal({
                title: t.data('title'),
                text: t.data('description'),
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonColor: t.data('color_button'),
                confirmButtonText: "Так",
                cancelButtonColor: "#b6c2c9",
                cancelButtonText: "Відмінити"
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: href,
                        success: function (response) {
                            console.log(response);
                            if (response) {
                                t.closest('tr').remove();
                                swal('Видалено!');
                            } else {
                                alert('ERROR');
                            }
                        }
                    });
                }
            });
        });

        $('#modal-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var msg = button.closest('tr').find('.message').text();
            var id = button.data('id');
            console.log(msg);
            console.log(id);
            var modal = $(this);
            modal.find('#edit-msg').val(msg);
            modal.find('#edit-id').val(id);
        });

        $("#editForm").validate({
            validClass: "success-validate",
            errorClass: "error-validate",
            errorElement: "div",
            errorPlacement: function (error, element) {
                return false;
            },
            rules: {
                message: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function (form) {
//                form.submit();
                var em = $('#edit-msg');
                var ei = $('#edit-id');
                var msg = em.val();
                em.val('');
                var id = ei.val();
                ei.val('');
                $.ajax({
                    type: "POST",
                    url: '/admin/notes/edit/' + id,
                    data: {msg: msg},
                    success: function (response) {
                        if (response) {
                            $('.notesTable .note-' + id + ' .message').html(response);
                        } else {
                            alert('ERROR');
                        }
                        $('#modal-edit').modal('hide');
                    }
                });
                return false;
            }
        });
    </script>
<?php } ?>
</body>
</html>