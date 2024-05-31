<?php

require 'vendor/autoload.php';

use TodoApp\Todo;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class TodoApp
{
    private Todo $todo;
    private ConsoleOutput $output;

    public function __construct()
    {
        $this->todo = new Todo();
        $this->output = new ConsoleOutput();
    }

    public function run(): void
    {
        while (true) {
            $this->showMenu();
            $option = $this->getInput("");

            switch ($option) {
                case '1':
                    $this->addTodo();
                    break;
                case '2':
                    $this->listTodos();
                    break;
                case '3':
                    $this->markTodoCompleted();
                    break;
                case '4':
                    $this->deleteTodo();
                    break;
                case '5':
                    $this->deleteAllTodos();
                    break;
                case '6':
                    exit("Exiting TODO application. Goodbye!" . PHP_EOL);
                default:
                    echo "Invalid option. Please try again." . PHP_EOL;
            }
        }
    }

    private function showMenu(): void
    {
        echo "TODO Application" . PHP_EOL;
        echo "1. Add a new TODO" . PHP_EOL;
        echo "2. List all TODOs" . PHP_EOL;
        echo "3. Mark TODO as completed" . PHP_EOL;
        echo "4. Delete TODO" . PHP_EOL;
        echo "5. Delete all TODOs" . PHP_EOL;
        echo "6. Exit" . PHP_EOL;
        echo "Select an option: ";
    }

    private function getInput(string $prompt): string
    {
        echo $prompt;
        return trim(fgets(STDIN));
    }

    private function addTodo(): void
    {
        $task = $this->getInput("Enter the task: ");
        $this->todo->addTodo($task);
        echo "Added new TODO: $task" . PHP_EOL;
    }

    private function listTodos(): void
    {
        $todos = $this->todo->getTodos();

        $table = new Table($this->output);
        $table->setHeaders(['ID', 'Task', 'Status']);

        foreach ($todos as $index => $task) {
            $table->addRow([$index, $task['task'], $task['status']]);
        }

        $table->render();
    }

    private function markTodoCompleted(): void
    {
        $id = $this->getInput("Enter the ID of the task to mark as completed: ");
        $this->todo->markTodoCompleted((int)$id);
        echo "Marked TODO $id as completed." . PHP_EOL;
    }

    private function deleteTodo(): void
    {
        $id = $this->getInput("Enter the ID of the task to delete: ");
        $this->todo->deleteTodo((int)$id);
        echo "Deleted TODO $id." . PHP_EOL;
    }

    private function deleteAllTodos(): void
    {
        $this->todo->deleteAllTodos();
        echo "Deleted all TODOs." . PHP_EOL;
    }
}

$app = new TodoApp();
$app->run();