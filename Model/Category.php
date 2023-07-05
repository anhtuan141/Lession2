<?php
class Category extends QueryBuilder
{
    /**
     * @param $table
     */
    public function __construct($table = '')
    {
        parent::__construct($table);
        $this->table = 'categories';
    }

    /**
     * @return array|false|void
     */
    public function listCategory()
    {
        return $this->select(['status', '!=', -1]);
    }

    /**
     * @param $searchKey
     * @return array|false|void
     */
    public function searchCategory($searchKey)
    {
        $bindParams = [];
        $sql = "
            SELECT 
            `categories`.`id` as 'id',
            `products`.`name` as 'prod_name',
            `categories`.`name` as 'cate_name',
            `products`.`image` as 'image'
            FROM `categories` 
            JOIN `products` ON `categories`.`id` = `products`.`category_id`
            WHERE ";

        if ($searchKey) {
            $sql .= " AND `categories`.`name` LIKE ?";
            $bindParams[] = "%" . $searchKey . "%";
        }

        return $this->setQuery($sql)->rows([$bindParams]);
    }
}
