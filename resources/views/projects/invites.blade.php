<div class="card flex flex-col mt-4" >
    <h3 class="font-normal py-3 mb-2 text-xl font-bold  -ml-4 border-l-4 border-red-400 pl-4">
        Invite a User
    </h3>

    <form action="{{ $project->path().'/invitations' }}" method="POST">
        @csrf
        <input 
        type="email" 
        name="email" 
        class=" form-input w-full mb-4"
        placeholder="Enter user email to invite"
         required>
         
        <button type="submit" class="button-primary float-right">Invite</button>
    </form>

     @include('errors',['bag'=>'invitations'])
</div>