@if ($errors->{$bag ?? 'default'}->any())
    <ul class="field mt-5 list-reset">
        @foreach ($errors->{$bag ?? 'default'}->all() as $error)
            <li class="text-sm text-red-800">{{$error}}</li>
        @endforeach
    </ul>
@endif