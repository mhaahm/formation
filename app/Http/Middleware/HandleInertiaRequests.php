<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * @param Request $request
     * @return array
     */
    public function share(Request $request)
    {
        dd($request);
        return array_merge(parent::share($request), [
            'flash' => [
                'success' => fn () => $request->session()->get('success')
            ],
        ]);
    }
}
