<div class="card" style="width: 100%;">
    <div class="card-header">
        <h4> {{ $title }} </h4>
    </div>
    <ul class="list-group list-group-flush">
        @if(is_a($users, 'Illuminate\Support\Collection'))
            @foreach($users as $user)
                    <li class="list-group-item">
                        {{ $user }}
                    </li>
            @endforeach
        @else
            {{ $users }}          
        @endif
    </ul>
</div>