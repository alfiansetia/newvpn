<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

trait CrudApiTrait
{
    public static $expired = 3600;

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

    public static function destroy_by($key, $param)
    {
        $data = parent::$API->comm(parent::$command . "print", [
            "?$key" => $param
        ]);
        parent::cek_error($data);
        if (!empty($data)) {
            $ids = array_column($data, '.id');
            $dataremove = parent::$API->comm(parent::$command . "remove", [
                '.id' => implode(',', $ids)
            ]);
            if (parent::$cache) {
                $cache = static::remove_from_cache($ids);
            }
        }
        return true;
    }

    public static function from_cache($filters = [])
    {
        $id = parent::$router->id;
        $cacheKey = "router_cache_{$id}";
        // return Cache::get($cacheKey);
        return Cache::remember($cacheKey, static::$expired, function () use ($filters) {
            return static::get($filters);
        });
    }

    public static function to_cache($data)
    {
        $id = parent::$router->id;
        $cacheKey = "router_cache_{$id}";
        Cache::put($cacheKey, $data, static::$expired);
        return new static;
    }

    public static function cache(bool $cache = false)
    {
        parent::$cache = $cache;
        return new static;
    }

    public static function remove_from_cache(array $ids)
    {
        $id = parent::$router->id;
        $cacheKey = "router_cache_{$id}";
        $data = collect(Cache::get($cacheKey, []));
        $filteredData = $data->reject(function ($item) use ($ids) {
            return isset($item['.id']) && in_array($item['.id'], $ids);
        });
        Cache::put($cacheKey, $filteredData->values()->toArray(), static::$expired);
    }

    public static function store_item_to_cache($new_data)
    {
        $id = parent::$router->id;
        $cacheKey = "router_cache_{$id}";
        $data = collect(Cache::get($cacheKey, []));
        $data->push($new_data);
        Cache::put($cacheKey, $data->values()->toArray(), static::$expired);
    }

    public static function update_item_to_cache($id, $new_data)
    {
        $routerId = parent::$router->id;
        $cacheKey = "router_cache_{$routerId}";
        $data = collect(Cache::get($cacheKey, []));
        $data = $data->map(function ($item) use ($id, $new_data) {
            return (isset($item['.id']) && $item['.id'] === $id) ? $new_data : $item;
        });
        Cache::put($cacheKey, $data->values()->toArray(), static::$expired);
    }
}
