<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    //
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        list($code, $data) = $this->repository->getData();
        return ($code == 200) ? UserResource::collection($data) : response()->json($data, $code);
    }
}
