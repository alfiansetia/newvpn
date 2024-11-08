<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\File;
use RouterOS\Query;

trait MikrotikApiCrudTrait
{
    public static function get(array $filters = [])
    {
        if (empty(static::$router)) {
            throw new Exception('Router Not Found!');
        }
        $response = parent::$client;
        $query = (new Query(parent::$command . 'print'));
        foreach ($filters ?? [] as $key => $value) {
            $query->where($key, $value);
        }
        $data = $response->query($query)->read();
        if (parent::$cache) {
            $cache = static::to_cache($data);
        }
        return $data;
    }

    public static function show(string $id)
    {
        if (empty(static::$router)) {
            throw new Exception('Router Not Found!');
        }
        $response = parent::$client;
        $query = (new Query(parent::$command . 'print'))->where('.id', $id);
        $data = $response->query($query)->read();
        if (empty($data)) {
            throw new Exception('Data Not Found!');
        }
        return $data[0];
    }

    public static function store(array $param = [])
    {
        if (empty(static::$router)) {
            throw new Exception('Router Not Found!');
        }
        $response = parent::$client;
        $query = (new Query(parent::$command . 'add'));
        foreach ($param ?? [] as $key => $value) {
            $query->equal($key, $value);
        }
        $data = $response->query($query)->read();
        $id =  parent::cek_error($data);
        if (parent::$cache) {
            $new_data = static::show($id);
            static::store_item_to_cache($new_data);
        }
        return $id;
    }

    public static function update($id, array $param)
    {
        if (empty(static::$router)) {
            throw new Exception('Router Not Found!');
        }
        $response = parent::$client;
        $query = (new Query(parent::$command . 'set'));
        $query->equal('.id', $id);
        foreach ($param ?? [] as $key => $value) {
            $query->equal($key, $value);
        }
        $data = $response->query($query)->read();
        $new_id =  parent::cek_error($data);
        if (parent::$cache) {
            $new_data = static::show($id);
            static::update_item_to_cache($id, $new_data);
        }
        return $id;
    }

    public static function destroy(array $id)
    {
        if (empty(static::$router)) {
            throw new Exception('Router Not Found!');
        }
        $response = parent::$client;
        $query = (new Query(parent::$command . 'remove'))->equal('.id', implode(',', $id));
        $data = $response->query($query)->read();
        if (parent::$cache) {
            static::remove_from_cache($id);
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
        // $data = collect($data)->filter(function ($item) {
        //     return isset($item['.id']);
        // });
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
