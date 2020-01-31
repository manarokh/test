@if ( count($project->activity)>0 )
    <div class="card mt-4">
        <h3 class="text-default font-bold mb-1 text-xl">Recent Activities</h3>
        <ul>
            <?php $count = 0; ?>
            @foreach ($project->activity as $activity)
            <?php if($count == 40) break; ?>
                <li class="{{ $loop->last ? '' : 'mb-1' }}"> 
                    @isset($activity->subject)
                        @include("projects.activity.$activity->description"),
                        <span class="text-gray-600"> {{ date_format($activity->created_at,"Y/m/d g:i:s A")}}</span>
                    @endisset
                    {{-- <span class="text-gray-600"> {{ $activity->created_at->diffForHumans(null,true) }} </span> --}}
                </li>
                <?php $count++; ?>
            @endforeach
        </ul>
    </div>    
@endif