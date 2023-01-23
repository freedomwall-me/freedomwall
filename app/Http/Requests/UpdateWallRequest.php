<?php

namespace App\Http\Requests;

use App\Models\Wall;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWallRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $wallId = $this->route('wall');
        $wall = Wall::find($wallId);

        return $wall && $wall->user_id == $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|sometimes|max:255',
            'tags' => 'max:255',
            'body' => 'required|sometimes',
            'publish_status' => 'required|sometimes|in:draft,published',
        ];
    }
}
