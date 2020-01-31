@if ( count($activity->changes['after']) == 1 )
    <span class="capitalize">{{ $activity->user->name }}</span> updated the "{{ key($activity->changes['after']) }}" of the project.
@else   
    <span class="capitalize">{{ $activity->user->name }}</span> updated a Project.
@endif
