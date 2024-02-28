@foreach ($users as $user)
    <div class="menu-item px-3">
        <a href="{{ route('impersonate-user', ['id' => $user->id_user]) }}" class="menu-link px-5">{{ $user->fullName }}</a>
    </div>
@endforeach
