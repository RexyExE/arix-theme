<?php

namespace Pterodactyl\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;

class ArixController extends AbstractLoginController
{
    /**
     * Return Arix theme status and active version.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'active',
            'theme' => 'Arix',
            'version' => config('app.arix', '2.0.8'),
            'timestamp' => time(),
        ]);
    }
}
