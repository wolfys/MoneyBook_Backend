<?php

use Illuminate\Http\Exceptions\HttpResponseException;

function getUserInitials($name, $last_name, $second_name): string
{
    if ($second_name === null && $last_name === null) {
        return $name;
    }

    if ($last_name === null) {
        return "{$second_name} {$name}";
    }

    $name = mb_substr($name, 0, 1);
    $last_name = mb_substr($last_name, 0, 1);

    return "{$second_name} {$name}. {$last_name}.";
}

function checkUsers($data, $gate): void
{

    if ($data === null || !Gate::allows($gate, $data)) {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'data'      => 'Пункт не найден или его редактирование запрещено.'
        ]));
    }

}
