<?php
class Product extends QueryBuilder
{
    /**
     * @param $table
     */
    public function __construct($table = '')
    {
        parent::__construct($table);
        $this->table = 'products';
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function getProduct($id)
    {
        return $this->item(['id' => $id]);
    }

    /**
     * @param $searchKey
     * @param $paging
     * @return array|false|void
     */
    public function searchProduct($searchKey = null, $paging = [])
    {
        $bindParams = [];
        $sql = "
            SELECT 
            `products`.`id` as 'id',
            `products`.`name` as 'prod_name',
            `categories`.`name` as 'cate_name',
            `products`.`image` as 'image'
            FROM `products` 
            JOIN `categories` ON `products`.`category_id`=`categories`.`id`
            WHERE `products`.status != -1";

        if ($searchKey) {
            $sql .= " AND (`products`.`name` LIKE ? OR `categories`.`name` LIKE ?)";
            $bindParams[] = "%" . $searchKey . "%";
            $bindParams[] = "%" . $searchKey . "%";
        }

        if ($paging) {
            $this->paginate($paging['limit'], $paging['offset']);
        }
        return $this->setQuery($sql)->rows($bindParams);
    }

    /**
     * @return false|float
     */
    public function getTotalPage()
    {
        $result = (array)$this->totalPages();
        $number = 0;

        if ($result != null && count($result) > 0) {
            $number = $result['number'];
        }

        return ceil($number / TOTAL_ITEM_IN_PAGE);
    }

    /**
     * @param $page
     * @return float|int
     */
    public function currentPage($page)
    {
        $currentPage = 1;
        if ($page) {
            $currentPage = $page;
        }
        return  ($currentPage - 1) * TOTAL_ITEM_IN_PAGE;
    }

    /**
     * @return mixed|void
     */
    private function totalPages()
    {
        $sql = "SELECT 
                COUNT(`products`.`id`) as 'number'
                FROM `products`";
        return $this->setQuery($sql)->row([]);
    }
}
