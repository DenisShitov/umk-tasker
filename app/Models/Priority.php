<?php

namespace App\Models;

use App\Support\Categorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Priority extends Model
{
    use Categorizable, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The Category Parent.
     *
     * @var string
     */
    protected static $parent = 'Task Priority';
}
