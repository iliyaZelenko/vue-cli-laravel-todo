<?php

namespace App\Http\Controllers\API;

use App\Group;

class GroupController extends BaseController
{
    public function index()
    {
        return Group::with('todo:id,completed,title,group_id')
            ->withCount(['todo', 'todo as todo_completed_count' => function ($q) {
                $q->where('completed', true);
            }])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function show($group)
    {
        return $this->getGroup($group);
    }

    public function store()
    {
        $group = Group::create(request()->all());
        $group->todo()->create([
            'title' => 'Your todo title'
        ]);

        return $this->getGroup($group->id);
    }

    public function update($group)
    {
        Group::whereId($group)->update(request()->all());

        return $this->getGroup($group);
    }

    public function destroy($group)
    {
        Group::destroy($group);
    }

    protected function getGroup($group)
    {
        return Group::whereId($group)->with('todo')
            ->withCount(['todo', 'todo as todo_completed_count' => function ($q) {
                $q->where('completed', true);
            }])->first();
    }
}
