<?php

namespace Feelri\Core\Http\AdminApi\Controllers;

use Feelri\Core\Traits\ResponseTrait;

abstract class Controller extends \Illuminate\Routing\Controller
{
    use ResponseTrait;
}
