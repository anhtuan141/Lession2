<?php
class Controller
{
    /**
     * @return void
     */
    public function error404()
    {
        $this->render('view/system/404', [], 'emptylayout_404');
    }

    /**
     * @param $view
     * @param $data
     * @param $layout
     * @return void
     */
    public function render($view, $data = [], $layout = 'layout')
    {
        if (is_array($data)) {
            extract($data);
        }
        include 'view/' . $layout . '.php';
    }

    /**
     * @param $data
     * @return void
     */
    public function setError($data = [])
    {
        foreach ($data as $key => $value) {
            $_SESSION['_error_' . $key] = $value;
        }
    }

    /**
     * @param $key
     * @return mixed|string
     */
    public function getError($key)
    {
        $value = '';
        if (isset($_SESSION['_error_' . $key])) {
            $value = $_SESSION['_error_' . $key];
            unset($_SESSION['_error_' . $key]);
        }
        return $value;
    }

    /**
     * @param $data
     * @return void
     */
    public function setMessage($data = [])
    {
        foreach ($data as $key => $value) {
            $_SESSION['_message_' . $key] = $value;
        }
    }

    /**
     * @param $key
     * @return mixed|string
     */
    public function getMessage($key)
    {
        $value = '';
        if (isset($_SESSION['_message_' . $key])) {
            $value = $_SESSION['_message_' . $key];
            unset($_SESSION['_message_' . $key]);
        }
        return $value;
    }
}
