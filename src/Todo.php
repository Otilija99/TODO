<?php

namespace TodoApp;

class Todo
{
    private string $filePath = 'todos.json';

    public function getTodos(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }

        $jsonContent = file_get_contents($this->filePath);
        $todos = json_decode($jsonContent, true);

        if (is_null($todos)) {
            return [];
        }

        return $todos;
    }

    public function saveTodos(array $todos): void
    {
        file_put_contents($this->filePath, json_encode($todos, JSON_PRETTY_PRINT));
    }

    public function addTodo(string $task): void
    {
        $todos = $this->getTodos();
        $todos[] = ['task' => $task, 'status' => 'pending'];
        $this->saveTodos($todos);
    }

    public function markTodoCompleted(int $index): void
    {
        $todos = $this->getTodos();
        if (isset($todos[$index])) {
            $todos[$index]['status'] = 'completed';
            $this->saveTodos($todos);
        }
    }

    public function deleteTodo(int $index): void
    {
        $todos = $this->getTodos();
        if (isset($todos[$index])) {
            array_splice($todos, $index, 1);
            $this->saveTodos($todos);
        }
    }

    public function deleteAllTodos(): void
    {
        $this->saveTodos([]);
    }
}