<?php
namespace App\Http\Controllers\testing;

use App\Http\Controllers\Controller;
use App\Http\Resources\testing\testResource;
use App\Models\testing\test;


//use App\Http\Resources\AttrResource;
//use App\Models\Attr;
use Illuminate\Http\Request;

class testController extends Controller{
    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $query = test::query();
        return testResource::collection($query->paginate(10));
//        dd(123);

    }
}