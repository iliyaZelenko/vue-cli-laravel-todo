<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Todo;

class TodoController extends BaseController
{
    public function update(Request $request, $todo)
    {
        Todo::whereId($todo)->update($request->all());
    }

    public function store(Request $request)
    {
        return Todo::create($request->all());
    }

    public function destroy($todo)
    {
        Todo::destroy($todo);
    }
}
