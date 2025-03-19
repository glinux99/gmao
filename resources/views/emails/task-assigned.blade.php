@component('mail::message')
# Nouvelle tâche assignee

Bonjour {{ $userName }},

Une nouvelle tâche vous a été attribuée :

@component('mail::table')
| Detail      | Information                           |
| ----------- | ------------------------------------- |
| Description | {{ $taskDescription }}                |
| Priority    | {{ $taskPriority->title }}            |
| Status      | {{ $taskStatus }}                     |
| Start Date  | {{ $startDate }}                      |
| Due Date    | {{ $dueDate }}                        |
@endcomponent

@component('mail::button', ['url' => config('app.url')])
Voir la tâche
@endcomponent

Merci,<br>
<span class="text-warning fw-bolder" style="color: rgb(255, 123, 0)">
    {{ config('app.name') }}
</span>
@endcomponent


