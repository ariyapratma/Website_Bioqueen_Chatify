{{-- user info and avatar --}}
<div class="avatar av-l chatify-d-flex">
    <img src="/storage/avatars/{{ Auth::user()->id ?? 'default' }}.png" alt="User Avatar" onerror="this.src='/storage/avatars/default.png';">
</div>
<p class="info-name">{{ Auth::user()->name ?? config('chatify.name') }}</p>
<div class="messenger-infoView-btns">
    <a href="#" class="danger delete-conversation">Delete Conversation</a>
</div>
{{-- shared photos --}}
<div class="messenger-infoView-shared">
    <p class="messenger-title"><span>Shared Photos</span></p>
    <div class="shared-photos-list"></div>
</div>