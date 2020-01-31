<div class="card flex flex-col " style="height: 200px ; overflow: hidden">
    <h3 class="font-normal py-3 mb-2 text-xl  -ml-4 border-l-4 border-red-400 pl-4 ">
        <a href="{{ $project->path()}}" class="font-medium text-default"> {{ $project->title }} </a>
    </h3>

    <div class="text-default mb-5 flex-1"> {{ str_limit($project->description,100) }} </div>

    @can('manage', $project)
        <footer>
            <form action="{{ $project->path() }}" method="POST" class="text-right">
                @csrf
                @method('DELETE')

                <button type="submit" class="button-primary">Delete</button>
            </form>
        </footer>    
    @endcan
    
</div>