<?php

namespace App\Http\Controllers;

use App\Services\user\UserService;
use Illuminate\Http\Request;


class UserContoller extends Controller
{
    protected $userService;
 
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $result = $this->userService->getUSers();
        return  $result;
    }




    public function store(Request $request)
    {

        $result = $this->userService->createUser($request);

        return $result;
    }

    public function show(string $id)
    {
        $result = $this->userService->getUserById( $id);

        return $result;
    }

    public function edit(Request $request, string $id)
    {
        $result = $this->userService->editUser($request, $id);

        return $result;
    }


    public function destroy(string $id)
    {
        $result = $this->userService->deleteUser($id);

        return $result;
    }
}
