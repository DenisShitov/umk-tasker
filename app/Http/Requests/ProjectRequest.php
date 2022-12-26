<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Support\Requests\FormRequest;
use App\Notifications\ProjectAssigned;
use Illuminate\Support\Facades\Notification;

class ProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:190',
            'description' => 'nullable',
            'color' => 'required',
            'users' => 'required|array',
        ];
    }

    /**
     * Database Transaction.
     *
     * @return void
     */
    public function transaction()
    {
        DB::transaction(function () {
            unset($this->attributes['users']);
            unset($this->attributes['color']);
            $this->attributes['meta'] = ['color' => $this->request->color];

            $this->model->forceFill($this->attributes);
            $this->model->save();

            $this->model->users()->sync($this->request->users);

            if ($this->isPostRequest) {
                Notification::send($this->model->users, new ProjectAssigned($this->model));
            }
        });
    }
}
