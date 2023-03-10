<?php

use App\Support\Vite;

if (! function_exists('option')) {
    /**
     * Get / set the specified option value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string|null  $key
     * @param  mixed  $default
     * @return mixed|\App\Models\Option
     */
    function option($key = null, $default = null)
    {
        $option = app('\App\Models\Option');

        if (is_array($key)) {
            $option->set($key);
        } elseif (! is_null($key)) {
            return $option->get($key, $default);
        }

        return $option;
    }
}

if (! function_exists('vite_tags')) {
    /**
     * Get the path to a versioned vite file.
     *
     * @param  string  $path
     * @param  string  $manifestDirectory
     * @return \Illuminate\Support\HtmlString|string
     *
     * @throws \Exception
     */
    function vite_tags($manifestDirectory = '', $port = 3000)
    {
        return app(Vite::class)($manifestDirectory, $port);
    }
}
