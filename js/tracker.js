/* ===== CAMPANHA DO BEM — Analytics Tracker v1.0 ===== */
(function () {
    'use strict';

    /* ── Config ── */
    var TRACKER_ENDPOINT = (function () {
        var scripts = document.getElementsByTagName('script');
        for (var i = scripts.length - 1; i >= 0; i--) {
            var src = scripts[i].src || '';
            if (src.indexOf('tracker.js') !== -1) {
                return src.replace(/assets\/js\/tracker\.js.*$/, '') + 'assets/api/tracker.php';
            }
        }
        return '../../assets/api/tracker.php';
    })();

    var SCROLL_MILESTONES = [25, 50, 75, 90, 100];
    var scrollReached = {};
    var sessionStartTime = Date.now();

    /* ── Session ID ── */
    function getSessionId() {
        var key = 'cdb_session_v1';
        var sessionKey = 'cdb_session_ts';
        var SESSION_TTL = 30 * 60 * 1000; /* 30 min */

        var sid = null;
        var ts = null;
        try {
            sid = sessionStorage.getItem(key);
            ts  = parseInt(sessionStorage.getItem(sessionKey) || '0', 10);
        } catch (_) {}

        if (sid && ts && (Date.now() - ts) < SESSION_TTL) {
            try { sessionStorage.setItem(sessionKey, String(Date.now())); } catch (_) {}
            return sid;
        }

        /* Nova sessão */
        sid = generateUUID();
        try {
            sessionStorage.setItem(key, sid);
            sessionStorage.setItem(sessionKey, String(Date.now()));
        } catch (_) {}
        return sid;
    }

    function generateUUID() {
        if (window.crypto && typeof window.crypto.randomUUID === 'function') {
            return window.crypto.randomUUID();
        }
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = (Math.random() * 16) | 0;
            return (c === 'x' ? r : (r & 0x3) | 0x8).toString(16);
        });
    }

    /* ── Visitor (persistido no localStorage por 1 ano) ── */
    function getVisitorInfo() {
        var key = 'cdb_visitor_v1';
        try {
            var raw = localStorage.getItem(key);
            if (raw) {
                var v = JSON.parse(raw);
                localStorage.setItem(key, JSON.stringify({ id: v.id, seen: Date.now() }));
                return { id: v.id, is_new: false };
            }
        } catch (_) {}
        var vid = generateUUID();
        try { localStorage.setItem(key, JSON.stringify({ id: vid, seen: Date.now() })); } catch (_) {}
        return { id: vid, is_new: true };
    }

    /* ── UTMs (via attribution.js ou fallback próprio) ── */
    function getUTMs() {
        if (window.CampaignAttribution && typeof window.CampaignAttribution.getUTMs === 'function') {
            return window.CampaignAttribution.getUTMs();
        }
        try {
            var p = new URLSearchParams(window.location.search);
            return {
                utm_source:   p.get('utm_source')   || '',
                utm_medium:   p.get('utm_medium')   || '',
                utm_campaign: p.get('utm_campaign') || '',
                utm_term:     p.get('utm_term')     || '',
                utm_content:  p.get('utm_content')  || '',
                fbclid:       p.get('fbclid')       || '',
            };
        } catch (_) { return {}; }
    }

    /* ── Variante da página (pagina A/B/C/D/E ou PV) ──
       O distribuidor (index.html) e as páginas propagam ?variant=campaign-XX-pagina-a|b|c|pv|pagina-e.
       Normalizamos para o código curto: pagina-a | pagina-b | pagina-c | pagina-d | pv | pagina-e. */
    function getVariantCode() {
        try {
            /* 1º: se a página atual É uma variante, o código vem do próprio arquivo
               (nunca herda variante de visita anterior via URL/localStorage) */
            if (/pagina-e\.html$/i.test(window.location.pathname)) return 'pagina-e';

            var pm = window.location.pathname.match(/pagina-([a-d])\.html/i);
            if (pm) return 'pagina-' + pm[1].toLowerCase();

            /* legado: teste-a.html etc. (eventos antigos) */
            pm = window.location.pathname.match(/teste-([a-d])\.html/i);
            if (pm) return 'pagina-' + pm[1].toLowerCase();

            var v = new URLSearchParams(window.location.search).get('variant') || '';
            if (!v) {
                /* fallback: mesmo storage usado pelo main.js (TTL 24h) */
                var stored = JSON.parse(localStorage.getItem('utm_params') || 'null');
                if (stored && stored.variant && (Date.now() - (stored.timestamp || 0)) < 24 * 3600 * 1000) {
                    v = stored.variant;
                }
            }
            if (!v) return '';
            v = String(v).toLowerCase();
            if (/pagina-e$/.test(v) || /-pagina$/.test(v)) return 'pagina-e';
            var m = v.match(/pagina-([a-d])$/);
            if (m) return 'pagina-' + m[1];
            m = v.match(/presell-([a-d])$/);
            if (m) return 'pagina-' + m[1];
            if (/(?:^|-)pv$/.test(v)) return 'pv';
            return v.slice(0, 30);
        } catch (_) { return ''; }
    }

    /** % da meta (barra de arrecadação) — mesmo cookie ab_prog_v1 do main.js. */
    var AB_PROGRESS_COOKIE = 'ab_prog_v1';
    /* v7: A/B 6.37 / 19.83. Demais releases: A/B 6.37 / 12.65 / 19.83 */
    var AB_PROGRESS_VARIANTS = /\/release-v7\//.test(location.pathname)
        ? [6.37, 19.83]
        : [6.37, 12.65, 19.83];

    function getOrCreateABProgress() {
        try {
            var m = document.cookie.match(/(?:^|;\s*)ab_prog_v1=([^;]*)/);
            var pct = m ? parseFloat(decodeURIComponent(m[1])) : NaN;
            if (!isNaN(pct) && AB_PROGRESS_VARIANTS.indexOf(pct) !== -1) return pct;
            pct = AB_PROGRESS_VARIANTS[Math.floor(Math.random() * AB_PROGRESS_VARIANTS.length)];
            var exp = new Date(Date.now() + 365 * 864e5).toUTCString();
            document.cookie = AB_PROGRESS_COOKIE + '=' + pct + ';path=/;expires=' + exp + ';SameSite=Lax';
            return pct;
        } catch (_) {
            return AB_PROGRESS_VARIANTS[0];
        }
    }

    function getProgressPct() {
        return String(getOrCreateABProgress());
    }

    /* ── Send ── */
    var SESSION_ID  = getSessionId();
    var VISITOR     = getVisitorInfo();
    var PAGE_PATH   = window.location.pathname;
    var VARIANT     = getVariantCode();

    function send(eventName, label, value, extraData) {
        var utms = getUTMs();
        var payload = {
            event_name:    eventName,
            session_id:    SESSION_ID,
            page_path:     PAGE_PATH,
            variant:       VARIANT,
            progress_pct:  getProgressPct(),
            event_label:   label  || '',
            event_value:   String(value !== undefined ? value : ''),
            event_data:    extraData || null,
            referrer:      document.referrer || '',
            utm_source:    utms.utm_source   || '',
            utm_medium:    utms.utm_medium   || '',
            utm_campaign:  utms.utm_campaign || '',
            utm_term:      utms.utm_term     || '',
            utm_content:   utms.utm_content  || '',
            fbclid:        utms.fbclid       || '',
            is_new_visitor: VISITOR.is_new ? 1 : 0,
        };

        var sent = false;
        if (typeof navigator.sendBeacon === 'function') {
            try {
                var blob = new Blob([JSON.stringify(payload)], { type: 'application/json' });
                sent = navigator.sendBeacon(TRACKER_ENDPOINT, blob);
            } catch (_) {}
        }
        if (!sent) {
            fetch(TRACKER_ENDPOINT, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload),
                keepalive: true,
            }).catch(function () {});
        }
    }

    /* ── 1. Page View ── */
    send('page_view', document.title, '', { title: document.title, url: window.location.href });

    /* ── 1b. Heartbeat — mantém a sessão "ao vivo" (atualiza last_seen_at) ── */
    (function () {
        var HEARTBEAT_MS = 20000; /* 20s; janela "ao vivo" no dashboard é 60s */
        var timer = null;
        function beat() {
            if (document.visibilityState === 'hidden') return;
            send('heartbeat', '', '');
        }
        function start() { if (!timer) timer = setInterval(beat, HEARTBEAT_MS); }
        function stop()  { if (timer) { clearInterval(timer); timer = null; } }
        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'visible') { beat(); start(); }
            else { stop(); }
        });
        start();
    })();

    /* ── 2. Rastreamento de seções por posição de scroll (offsetTop) ── */
    var _sections = [];      /* [{el, event, label, sent, isFirst}] */
    var _sectionsReady = false;

    function buildSectionList() {
        _sections = [];
        var blocks = document.querySelectorAll('#campaignStoryInner .story-v2__block');
        blocks.forEach(function (block, i) {
            _sections.push({ el: block, event: 'section_view_' + (i + 1), label: (i + 1) + 'ª sessão da história', sent: false, isFirst: i === 0 });
        });
        var comments = document.getElementById('comentariosSection');
        if (comments) {
            _sections.push({ el: comments, event: 'section_view_comments', label: 'Sessão de comentários', sent: false, isFirst: false });
        }
        _sectionsReady = _sections.length > 0;
    }

    var _contentViewSent = false;

    function checkSections() {
        if (!_sectionsReady) return;
        var sy  = window.pageYOffset || document.documentElement.scrollTop || 0;
        var winH = window.innerHeight || document.documentElement.clientHeight || 600;
        _sections.forEach(function (s) {
            if (s.sent) return;
            /* Dispara quando a metade superior da tela passou do topo do elemento */
            if (sy + winH * 0.5 > s.el.offsetTop) {
                s.sent = true;
                send(s.event, s.label, '');
                /* content_view (funil step 2) dispara junto com a 1ª seção */
                if (s.isFirst && !_contentViewSent) {
                    _contentViewSent = true;
                    send('content_view', 'Viu o conteúdo', '');
                }
            }
        });
    }

    /* rAF loop — verifica seções a cada frame em que o scroll muda */
    var _lastScrollY = -1;
    function rafLoop() {
        var sy = window.pageYOffset || document.documentElement.scrollTop || 0;
        if (sy !== _lastScrollY) {
            _lastScrollY = sy;
            checkSections();
        }
        requestAnimationFrame(rafLoop);
    }

    /* Inicia após DOM pronto para garantir que offsetTop está calculado */
    function startTracking() {
        buildSectionList();
        checkSections(); /* checar posição inicial (página pode já estar scrollada) */
        requestAnimationFrame(rafLoop);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startTracking);
    } else {
        startTracking();
    }

    /* Listener de scroll como redundância */
    window.addEventListener('scroll', checkSections, { passive: true });

    /* ── 3. Time on page (enviado ao sair) ── */
    window.addEventListener('beforeunload', function () {
        var secs = Math.round((Date.now() - sessionStartTime) / 1000);
        send('time_on_page', '', secs, { seconds: secs });
    });

    /* ── 4. CTA principal — Ajudar (abre donateModal) ── */
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[onclick*="openDonateModal"], .btn-ajudar, #fixedMobileCTA, #heroCTA, .hero-cta, .cta-donate');
        if (btn) {
            send('modal_open', btn.textContent.trim().slice(0, 100), '', {
                button_class: btn.className,
                button_id: btn.id || ''
            });
        }
    }, true);

    /* ── 5. Seleção de valor no modal de doação ── */
    document.addEventListener('click', function (e) {
        var link = e.target.closest('.donation-link[data-amount]');
        if (link) {
            var amount = parseInt(link.getAttribute('data-amount') || '0', 10);
            send('value_selected', 'R$' + amount, amount * 100, { amount_cents: amount * 100 });
        }
        /* Valor personalizado */
        var customSubmit = e.target.closest('#pixCustomAmountSubmit');
        if (customSubmit) {
            var input = document.getElementById('pixCustomAmountInput');
            var rawVal = input ? input.value : '0';
            var num = parseFloat(rawVal.replace(/[^\d,]/g, '').replace(',', '.')) || 0;
            var cents = Math.round(num * 100);
            send('value_selected', 'Personalizado R$' + num.toFixed(2), cents, { custom: true, amount_cents: cents });
        }
    }, true);

    /* ── 6. Checkout iniciado (quando openCheckout é chamado) ── */
    var _origOpenCheckout = null;
    function patchOpenCheckout() {
        if (typeof window.openCheckout === 'function' && !window.openCheckout._cdbPatched) {
            _origOpenCheckout = window.openCheckout;
            window.openCheckout = function (amount) {
                send('checkout_initiated', 'PIX iniciado R$' + amount, Math.round(Number(amount)) * 100, { amount_brl: amount });
                return _origOpenCheckout.apply(this, arguments);
            };
            window.openCheckout._cdbPatched = true;
        }
    }

    /* ── 7. PIX exibido ── */
    var pixObserver = new MutationObserver(function (mutations) {
        mutations.forEach(function (m) {
            if (m.type !== 'childList') return;
            m.addedNodes.forEach(function (node) {
                if (node.nodeType !== 1) return;
                /* Verifica se o nó adicionado contém o botão de copiar PIX
                   OU se ele próprio é o botão (querySelector não inclui self) */
                var hasPix = (node.querySelector && node.querySelector('#pixCopyButton'))
                          || node.id === 'pixCopyButton';
                if (hasPix) {
                    var root = node.id === 'pixCopyButton' ? node.parentElement : node;
                    var amountEl = root ? root.querySelector('.pix-total strong') : null;
                    var amountText = amountEl ? amountEl.textContent.trim() : '';
                    send('pix_shown', 'PIX QR Code exibido ' + amountText, '', { amount_text: amountText });
                }
            });
        });
    });
    pixObserver.observe(document.body, { childList: true, subtree: true });


    /* ── 8. Exit intent popup ── */
    var _exitPopupSent = false;
    var exitObserver = new MutationObserver(function (mutations) {
        mutations.forEach(function (m) {
            if (m.type !== 'attributes') return;
            var el = m.target;
            if (el.id === 'exitIntentPopup') {
                var visible = el.classList.contains('is-visible');
                if (visible && !_exitPopupSent) {
                    _exitPopupSent = true;
                    send('exit_popup_shown', 'Exit intent popup exibido', '');
                }
            }
        });
    });
    var exitPopup = document.getElementById('exitIntentPopup');
    if (exitPopup) exitObserver.observe(exitPopup, { attributes: true, attributeFilter: ['class'] });

    /* Clique no botão de doação do exit popup */
    document.addEventListener('click', function (e) {
        if (e.target.id === 'exitPopupDonate' || e.target.closest('#exitPopupDonate')) {
            send('exit_popup_convert', 'Exit popup — clicou DOAR', '');
        }
        if (e.target.id === 'exitPopupDismiss' || e.target.closest('#exitPopupDismiss')) {
            send('exit_popup_dismiss', 'Exit popup — clicou Não quero ajudar', '');
        }
        if (e.target.id === 'exitPopupClose' || e.target.closest('#exitPopupClose')) {
            send('exit_popup_close', 'Exit popup — fechou (X)', '');
        }
    });

    /* ── 9. Compartilhar ── */
    document.addEventListener('click', function (e) {
        if (e.target.id === 'shareButton' || e.target.closest('#shareButton')) {
            send('share_click', 'Clicou em Compartilhar', '');
        }
    });

    /* ── 10. Tabs Sobre / Atualizações ── */
    document.addEventListener('click', function (e) {
        var tab = e.target.closest('#tabAbout, #tabUpdates');
        if (tab) {
            send('tab_click', tab.textContent.trim(), tab.id);
        }
    });

    /* ── 11. Clique no CTA fixo mobile ── */
    document.addEventListener('click', function (e) {
        var fixedBtn = e.target.closest('#fixed-mobile button, #fixed-mobile a, .fixed-cta');
        if (fixedBtn) {
            send('fixed_cta_click', fixedBtn.textContent.trim().slice(0, 80), '');
        }
    });

    /* ── 12. Abandono do modal de doação ── */
    var _modalOpenTime = null;
    document.addEventListener('click', function (e) {
        if (e.target.id === 'closeDonationModal' || e.target.closest('#closeDonationModal')) {
            var secs = _modalOpenTime ? Math.round((Date.now() - _modalOpenTime) / 1000) : 0;
            send('modal_abandon', 'Fechou modal sem selecionar valor', secs, { seconds_open: secs });
        }
    });

    /* ── Patch após DOMContentLoaded ── */
    function init() {
        patchOpenCheckout();
        /* Acompanhar abertura do donateModal */
        var origOpen = window.openDonateModal;
        if (typeof origOpen === 'function' && !origOpen._cdbPatched) {
            window.openDonateModal = function () {
                _modalOpenTime = Date.now();
                send('modal_open', 'Abriu modal de doação', '');
                return origOpen.apply(this, arguments);
            };
            window.openDonateModal._cdbPatched = true;
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    /* Expor globalmente para uso externo */
    window.CdbTracker = { send: send, sessionId: SESSION_ID, variant: VARIANT };
})();
