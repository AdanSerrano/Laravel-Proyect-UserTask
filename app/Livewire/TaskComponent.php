<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskComponent extends Component
{
    public $tasks = [];
    public $taskId; // Nueva variable para almacenar el id de la tarea
    public $title;
    public $description;
    public $modal = false;
    public $isUpdating = false;

    public function mount()
    {
        $this->tasks = $this->getTasks();
    }

    public function render()
    {
        return view('livewire.task-component');
    }

    public function getTasks()
    {
        return $this->tasks = Task::where('user_id', Auth::user()->id)->get();
    }

    public function clearFields()
    {
        $this->taskId = null; // Reinicia el id de la tarea para diferenciar entre crear y actualizar
        $this->title = '';
        $this->description = '';
    }

    public function openCreateModal()
    {
        $this->clearFields();
        $this->modal = true;
    }

    public function closeCreateModal()
    {
        $this->clearFields();
        $this->modal = false;
    }

    public function createOrUpdateTask()
    {
        // Validación de los datos
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        $this->isUpdating = false;

        // Crear o actualizar tarea con el user_id
        Task::updateOrCreate(
            [
                'id' => $this->taskId,
                'user_id' => Auth::user()->id
            ],
            [
                'title' => $this->title,
                'description' => $this->description,
            ]
        );


        // Limpiar los campos y cerrar el modal
        $this->clearFields();
        $this->modal = false;

        // Actualizar la lista de tareas para mostrar la nueva tarea en la vista
        $this->tasks = $this->getTasks();
    }

    public function updateTask($taskId)
    {
        // Encuentra la tarea por id y carga sus datos en los campos de edición
        $task = Task::findOrFail($taskId);
        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->modal = true;
        $this->isUpdating = true;
    }
}
