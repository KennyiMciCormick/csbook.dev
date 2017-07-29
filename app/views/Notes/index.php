<div class="search-banner has-bg">
    <div class="bg-cover" style="background-image: url('/assets/img/cover.jpg'); background-position: center;">
    </div>
    <div class="container">
        <h1>Книга скарг і пропозицій</h1>
    </div>
</div>
<?php if(!empty($admin)){?>
    <div class="modal fade" id="modal-edit" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Редагувати повідомлення</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal m-10" action="/" method="post" id="editForm">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Повідомлення*</label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="edit-msg" name="message" rows="5"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Відмінити</a>
                    <button type="submit" form="editForm" href="javascript:;" class="btn btn-sm btn-warning">Редагувати</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="content">
    <div class="container">
        <div class="panel panel-forum">
            <div class="panel-heading">
                <h4 class="panel-title">Скарги і пропозиції</h4>
            </div>
            <div class="cl-sx-12" id="notesTableCover">
                <?= $table ?>
            </div>
        </div>

        <div class="panel panel-forum">
            <div class="panel-heading">
                <h4 class="panel-title">Добавити скаргу/пропозицію</h4>
            </div>
            <?= (!empty($error)) ? "<p>$error</p>" : '' ?>

            <form class="form-horizontal m-10" action="javascript:;" method="post" id="sendNoticeForm">
                <div class="form-group">
                    <label class="col-md-3 control-label">Ім'я*</label>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">E-mail*</label>
                    <div class="col-md-6">
                        <input type="text" name="email" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Сайт</label>
                    <div class="col-md-6">
                        <input type="text" name="site" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Повідомлення*</label>
                    <div class="col-md-6">
                        <textarea class="form-control" name="message" rows="5"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Captcha*</label>
                    <div class="col-md-6">
                        <?= $captcha ?>
                        <input name="CaptchaCode" id="CaptchaCode" type="text"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-sm btn-success">Відправити</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
