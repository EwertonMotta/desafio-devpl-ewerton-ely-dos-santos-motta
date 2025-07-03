<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    public function index(Request $request)
    {
        $myTasks           = auth()->user()->tasks()->get();
        $tasksCount        = $myTasks->count();
        $pendingTasksCount = $myTasks->where('completed', false)->count();

        [$orderBy, $orderDirection] = explode('-', $request->query('orderBy', 'created_at-asc'));
        $title                      = $request->query('title');
        $startCreatedAt             = $request->query('start_created_at');
        $endCreatedAt               = $request->query('end_created_at');
        $startDeadline              = $request->query('start_deadline');
        $endDeadline                = $request->query('end_deadline');

        $tasks = Task::query()
            ->where('user_id', auth()->id())
            ->when($title, function ($query) use ($title) {
                return $query->where('title', 'like', '%' . $title . '%');
            })
            ->when($startCreatedAt, function ($query) use ($startCreatedAt) {
                return $query->where('created_at', '>=', $startCreatedAt);
            })
            ->when($endCreatedAt, function ($query) use ($endCreatedAt) {
                return $query->where('created_at', '<=', $endCreatedAt);
            })
            ->when($startDeadline, function ($query) use ($startDeadline) {
                return $query->where('deadline', '>=', $startDeadline . ' 00:00:00');
            })
            ->when($endDeadline, function ($query) use ($endDeadline) {
                return $query->where('deadline', '<=', $endDeadline . ' 23:59:59');
            })->orderBy($orderBy, $orderDirection)
            ->paginate(10);

        return view('to-do.index', compact('tasks', 'pendingTasksCount', 'tasksCount'));
    }

    public function toggle(Request $request, Task $task)
    {
        if (auth()->user()->cannot('update', $task)) {
            return redirect()->route('to-do.index')
                ->withErrors(['error' => 'Você não tem permissão para atualizar esta tarefa.']);
        }

        if ($task->completed) {
            return redirect()->route('to-do.index')
                ->withErrors(['error' => 'Esta tarefa já está concluída.']);
        }

        $task->update([
            'completed'    => true,
            'completed_at' => now(),
        ]);

        $requestQuery = $request->get('query', '');
        $queryParams  = [];

        if ($requestQuery) {
            $queryParams = explode('&', $requestQuery);
            $queryParams = array_reduce($queryParams, function ($carry, $item) {
                list($key, $value)      = explode('=', $item);
                $carry[urldecode($key)] = urldecode($value);

                return $carry;
            }, []);
        }

        return redirect()->route('to-do.index', $queryParams);
    }

    public function create()
    {
        return view('to-do.create');
    }

    public function store(TaskRequest $request)
    {
        $validated = $request->validated();

        auth()->user()->tasks()->create([
            'title'       => $validated['title'],
            'deadline'    => $validated['deadline'],
            'description' => $validated['description'],
            'completed'   => $validated['completed'] ?? false,
        ]);

        return redirect()->route('to-do.index');
    }

    public function show(Task $task)
    {
        if (auth()->user()->cannot('view', $task)) {
            return redirect()->route('to-do.index')
                ->withErrors(['error' => 'Você não tem permissão para visualizar esta tarefa.']);
        }

        return view('to-do.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if (auth()->user()->cannot('update', $task)) {
            return redirect()->route('to-do.index')
                ->withErrors(['error' => 'Você não tem permissão para editar esta tarefa.']);
        }

        return view('to-do.edit', compact('task'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        if (auth()->user()->cannot('update', $task)) {
            return redirect()->route('to-do.index')
                ->withErrors(['error' => 'Você não tem permissão para atualizar esta tarefa.']);
        }

        if ($task->completed) {
            return redirect()->route('to-do.index')
                ->withErrors(['error' => 'Esta tarefa já está concluída. Você não pode editá-la.']);
        }

        $validated = $request->validated();

        $task->update([
            'title'       => $validated['title'],
            'deadline'    => $validated['deadline'],
            'description' => $validated['description'],
            'completed'   => $validated['completed'] ?? false,
        ]);

        return redirect()->route('to-do.index');
    }

    public function destroy(Task $task)
    {
        if (auth()->user()->cannot('delete', $task)) {
            return redirect()->route('to-do.index')
                ->withErrors(['error' => 'Você não tem permissão para excluir esta tarefa.']);
        }

        if ($task->completed) {
            return redirect()->route('to-do.index')
                ->withErrors(['error' => 'Esta tarefa já está concluída. Você não pode excluí-la.']);
        }

        $task->delete();

        return redirect()->route('to-do.index');
    }
}
