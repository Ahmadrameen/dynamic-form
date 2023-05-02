<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getData()
    {
        $json = file_get_contents('json/form_data.json'); # This will get data from public folder.
        return json_decode($json, true);
    }

    public function rules(): array
    {
        $data = $this->getData();

        $rules = [];

        foreach ($data['data']['fields'] as $field) {
            if (isset($field['validation'])) {
                $rulesKey = $data['data']['form']['id'] . '-' . $field['id'];
                $rules[$rulesKey] = [];

                // Rule for file
                if ($field['element']['type'] === 'image_uploader') {
                    $rules[$rulesKey] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
                }

                // Rule for other inputs excpet file
                foreach ($field['validation'] as $validationRule) {
                    if ($validationRule['rule'] === 'regex' && isset($validationRule['params']['pattern'])) {
                        $rules[$rulesKey][] = 'regex:' . $validationRule['params']['pattern'];
                    } else {
                        $rules[$rulesKey][] = $validationRule['rule'];
                    }
                }
            }
        }

        return $rules;
    }

    public function messages()
    {
        $data = $this->getData();

        $messages = [];

        foreach ($data['data']['fields'] as $field) {
            if ($field['validation']) {
                $messages[$data['data']['form']['id'] . '-' . $field['id'] . '.' . $field['validation'][0]['rule']] = $field['validation'][0]['message'];
            }
        }

        return $messages;
    }
}
