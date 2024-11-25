<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class FilterHelper
{
    public static function filter($request, $data, $filter_types)
    {
        try {
            if (isset($request->filter) && count($request->filter)) {
                foreach ($request->filter as $key => $value) {
                    if (Arr::has($filter_types, $key)) {
                        $type = explode(',', Arr::get($filter_types, $key));
                        switch ($type[0]) {
                            case 'like':
                                $data = $data->where(isset($type[1]) ? $type[1] : $key, 'LIKE', '%' . $value . '%');
                                break;
                            case '=':
                                $data = $data->where(isset($type[1]) ? $type[1] : $key, $value);
                                break;
                            case 'in':
                                $data = $data->whereIn(isset($type[1]) ? $type[1] : $key, json_decode($value));
                                break;
                            case 'boolean':
                                $data = $data->where(isset($type[1]) ? $type[1] : $key, json_decode($value));
                                break;
                            case 'between':
                                $data_type = isset($type[2]) ? $type[2] : null;
                                $array = json_decode($value);
                                if ($data_type == 'date') {
                                    if (count($array) > 1) {
                                        $array[0] = Carbon::parse($array[0] . ' 00:00:00')->toDateTimeString();
                                        $array[1] = Carbon::parse($array[1] . ' 23:59:59')->toDateTimeString();
                                    }
                                }
                                $data = $data->whereBetween(isset($type[1]) ? $type[1] : $key, $array);
                                break;
                            case 'has_one':
                                $data = $data->whereHas(isset($type[2]) ? $type[2] : $key, function ($q) use ($type, $key, $value) {
                                    if (isset($type[3])) {
                                        $t = $type[3];
                                        switch ($t) {
                                            case 'like':
                                                $q->where(isset($type[1]) ? $type[1] : $key, 'LIKE', '%' . $value . '%');
                                                break;
                                            default:
                                                $q->where(isset($type[1]) ? $type[1] : $key, json_decode($value));
                                                break;
                                        }
                                    } else {
                                        $q->where(isset($type[1]) ? $type[1] : $key, json_decode($value));
                                    }
                                });
                                break;
                            case 'has_more':
                                $data = $data->whereHas($key, function ($q) use ($type, $key, $value) {
                                    $q->whereIn(isset($type[1]) ? $type[1] : $key, json_decode($value));
                                });
                                break;
                            case 'scope':
                                $data = $data->{$type[1]}($value);
                                break;
                            default:

                                break;
                        }
                    }
                }
            }
        } catch (\Throwable $th) {
            return ErrorHelper::handelErrorWithoutResponse($th, 'FilterHelper@filter');
        }
        return $data;
    }
}
