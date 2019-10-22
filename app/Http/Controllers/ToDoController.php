<?php

namespace App\Http\Controllers;

use App\ToDo;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = ToDo::latest('id')->get();
        return view('todo.list', ['todos' => $todos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveToDo $request)
    {
        $target = new ToDo;
        $target->title = $request->input('title');
        $target->content = $request->input('content');
        $target->priority = $request->input('priority');
        $target->save();

        // save()後、$todoには保存したときのidがセットされる
        return redirect()->route('todo.show', ['todo' => $target]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ToDo  $toDo
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return view(
            'todo.detail',
            ['todo' => ToDo::where('id', $id)->firstOrFail()]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ToDo  $toDo
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view(
            'todo.edit',
            ['todo' => ToDo::where('id', $id)->firstOrFail()]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ToDo  $toDo
     * @return \Illuminate\Http\Response
     */
    public function update(SaveToDo $request, int $id)
    {
        $target = ToDo::where('id', $id)->firstOrFail();
        $target->title = $request->input('title');
        $target->content = $request->input('content');
        $target->priority = $request->input('priority');
        $target->save();

        return redirect()->route('todo.show', ['todo' => $id]);
    }

    public function confirm(int $id)
    {
        return view(
            'todo.confirm_delete',
            ['todo' => ToDo::where('id', $id)->firstOrFail()]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ToDo  $toDo
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $target = ToDo::where('id', $id)->firstOrFail();
        $target->delete();

        return redirect()->route('todo.index');
    }
}
