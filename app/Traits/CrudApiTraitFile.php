<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\File;

trait CrudApiTraitFile
{

    public static function get(array $filters = [])
    {
        $new_filters = [];
        foreach ($filters as $key => $value) {
            if (!empty($value)) {
                $new_filters["?$key"] = $value;
            }
        }
        $data = parent::$API->comm(parent::$command . "print", $new_filters);
        parent::cek_error($data);
        if (parent::$cache) {
            $cache = static::to_cache($data);
        }
        return $data;
    }

    public static function show(string $id)
    {
        $data = parent::$API->comm(parent::$command . "print", [
            '?.id' => $id
        ]);
        parent::cek_error($data);
        if (empty($data)) {
            throw new Exception('Data Not Found!');
        }
        return $data[0];
    }

    public static function store(array $param)
    {
        $id = parent::$API->comm(parent::$command . "add", $param);
        parent::cek_error($id);
        if (parent::$cache) {
            $data = static::show($id);
            $cache = static::store_item_to_cache($data);
        }
        return $id;
    }

    public static function update(string $id, array $param)
    {
        $new_param = array_merge(['.id' => $id], $param);
        $response = parent::$API->comm(parent::$command . "set", $new_param);
        parent::cek_error($response);
        if (parent::$cache) {
            $data = static::show($id);
            $cache = static::update_item_to_cache($id, $data);
        }
        return $response;
    }

    public static function destroy(array $id = [])
    {
        $data = parent::$API->comm(parent::$command . "remove", [
            '.id' => implode(',', $id)
        ]);
        parent::cek_error($data);
        if (parent::$cache) {
            $cache = static::remove_from_cache($id);
        }
        return $data;
    }

    public static function from_cache($filters = [])
    {
        $file = parent::$path . '/' . parent::$router->id . '.json';
        if (!file_exists($file)) {
            $data = static::get($filters);
        } else {
            $file = file_get_contents($file);
            $data = json_decode($file, true);
        }
        return $data;
    }

    public static function to_cache($data)
    {
        if (!File::exists(parent::$path)) {
            File::makeDirectory(parent::$path, 755, true);
        }
        File::put(parent::$path . '/' . parent::$router->id . '.json', json_encode($data, JSON_PRETTY_PRINT));
        return new static;
    }

    public static function cache(bool $cache = false)
    {
        parent::$cache = $cache;
        return new static;
    }

    public static function remove_from_cache(array $ids)
    {
        $data = collect(static::from_cache());
        $data = $data->reject(function ($item) use ($ids) {
            return isset($item['.id']) && in_array($item['.id'], $ids);
        });
        static::to_cache($data->values()->toArray());
    }

    public static function store_item_to_cache($new_data)
    {
        $data = collect(static::from_cache());
        $data->push($new_data);
        static::to_cache($data->values()->toArray());
    }

    public static function update_item_to_cache($id, $new_data)
    {
        $data = collect(static::from_cache());
        $data = $data->map(function ($item) use ($id, $new_data) {
            if (isset($item['.id']) && $item['.id'] === $id) {
                return $new_data;
            }
            return $item;
        });
        static::to_cache($data->values()->toArray());
    }
}
