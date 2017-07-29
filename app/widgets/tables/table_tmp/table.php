<div id="notesTable">
    <table class="table table-condensed notesTable">
        <thead>
        <tr>
            <th class="<?= $sort_classes['name']['class'] ?>"><a class="sort_link" href="<?= $sort_classes['name']['url'] ?>">Ім'я</a>
            </th>
            <th class="<?= $sort_classes['email']['class'] ?>"><a class="sort_link" href="<?= $sort_classes['email']['url'] ?>">E-mail</a>
            </th>
            <th>Сайт</th>
            <th>Повідомлення</th>
            <th class="<?= $sort_classes['created']['class'] ?>"><a class="sort_link"
                    href="<?= $sort_classes['created']['url'] ?>">Створено</a>
            </th>
            <?php if (!empty($admin)) { ?>
                <th>Дії</th>
            <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($notes)) {
            foreach ($notes as $note) { ?>
                <tr class="note-<?= $note->id ?>">
                    <td><?= $note->name ?></td>
                    <td><?= $note->email ?></td>
                    <td><?= $note->site ?></td>
                    <td class="message"><?= nl2br($note->message) ?></td>
                    <td><?= date('d.m.Y H:i', $note->created) ?></td>
                    <?php if (!empty($admin)) { ?>
                        <td>
                            <a href="/admin/notes/delete/<?= $note->id ?>"
                               data-title="Ви дійсно бажаєте видалити повідомлення?"
                               data-color_button="#ff5b57"
                               data-description="Після видалення повідомлення відновити буде не можливо!"
                               class="btn btn-danger btn-xs verifyRe">Видалити
                            </a>
                            <a href="#modal-edit" data-id="<?= $note->id ?>" data-toggle="modal"
                               class="btn btn-warning btn-xs">Редагувати</a>
                        </td>
                    <?php } ?>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="5" style="text-align: center">Не знайдено жодного запису..(</td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
    <?php if (!empty($notes_pages) && !empty($page)) { ?>
        <div style="display: flow-root">
            <div class="dataTables_paginate paging_simple_numbers m-25" id="data-table_paginate">
                <a href="<?= (!empty($sort) && !empty($direction)) ? "/?page=" . ($page - 1) . "&sort=$sort&direction=$direction" : "/?page=" . ($page - 1) ?>"
                   class="paginate_button sort_link previous <?= ($page == 1) ? 'disabled' : '' ?>"
                   id="data-table_previous">Назад</a>
                <span>
                                <?php for ($i = 1; $i <= $notes_pages; $i++) { ?>
                                    <a href="<?= (!empty($sort) && !empty($direction)) ? "/?page=$i&sort=$sort&direction=$direction" : "/?page=" . $i ?>"
                                       class="paginate_button sort_link <?= ($page == $i) ? 'current' : '' ?>"><?= $i ?></a>
                                <?php }
                                ?>
                             </span>
                <a href="<?= (!empty($sort) && !empty($direction)) ? "/?page=" . ($page + 1) . "&sort=$sort&direction=$direction" : "/?page=" . ($page + 1) ?>"
                   class="paginate_button sort_link next <?= ($page == $notes_pages) ? 'disabled' : '' ?>"
                   id="data-table_next">Вперед</a>
            </div>
        </div>
    <?php } ?>
</div>
