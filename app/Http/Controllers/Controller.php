<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Reusable method to return 404 not found
    protected function returnNotFound($entityName = 'Resource')
    {
        return response()->json([
            'message' => $entityName . ' not found'
        ], 404);
    }
}
