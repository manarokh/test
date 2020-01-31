{{-- <form method="POST" action="{{$project->path()}}" class="lg:w-1/2 lg:mx-auto bg-white py-12 px-16 rounded shadow"> --}}
    @csrf
{{-- @method('PATCH') --}}

    {{-- <h1 class="text-2xl font-normal mb-10 text-center">Edit Project</h1> --}}

    <div class="field mb-6">
        <label class="label text-sm mb-2 block" for="title">Title</label>

        <div class="control">
            <input type="text" 
            class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full" 
            name="title" 
            value="{{$project->title}}"
            placeholder="My next awesome project"
            required>
        </div>
    </div>

    <div class="field mb-6">
        <label class="label text-sm mb-2 block" for="description">Description</label>

        <div class="control">
            <textarea name="description" 
            rows="10" 
            class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full" 
            placeholder="I should start learning piano."
            required>{{$project->description}}</textarea>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button type="submit" class="button-primary mr-2">{{$buttonText}}</button>
            <a href="{{$project->path()}}" class="button-white">Cancel</a>
        </div>
    </div>
{{-- </form> --}}

@include('errors')