<?php

namespace App\Api\V1\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BController;

class BaseController extends BController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
