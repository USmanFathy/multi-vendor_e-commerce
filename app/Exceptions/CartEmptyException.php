<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class CartEmptyException extends Exception
{

    public function render(Request $request)
    {
        return redirect()->route('home')->with([
            'info' => $this->getMessage()
        ]);
    }
}
