<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Support\Requests\FormRequest;
use Illuminate\Support\Facades\Cache;

class RoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'permissions' => 'nullable',
        ];
    }

    /**
     * Database Transaction.
     *
     * @return void
     */
    public function transaction()
    {
        unset($this->attributes['permissions']);

        DB::transaction(function () {
            $this->model->forceFill($this->attributes);

            $this->model->save();
            $this->model->permissions()->sync($this->request->permissions);

            Cache::flush();
        });
    }
}
