<div class="favorite-list-item">
    @if($user)
    <div data-id="{{ $user->id }}" data-action="0" class="avatar av-m"
        style="background-image: url('{{ Chatify::getUserWithAvatar($user)->avatar }}');">
        <img
            src="/storage/avatars/{{ Auth::user()->id ?? 'default' }}.png"
            alt="User Avatar"
            onerror="this.src='/storage/avatars/default.png';"
            style="width: 40px; height: 40px; border-radius: 40%; object-fit: cover;">
    </div>
    <p>{{ strlen($user->name) > 5 ? substr($user->name,0,6).'..' : $user->name }}</p>
    @endif
</div>