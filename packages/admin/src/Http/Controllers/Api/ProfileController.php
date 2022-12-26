<?php

namespace Admin\Http\Controllers\Api;

use App\Support\Field;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class ProfileController
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();

        return Field::make()
                ->field('avatar', $user->avatar)
                ->field('name', $user->name)
                ->field('email', $user->email);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return new ProfileRequest($request, auth()->user());
    }
}
