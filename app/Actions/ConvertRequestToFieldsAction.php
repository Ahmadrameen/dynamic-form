<?php

namespace App\Actions;

use App\Http\Requests\StoreFormRequest;

class ConvertRequestToFieldsAction
{
    public function handle(StoreFormRequest $request)
    {
        $request = $request->request;

        $fields = [];

        foreach ($request as $key => $value) {
            if ($key === '_token'){
                continue;
            };

            $id = explode('-', $key);
            $id = end($id);

            $field = [
                'id'    => $id,
                'value' => $value,
            ];

            $fields[] = $field;
        }

        return [
            'fields' => $fields,
        ];
    }
}
