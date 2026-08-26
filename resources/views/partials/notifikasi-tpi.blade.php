@auth
@if(auth()->user()->role === 'tpi')
<div class="notif-wrapper">
    <button type="button" class="notif-bell-btn" id="notifBellBtn">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <span class="notif-badge d-none" id="notifBadgeCount">0</span>
    </button>

    <div class="notif-dropdown-menu d-none" id="notifDropdownMenu">
        <div class="notif-dropdown-header">Notifikasi</div>
        <div id="notifList">
            <div class="notif-empty">Memuat notifikasi...</div>
        </div>
    </div>
</div>

<style>
    .notif-wrapper { position: relative; display: inline-block; }
    .notif-bell-btn {
        position: relative;
        background: none;
        border: none;
        cursor: pointer;
        padding: .5rem;
        color: #475569;
    }
    .notif-bell-btn svg { width: 22px; height: 22px; }
    .notif-badge {
        position: absolute;
        top: 2px; right: 2px;
        background: #ef4444;
        color: #fff;
        font-size: .65rem;
        font-weight: 700;
        min-width: 16px;
        height: 16px;
        border-radius: 99px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 3px;
    }
    .notif-dropdown-menu {
        position: absolute;
        top: 110%;
        right: 0;
        width: 320px;
        max-height: 400px;
        overflow-y: auto;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0,0,0,.12);
        z-index: 1000;
    }
    .notif-dropdown-header {
        padding: .75rem 1rem;
        font-weight: 700;
        font-size: .85rem;
        color: #0f1f3d;
        border-bottom: 1px solid #f1f5f9;
    }
    .notif-item {
        display: block;
        padding: .75rem 1rem;
        text-decoration: none;
        border-bottom: 1px solid #f8fafc;
        transition: background .15s;
    }
    .notif-item:hover { background: #f8fafc; }
    .notif-item.unread { background: #fff7e6; }
    .notif-item-msg { font-size: .82rem; color: #1e293b; line-height: 1.4; }
    .notif-item-time { font-size: .72rem; color: #94a3b8; margin-top: .2rem; }
    .notif-empty { padding: 1.5rem 1rem; text-align: center; font-size: .82rem; color: #94a3b8; }
</style>

<script>
    (function () {
        const bellBtn      = document.getElementById('notifBellBtn');
        const dropdownMenu = document.getElementById('notifDropdownMenu');
        const badgeEl      = document.getElementById('notifBadgeCount');
        const listEl       = document.getElementById('notifList');

        function renderList(items) {
            if (!items || items.length === 0) {
                listEl.innerHTML = '<div class="notif-empty">Belum ada notifikasi.</div>';
                return;
            }
            listEl.innerHTML = items.map(n => `
                <a href="/produk/${n.produk_id}/penawaran"
                   class="notif-item ${n.is_read ? '' : 'unread'}"
                   onclick="tandaiNotifDibaca('${n.id}')">
                    <div class="notif-item-msg">${n.message}</div>
                    <div class="notif-item-time">${n.waktu}</div>
                </a>
            `).join('');
        }

        function muatNotifikasi() {
            fetch('{{ route('notifikasi.json') }}', {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(res => {
                if (res.status !== 'success') return;
                if (res.unread_count > 0) {
                    badgeEl.textContent = res.unread_count;
                    badgeEl.classList.remove('d-none');
                } else {
                    badgeEl.classList.add('d-none');
                }
                renderList(res.data);
            })
            .catch(() => {
                listEl.innerHTML = '<div class="notif-empty">Gagal memuat notifikasi.</div>';
            });
        }

        window.tandaiNotifDibaca = function (id) {
            fetch(`/notifikasi/${id}/baca`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json',
                }
            });
        };

        bellBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('d-none');
            if (!dropdownMenu.classList.contains('d-none')) muatNotifikasi();
        });

        document.addEventListener('click', function (e) {
            if (!dropdownMenu.contains(e.target) && e.target !== bellBtn) {
                dropdownMenu.classList.add('d-none');
            }
        });

        // Polling tiap 20 detik biar badge count ke-update otomatis
        muatNotifikasi();
        setInterval(muatNotifikasi, 20000);
    })();
</script>
@endif
@endauth