<?php

namespace App\Http\Controllers;

use App\Actions\ConvertRequestToFieldsAction;
use App\Actions\ImageUploadAction;
use App\Http\Requests\StoreFormRequest;
use App\Models\FormData;

class FormController extends Controller
{
    public function store(StoreFormRequest $request, ConvertRequestToFieldsAction $inputAction, ImageUploadAction $imageAction)
    {
        $field = $inputAction->handle($request);
        $image = $imageAction->handle($request);

        $approve           = new FormData;
        $approve->fields   = json_encode($field);
        $approve->images   = json_encode($image);
        $approve->save();

        return redirect()->route('data.view')->with('success', 'Your data has been saved successfully!');
    }
}
