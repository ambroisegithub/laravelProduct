<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function uploadImage(Request $request)
    {
        try {
            if (!$request->hasFile('file')) {
                return $this->errorResponse(202, 'file is required');
            }
            $response = cloudinary()->upload($request->file('file')->getRealPath())->getSecurePath();
            return $response;
        } catch (\Exception $e) {
            return $this->errorResponse(201, $e->getMessage());
        }
    }

    protected function errorResponse($code, $message)
    {
        return response()->json(['error' => ['code' => $code, 'message' => $message]], $code);
    }
}
