@include('Chatify::layouts.headLinks')
<div class="messenger">
    {{-- ----------------------Users/Groups lists side---------------------- --}}
    <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
        {{-- Header and search bar --}}
        <div class="m-header">
            <!-- Navbar -->
            <nav>
                <!-- Logo dan judul -->
                <a href="#">
                    <img src="/Navbar/NavbarLogo.png" alt="Logo" class="logo" />
                    <span class="messenger-headTitle">Messages</span>
                </a>

                <!-- Header buttons -->
                <nav class="m-header-right">
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                    <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                </nav>
            </nav>

            <!-- Search input -->
            <input type="text" class="messenger-search" placeholder="Search" />

            <!-- Tabs -->
            <div class="messenger-listView-tabs">
                <!-- FAQ Section (Langsung Tampil) -->
                <a href="#" class="active-tab" data-view="users">
                    <span class="far fa-user"></span> Contacts
                </a>
            </div>
        </div>

        <!-- Tambahkan FAQ di sini -->
        <div id="faq-section" class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div id="faq-list">
                <p>Loading FAQ...</p>
            </div>
        </div>

        {{-- tabs and lists --}}
        <div class="m-body contacts-container">
            {{-- Lists [Users/Group] --}}
            {{-- ---------------- [ User Tab ] ---------------- --}}
            <div class="show messenger-tab users-tab app-scroll" data-view="users">
                {{-- Favorites --}}
                <div class="favorites-section">
                    <p class="messenger-title"><span>Favorites</span></p>
                    <div class="messenger-favorites app-scroll-hidden"></div>
                </div>
                {{-- Saved Messages --}}
                <p class="messenger-title"><span>Your Space</span></p>
                {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
                {{-- Contact --}}
                <!-- <p class="messenger-title"><span>All Messages</span></p> -->
                <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;"></div>
            </div>
            {{-- ---------------- [ Search Tab ] ---------------- --}}
            <div class="messenger-tab search-tab app-scroll" data-view="search">
                {{-- items --}}
                <p class="messenger-title"><span>Search</span></p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Type to search..</span></p>
                </div>
            </div>
        </div>
    </div>

    {{-- ----------------------Messaging side---------------------- --}}
    <div class="messenger-messagingView">
        {{-- header title [conversation name] amd buttons --}}
        <div class="m-header m-header-messaging">
            <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                {{-- header back button, avatar and user name --}}
                <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                    <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                        <!-- Menambahkan elemen img dengan src sesuai dengan contoh kedua -->
                        <img
                            src="/storage/avatars/{{ Auth::user()->id ?? 'default' }}.png"
                            alt="User Avatar"
                            onerror="this.src='/storage/avatars/default.png';"
                            style="width: 35px; height: 40px; border-radius: 20%; object-fit: cover;">
                    </div>
                    <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                </div>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    <a href="/"><i class="fas fa-home"></i></a>
                    <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                    <!-- <a href="#" id="open-faq-chat" class="faq-tab-chat">
                        <span class="fas fa-question-circle"></span> FAQ
                    </a> -->
                </nav>
            </nav>
            {{-- Internet connection --}}
            <div class="internet-connection">
                <span class="ic-connected">Connected</span>
                <span class="ic-connecting">Connecting...</span>
                <span class="ic-noInternet">No internet access</span>
            </div>
        </div>

        {{-- Messaging area --}}
        <div class="m-body messages-container app-scroll">
            <div class="messages">
            </div>
            {{-- Typing indicator --}}
            <div class="typing-indicator">
                <div class="message-card typing">
                    <div class="message">
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Send Message Form --}}
        @include('Chatify::layouts.sendForm')
    </div>

    {{-- ---------------------- Info side ---------------------- --}}
    <div class="messenger-infoView app-scroll">
        {{-- nav actions --}}
        <nav>
            <p>User Details</p>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        {!! view('Chatify::layouts.info')->render() !!}
    </div>
</div>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqList = document.getElementById('faq-list');

        // Fetch FAQ dari API saat halaman dimuat
        fetch('/api/faq')
            .then(res => res.json())
            .then(data => {
                faqList.innerHTML = ''; // Kosongkan dulu
                if (data.length > 0) {
                    data.forEach((faq, index) => {
                        faqList.innerHTML += `
                            <div class="faq-item" data-index="${index}">
                                <strong>${faq.question}</strong>
                                <p>${faq.answer}</p>
                            </div>
                        `;
                    });

                    // Tambahkan efek klik untuk expand/collapse
                    document.querySelectorAll('.faq-item').forEach(item => {
                        item.addEventListener('click', () => {
                            const isActive = item.classList.contains('active');
                            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
                            if (!isActive) item.classList.add('active');
                        });
                    });
                } else {
                    faqList.innerHTML = '<p>No FAQs available.</p>';
                }
            })
            .catch(err => {
                console.error('Failed to fetch FAQ:', err);
                faqList.innerHTML = '<p>Failed to load FAQ.</p>';
            });
    });
</script>