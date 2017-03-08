<?php

namespace App\Base;

class Model
{
    /**
     * @return array
     */
    public static function all()
    {
        $model = new static();
        $data = null;

        if (file_exists($model->getPath())) {
            $jsonData = file_get_contents($model->getPath());
            $data = json_decode($jsonData, true);
        }

        $items = [];

        foreach ($data as $obj) {
            $item = new static();
            foreach ($obj as $key => $value) {
                $item->$key = $value;
            }
            $items[] = $item;
        }

        return $items;
    }

    /**
     * @param $column
     * @param $val
     * @return mixed|null
     */
    public static function findBy(string $column, $val)
    {
        $model = new static();
        $data = null;

        if (file_exists($model->getPath())) {
            $jsonData = file_get_contents($model->getPath());
            $data = json_decode($jsonData, true);
        }

        $find = false;

        foreach ($data as $obj) {
            $item = new static();
            foreach ($obj as $key => $value) {
                if ($key == $column && $value == $val) {
                    $find = true;
                }
                $item->$key = $value;
            }

            if ($find) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param string $email
     * @param array $attributes
     * @return bool
     */
    public static function update(string $email, array $attributes = [])
    {
        $model = new static();
        $data = null;
        $current = null;
        $items = [];

        if (file_exists($model->getPath())) {
            $jsonData = file_get_contents($model->getPath());
            $data = json_decode($jsonData, true);
        }

        $find = false;

        foreach ($data as $obj) {
            $item = new static();
            foreach ($obj as $key => $value) {
                if ($value == $email && $key == 'email') {
                    $find = true;
                }
                $item->$key = $value;
            }

            if ($find) {
                $find = false;
                foreach ($item as $subKey => $subItem) {
                    if (is_array($subItem)) {
                        $item->{$subKey} = [];
                        foreach ($attributes[$subKey] as $value) {
                            array_push($item->{$subKey}, $value);
                        }
                    } else {
                        if (array_key_exists($subKey, $attributes)) {
                            $item->{$subKey} = $attributes[$subKey];
                        }
                    }
                }
                $items[] = $item;
            } else {
                $items[] = $item;
            }
        }

        if (count($items)) {
            //delete file content
            file_put_contents($model->getPath(), '');

            //save
            file_put_contents($model->getPath(), json_encode($items));

            return true;
        }

        return false;
    }

    /**
     * @param $email
     * @return bool
     */
    public static function delete($email)
    {
        $model = new static();
        $data = null;

        if (file_exists($model->getPath())) {
            $jsonData = file_get_contents($model->getPath());
            $data = json_decode($jsonData, true);
        }

        $find = false;
        $items = [];

        foreach ($data as $obj) {
            $item = new static();
            foreach ($obj as $key => $value) {
                if ($key == 'email' && $value == $email) {
                    $find = true;
                }
                $item->$key = $value;
            }
            if ($find) {
                $find = false;
                continue;
            }
            $items[] = $item;
        }

        //delete file content
        file_put_contents($model->getPath(), '');

        //save
        file_put_contents($model->getPath(), json_encode($items));

        return true;
    }

    /**
     * Save data into JSON file
     *
     * @param array $options
     * @return mixed
     */
    public static function save(array $options = [])
    {
        $model = new static();
        $data = null;

        if (file_exists($model->getPath())) {
            $jsonData = file_get_contents($model->getPath());
            $data = json_decode($jsonData, true);
        }

        array_push($data, $options);

        //delete file content
        file_put_contents($model->getPath(), '');

        //save
        file_put_contents($model->getPath(), json_encode($data));

        return true;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->json_path;
    }
}
