<?php

namespace App\Http\Requests;

use App\Models\Wall;
use Illuminate\Foundation\Http\FormRequest;

class StoreWallRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'tags' => 'max:255',
            'body' => 'required',
            'publish_status' => 'required|in:draft,published',
        ];
    }
}
