@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Task Details</h1>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $task->id }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $task->description }}</td>
                    </tr>
                    <tr>
                        <th>Priority</th>
                        <td>{{ $task->priority }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $task->status }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $task->category }}</td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>{{ $task->start_date }}</td>
                    </tr>
                     <tr>
                        <th>Due Date</th>
                        <td>{{ $task->due_date }}</td>
                    </tr>
                     <tr>
                        <th>Owner</th>
                        <td>{{ $task->owner?->name ?? 'N/A' }}</td>
                    </tr>
                     <tr>
                        <th>Assigned to</th>
                        <td>{{ $task->user?->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Project</th>
                        <td>{{ $task->project?->name ?? 'N/A' }}</td>
                    </tr>
                </table>
                <div class="mt-3">
                  <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </div>
    </div>
@endsection
