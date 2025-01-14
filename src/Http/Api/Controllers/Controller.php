<?php

namespace Feelri\Core\Http\Api\Controllers;

use Feelri\Core\Traits\ResponseTrait;

abstract class Controller extends \Illuminate\Routing\Controller
{
    use ResponseTrait;
}
