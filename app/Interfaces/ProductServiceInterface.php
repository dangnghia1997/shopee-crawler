<?php
declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductServiceInterface
{
    public function search(Request $request);
}
