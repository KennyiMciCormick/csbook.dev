<?php

namespace app\widgets\tables;


class NotesTable
{
    /**
     * поточна таблиця
     * @var string
     */
    protected $model;
    /**
     * дата для обробки
     * @var array
     */
    protected $data;
    /**
     * чи залогінений адмін
     * @var boolean
     */
    protected $admin = false;
    /**
     * відрендерений html код таблиці
     * @var boolean
     */
    public $table_html;
    /**
     * шлях до шаблону таблиці
     * @var string
     */
    protected $tpl = __DIR__ . '/table_tmp/table.php';


    /**
     * перевіряє чи залогінений адмін, формує таблицю
     * @param array $data
     * @param string $model
     */
    public function __construct($data, $model)
    {
        if(isset($_SESSION['admin']) && $_SESSION['admin'] === true){
            $this->admin = true;
        }
        $this->data = $data;
        $this->model = $model;
        $this->run();
    }

    /**
     * дістає данні з моделі, формує таблицю і записує її в змінну $this->table_html
     */
    protected function run()
    {
        $sortingParams = $this->getSortingParams();
        $notes = $this->model->getNotes($sortingParams['page'], $sortingParams['sort'], $sortingParams['direction']);

        $this->table_html =  $this->toTemplate(['admin'=> $this->admin,'notes' => $notes['notes'], 'notes_pages' => $notes['notes_pages']] + $sortingParams);
    }

    /**
     * формує таблицю
     */
    protected function toTemplate($params){
        extract($params);
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }

    /**
     * Формує параметри для сортування
     */
    private function getSortingParams()
    {
        $sorted_names = ['name', 'email', 'created'];
        $direction_names = ['asc', 'desc'];
        $data = $this->data;
        $page = (!empty($data['page']) && is_numeric($data['page']) && intval($data['page']) > 0) ? $data['page'] : 1;
        $sort = (!empty($data['sort']) && in_array($data['sort'], $sorted_names)) ? $data['sort'] : '';
        $direction = (!empty($data['direction']) && in_array($data['direction'], $direction_names)) ? strtolower($data['direction']) : '';

        if (!empty($sort) && !empty($direction)) {
            $sort_classes = $this->getSortClasses($sorted_names, $sort, $direction);
        } else {
            $sort_classes = $this->getSortDefaultClasses();
        }
        return ['page' => $page, 'sort' => $sort, 'direction' => $direction, 'sort_classes' => $sort_classes];
    }

    /**
     * Формує дефолтні класи і url для сортувальних елементів
     * @return array
     */
    private function getSortDefaultClasses()
    {
        $sort_classes['name']['class'] = 'sorting';
        $sort_classes['name']['url'] = '/?sort=name&direction=desc';

        $sort_classes['email']['class'] = 'sorting';
        $sort_classes['email']['url'] = '/?sort=email&direction=desc';

        $sort_classes['created']['class'] = 'sorting_desc';
        $sort_classes['created']['url'] = '/?sort=created&direction=asc';
        return $sort_classes;
    }

    /**
     * Формує класи і url для сортувальних елементів за вхідними данними
     * @return array
     */
    private function getSortClasses($arr, $sort, $direction)
    {
        $result = [];
        foreach ($arr as $item) {
            if ($sort == $item) {
                if ($direction == 'asc') {
                    $result[$item]['class'] = 'sorting_asc';
                    $result[$item]['url'] = "/?sort=$item&direction=desc";
                } else if ($direction == 'desc') {
                    $result[$item]['class'] = 'sorting_desc';
                    $result[$item]['url'] = "/?sort=$item&direction=asc";
                } else {
                    $result[$item]['class'] = 'sorting';
                    $result[$item]['url'] = "/?sort=$item&direction=desc";
                }
            } else {
                $result[$item]['class'] = 'sorting';
                $result[$item]['url'] = "/?sort=$item&direction=desc";
            }
        }
        return $result;
    }
}