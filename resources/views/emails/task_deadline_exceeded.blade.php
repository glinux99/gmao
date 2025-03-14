@component('mail::message')
# Date limite de la tâche dépassée !!

La date limite pour la tâche suivante a été dépassée et n'a pas été marquée comme terminée :

@component('mail::table')
| Detail      | Information                           |
| ----------- | ------------------------------------- |
| Description | {{ $task->description }}              |
| Priority    | {{$task->priority }}                  |
| Status      | {{ $task->status }}                   |
| Start Date  | {{ $task->start_date }}               |
| Due Date    | {{ $task->due_date }}                 |
@endcomponent

Veuillez prendre des mesures pour résoudre ce problème le plus rapidement possible  et informez votre superviseur.

@component('mail::button', ['url' => url('/tasks/' . $task->id)])
Voir la tache
@endcomponent

Merci,<br>
<span class="text-warning fw-bolder" style="color: rgb(255, 123, 0)">
    {{ config('app.name') }}
</span>
@endcomponent
