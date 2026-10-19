<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApiUnavailableException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): RedirectResponse|JsonResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'The API is currently unavailable.'], 503);
        }
        return redirect()->route('home')->with('error', 'The API is currently unavailable.');
    }
}
