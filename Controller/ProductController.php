<?php

class ProductController extends Controller
{
    /**
     * Product index page
     * @return void
     */
    public function index()
    {
        $productModel = new Product();

        //Paginate
        $pages = $productModel->getTotalPage();
        $currentPage = $productModel->currentPage(get('page'));

        $list = $productModel->searchProduct(null, [
            'limit' => TOTAL_ITEM_IN_PAGE,
            'offset' => $currentPage
        ]);

        $this->render(
            'view/product/index', [
            'list' => $list,
            'pages' => $pages
        ]);
    }

    /**
     * Create product page
     * @return void
     */
    public function create()
    {
        $categoryModel = new Category();
        $listCate = $categoryModel->listCategory();
        $this->render('view/product/create', [
            'listCate' => $listCate
        ]);
    }

    /**
     * Store data to database
     * @return void
     */
    public function insert()
    {
        $name = post('name');
        $cate = post('category');
        $image = myUpload($_FILES['image'], 'public/uploads/products');
        $productModel = new Product();

        if (!$name) {
            $this->setError([
                'name' => 'Name of a product is required'
            ]);
            changePage(href('product', 'create'));
        }

        $result = $productModel->insert([
            'name' => $name,
            'category_id' => $cate,
            'image' => $image,
            'status' => 1
        ]);

        if ($result) {
            $this->setMessage(createSuccess($name));
        } else {
            $this->setMessage(createFail($name));
        }
        changePage(href('product', 'index'));
    }

    /**
     * Edit page of a product
     * @return void
     */
    public function editList()
    {
        list($prod, $listCate) = $this->getProductInfo();
        $this->render('view/product/edit', ['prod' => $prod, 'listCate' => $listCate]);
    }

    /**
     * Update a product in database
     * @return void
     */
    public function updateList()
    {
        //Check ID URL
        $id = get('id');
        $prodId = post('prod_id');
        if (!$prodId) {
            changePage(href('product', 'index'));
        }

        $image = myUpload($_FILES['image'], 'public/uploads/products');
        $productModel = new Product();
        $prod = $productModel->getProduct($id);

        $result = $productModel->update([
            'name' => post('name') ? trim(post('name')) : $prod->name,
            'image' => $image ?: $prod->image,
            'category_id' => post('category') ? trim(post('category')) : $prod->category_id,
        ], ['id' => $prodId]);

        if ($result) {
            $this->setError(updateSuccess($prodId));
        } else {
            $this->setError(updateFail($prodId));
        }
        changePage(href('product', 'editList', ['id' => $prodId]));
    }

    /**
     * Copy page
     * @return void
     */
    public function copy()
    {
        list($prod, $listCate) = $this->getProductInfo();
        $this->render('view/product/copy', ['prod' => $prod, 'listCate' => $listCate]);
    }

    /**
     * Clone a product and insert to database
     * @return void
     */
    public function copyInsert()
    {
        $prodId = post('prod_id');
        if (!$prodId) {
            changePage(href('product', 'index'));
        }

        $productModel = new Product();
        $name = post('name');
        $cate = post('category');
        $image = post('image');

        $result = $productModel->insert([
            'name' => $name,
            'category_id' => $cate,
            'image' => $image,
            'status' => 1
        ]);

        if ($result) {
            $this->setError(copySuccess($prodId));
        } else {
            $this->setError(copyFail($prodId));
        }
        changePage(href('product', 'index', ['id' => $prodId]));
    }

    /**
     * Detail page
     * @return void
     */
    public function detail()
    {
        list($prod, $listCate) = $this->getProductInfo();
        $this->render('view/product/detail', ['prod' => $prod, 'listCate' => $listCate]);
    }

    /**
     * Search page
     * @return void
     */
    public function search()
    {
        $productModel = new Product();
        $listProduct = $productModel->searchProduct(post('search'));

        $this->render('view/product/search', [
            'listProduct' => $listProduct,
        ]);
    }

    /**
     * Get product and category info
     * @return array
     */
    private function getProductInfo()
    {
        $id = get('id');
        if (!$id) {
            changePage(href('product', 'index'));
        }

        //Check Product
        $productModel = new Product();
        $prod = $productModel->getProduct($id);
        if (!$prod) {
            changePage(href('product', 'index'));
        }

        $categoryModel = new Category();
        $listCate = $categoryModel->listCategory();
        return [
            $prod,
            $listCate
        ];
    }
}
