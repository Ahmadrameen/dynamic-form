<?php

namespace App\Actions;

use App\Http\Requests\StoreFormRequest;
use Illuminate\Support\Str;

class ImageUploadAction
{
    public function handle(StoreFormRequest $request)
    {
        $files = $request->file();

        $images = [];
        foreach ($files as $key => $file) {
            $id = explode('-', $key);
            $id = end($id);
            if ($file->isValid()) {
                $name = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $name);
                $field = [
                    'id'    => $id,
                    'value' => $name,
                ];
                $images[] = $field;
            }
        }

        return [
            'images' => $images,
        ];
    }
}