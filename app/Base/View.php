<?php

class View
{
    /**
     * Return view
     *
     * @param $view
     * @param array $params
     * @return null|string
     * @throws Exception
     */
    public static function make($view, $params = [])
    {
        $view = str_replace('.', '/', $view);
        $filePath = VIEWS_PATH . $view . '.view.php';
        if (file_exists($filePath)) {
            try {
                ob_start();
                extract($params);
                include($filePath);
                return ob_get_clean();
            } catch (Exception $e) {
                //
            }
        }

        throw new Exception("View not found");
    }
}
