/* INCORPSYS site script: navigation, INCORPSYS Assist, enquiry wizard, tabs. No dependencies. */
(function () {
  'use strict';
  var doc = document, root = doc.documentElement;
  var $ = function (s, c) { return (c || doc).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || doc).querySelectorAll(s)); };
  var mobileNav = window.matchMedia('(max-width: 1180px)');

  /* ---- Primary navigation and mega menus ---- */
  var header = $('#site-header'), nav = $('#primary-nav'), toggle = $('.nav-toggle');
  function closeMenus(except) {
    $$('.nav-item.open').forEach(function (item) {
      if (item === except) return;
      item.classList.remove('open');
      $('.nav-trigger', item).setAttribute('aria-expanded', 'false');
    });
  }
  function setMobileNav(open) {
    if (!nav || !toggle) return;
    if (open && header) root.style.setProperty('--masthead-top', header.getBoundingClientRect().bottom + 'px');
    nav.classList.toggle('open', open);
    doc.body.classList.toggle('menu-open', open);
    toggle.setAttribute('aria-expanded', String(open));
    if (!open) closeMenus();
  }
  toggle && toggle.addEventListener('click', function () { setMobileNav(!nav.classList.contains('open')); });
  $$('.nav-item').forEach(function (item) {
    var trigger = $('.nav-trigger', item), timer;
    if (!trigger) return; // plain links (Contact) have no mega menu
    trigger.addEventListener('click', function () {
      var open = !item.classList.contains('open');
      closeMenus(item);
      item.classList.toggle('open', open);
      trigger.setAttribute('aria-expanded', String(open));
    });
    // Desktop: open on hover with a short intent delay.
    item.addEventListener('mouseenter', function () {
      if (mobileNav.matches) return;
      clearTimeout(timer);
      timer = setTimeout(function () { closeMenus(item); item.classList.add('open'); trigger.setAttribute('aria-expanded', 'true'); }, 90);
    });
    item.addEventListener('mouseleave', function () {
      if (mobileNav.matches) return;
      clearTimeout(timer);
      timer = setTimeout(function () { item.classList.remove('open'); trigger.setAttribute('aria-expanded', 'false'); }, 160);
    });
    // Close when focus leaves the menu (keyboard users).
    item.addEventListener('focusout', function (e) {
      if (!mobileNav.matches && !item.contains(e.relatedTarget)) { item.classList.remove('open'); trigger.setAttribute('aria-expanded', 'false'); }
    });
  });
  doc.addEventListener('click', function (e) { if (!e.target.closest('.nav-item')) closeMenus(); });
  $$('#primary-nav a').forEach(function (a) { a.addEventListener('click', function () { setMobileNav(false); }); });
  mobileNav.addEventListener && mobileNav.addEventListener('change', function () { setMobileNav(false); });

  /* ---- INCORPSYS Assist: progressive guided flow ---- */
  var assist = $('#assist');
  if (assist) {
    var panel = $('#assist-panel'), body = $('.assist-body', assist), aToggle = $('.assist-toggle', assist);
    var countries = JSON.parse(assist.getAttribute('data-countries') || '{}');
    var countryOpts = Object.keys(countries).map(function (k) { return [k, countries[k]]; }).concat([['undecided', 'Not decided yet']]);
    var Q = {
      country: { text: 'Which jurisdiction are you considering?', options: countryOpts },
      activity: { text: 'What will the business do?', options: [['trading', 'Trading / import-export'], ['professional', 'Professional or consulting services'], ['technology', 'Technology / software'], ['ecommerce', 'E-commerce'], ['holding', 'Holding company'], ['regulated', 'Financial or other regulated activity'], ['other', 'Something else']] },
      structure: { text: 'Do you have a structure in mind?', options: [['new-company', 'A new company'], ['branch', 'A branch of an existing company'], ['undecided', 'Not sure yet']] },
      ownership: { text: 'Who will own the company?', options: [['foreign-individual', 'Individual(s) based abroad'], ['local-individual', 'Individual(s) based in that country'], ['corporate', 'An existing company'], ['undecided', 'Not sure yet']] },
      visa: { text: 'Will you need a visa or residency?', options: [['founders', 'Yes, for founders'], ['employees', 'Yes, for employees'], ['no', 'No'], ['undecided', 'Not sure yet']] },
      timeline: { text: 'When do you want to start?', options: [['asap', 'Within a month'], ['1-3', 'In 1–3 months'], ['3-6', 'In 3–6 months'], ['exploring', 'Just exploring']] }
    };
    var FLOWS = {
      incorporation: { label: 'Start a Company', steps: ['country', 'activity', 'structure', 'ownership', 'visa', 'timeline'] },
      compare: { label: 'Compare Jurisdictions', link: '/jurisdictions/' },
      licensing: { label: 'Business Licence', steps: ['country', 'activity', 'timeline'] },
      banking: { label: 'Corporate Banking', steps: ['country', 'ownership', 'timeline'] },
      visa: { label: 'Visa & Residency', steps: ['country', 'visa', 'timeline'] },
      compliance: { label: 'Compliance', steps: ['country', 'timeline'] },
      expert: { label: 'Speak to an Expert', steps: [] }
    };
    var state = {};
    function el(tag, cls, text) { var n = doc.createElement(tag); if (cls) n.className = cls; if (text) n.textContent = text; return n; }
    var lastQ = null;
    function say(text, who) { var m = el('p', 'assist-msg' + (who ? ' ' + who : ''), text); body.appendChild(m); if (!who) lastQ = m; }
    // Keep the newest question at the top of the chat so its options read from the first one (never jump to the last option).
    function reveal() { body.scrollTop = lastQ ? Math.max(0, lastQ.offsetTop - 12) : 0; }
    function options(list, onPick) {
      var wrap = el('div', 'assist-options');
      list.forEach(function (o) {
        var b = el('button', 'assist-option', o[1]); b.type = 'button';
        b.addEventListener('click', function () { wrap.remove(); say(o[1], 'user'); onPick(o[0], o[1]); });
        wrap.appendChild(b);
      });
      body.appendChild(wrap); reveal();
      var first = $('button', wrap); first && first.focus({ preventScroll: true });
    }
    function finish(flow) {
      var params = new URLSearchParams(); params.set('need', flow);
      Object.keys(state).forEach(function (k) { if (k !== 'labels') params.set(k, state[k]); });
      var summary = Object.keys(state.labels || {}).map(function (k) { return state.labels[k]; }).join(' · ');
      say(flow === 'expert' ? 'Choose how you would like to reach the team.' : 'Thank you. Continue to the enquiry form with these answers filled in, or send them on WhatsApp.');
      var wrap = el('div', 'assist-options');
      var go = el('a', 'assist-option', 'Continue to enquiry'); go.href = '/get-started/?' + params.toString(); wrap.appendChild(go);
      var wa = el('a', 'assist-option', 'Send on WhatsApp'); wa.target = '_blank'; wa.rel = 'noopener';
      wa.href = 'https://wa.me/' + assist.getAttribute('data-wa') + '?text=' + encodeURIComponent('Hello INCORPSYS, I need help with: ' + FLOWS[flow].label + (summary ? ' (' + summary + ')' : ''));
      wrap.appendChild(wa);
      if (state.country && state.country !== 'undecided') { var g = el('a', 'assist-option', 'Read the ' + state.labels.country + ' guides'); g.href = '/' + state.country + '/'; wrap.appendChild(g); }
      var again = el('button', 'assist-option', 'Start again'); again.type = 'button'; again.addEventListener('click', start); wrap.appendChild(again);
      body.appendChild(wrap); reveal();
    }
    function ask(flow, i) {
      var steps = FLOWS[flow].steps;
      if (i >= steps.length) return finish(flow);
      var q = Q[steps[i]];
      say(q.text);
      options(q.options, function (value, label) { state[steps[i]] = value; state.labels[steps[i]] = label; ask(flow, i + 1); });
    }
    function start() {
      state = { labels: {} }; body.innerHTML = ''; lastQ = null;
      say('Hello. What would you like help with?');
      options(Object.keys(FLOWS).map(function (k) { return [k, FLOWS[k].label]; }), function (flow) {
        if (FLOWS[flow].link) { say('Opening the jurisdiction comparison…'); window.location.href = FLOWS[flow].link; return; }
        ask(flow, 0);
      });
    }
    function setAssist(open) {
      panel.hidden = !open;
      aToggle.setAttribute('aria-expanded', String(open));
      doc.body.classList.toggle('assist-open', open);
      if (open) { if (!assist.dataset.started) { assist.dataset.started = '1'; start(); } else reveal(); var f = $('.assist-option', panel); f && f.focus({ preventScroll: true }); }
    }
    aToggle.addEventListener('click', function () { setAssist(panel.hidden); });
    $('.assist-close', assist).addEventListener('click', function () { setAssist(false); aToggle.focus(); });
    doc.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !panel.hidden) { setAssist(false); aToggle.focus(); } });
  }
  doc.addEventListener('keydown', function (e) { if (e.key === 'Escape') { closeMenus(); if (nav && nav.classList.contains('open')) { setMobileNav(false); toggle.focus(); } } });

  /* ---- Cookie consent and consent-gated Google Analytics ---- */
  var banner = $('#cookie-banner');
  if (banner) {
    var gaId = banner.getAttribute('data-ga') || '';
    var readConsent = function () { var m = doc.cookie.match(/(?:^|; )incorpsys_consent=(all|essential)/); return m ? m[1] : null; };
    var loadGA = function () {
      if (!gaId || window.gtag) return;
      window.dataLayer = window.dataLayer || [];
      window.gtag = function () { window.dataLayer.push(arguments); };
      window.gtag('consent', 'default', { ad_storage: 'denied', ad_user_data: 'denied', ad_personalization: 'denied', analytics_storage: 'granted' });
      window.gtag('js', new Date());
      window.gtag('config', gaId);
      var sc = doc.createElement('script'); sc.async = true; sc.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(gaId); doc.head.appendChild(sc);
    };
    var clearGA = function () {
      if (window.gtag) window.gtag('consent', 'update', { analytics_storage: 'denied' });
      doc.cookie.split('; ').forEach(function (c) {
        var name = c.split('=')[0]; if (name.indexOf('_ga') !== 0) return;
        var host = location.hostname.split('.');
        for (var i = 0; i < host.length - 1; i++) { var d = host.slice(i).join('.'); doc.cookie = name + '=; Max-Age=0; Path=/; Domain=.' + d; }
        doc.cookie = name + '=; Max-Age=0; Path=/';
      });
    };
    var setBanner = function (open) { banner.hidden = !open; doc.body.classList.toggle('cookie-open', open); };
    var choose = function (value) {
      doc.cookie = 'incorpsys_consent=' + value + '; Max-Age=15552000; Path=/; SameSite=Lax' + (location.protocol === 'https:' ? '; Secure' : '');
      setBanner(false);
      if (value === 'all') loadGA(); else clearGA();
    };
    $$('[data-consent]', banner).forEach(function (b) { b.addEventListener('click', function () { choose(b.getAttribute('data-consent')); }); });
    $$('[data-cookie-settings]').forEach(function (b) { b.addEventListener('click', function () { setBanner(true); var f = $('[data-consent]', banner); f && f.focus(); }); });
    var consent = readConsent();
    if (consent === 'all') loadGA(); else if (!consent) setBanner(true);
  }

  /* ---- Multi-step enquiry wizard ---- */
  var wizard = $('[data-wizard]');
  if (wizard) {
    var steps = $$('.wizard-step', wizard), progress = $$('.wizard-progress li'), idx = 0;
    var back = $('[data-wizard-back]', wizard), next = $('[data-wizard-next]', wizard), submit = $('[data-wizard-submit]', wizard);
    function valid(step) {
      var ok = true;
      $$('input,select,textarea', step).forEach(function (f) {
        var field = f.closest('.field') || f.closest('fieldset');
        var good = f.checkValidity();
        if (field) field.classList.toggle('has-error', !good);
        if (!good && ok) { ok = false; f.reportValidity(); }
      });
      return ok;
    }
    function show(i, initial) {
      idx = i;
      steps.forEach(function (s, n) { s.classList.toggle('is-active', n === i); });
      progress.forEach(function (p, n) { p.classList.toggle('is-current', n === i); p.classList.toggle('is-done', n < i); if (n === i) p.setAttribute('aria-current', 'step'); else p.removeAttribute('aria-current'); });
      back.hidden = i === 0; next.hidden = i === steps.length - 1; submit.hidden = i !== steps.length - 1;
      var legend = $('legend', steps[i]); if (legend && !initial) { legend.setAttribute('tabindex', '-1'); legend.focus({ preventScroll: true }); }
      if (!initial) wizard.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    next.addEventListener('click', function () { if (valid(steps[idx])) show(idx + 1); });
    back.addEventListener('click', function () { show(idx - 1); });
    // Pressing Enter moves to the next step instead of submitting early.
    wizard.addEventListener('keydown', function (e) { if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA' && idx < steps.length - 1) { e.preventDefault(); next.click(); } });
    wizard.addEventListener('submit', function (e) {
      if (!valid(steps[idx])) { e.preventDefault(); return; }
      wizard.classList.add('is-submitting'); submit.disabled = true;
    });
    // Start at the first step with an unanswered required field (answers can arrive pre-filled from Assist or the setup finder).
    var start = 0;
    for (var s = 0; s < steps.length; s++) { var req = $$('[required]', steps[s]); var answered = req.every(function (f) { return f.type === 'radio' ? !!$('input[name="' + f.name + '"]:checked', steps[s]) : f.value !== ''; }); if (!answered || !req.length) { start = s; break; } }
    show(start, true);
  }

  /* ---- Homepage: setup configurator (inline setup path) ---- */
  var cfg = $('[data-configurator]');
  var setupData = null;
  try { setupData = JSON.parse(($('#setup-data') || {}).textContent || 'null'); } catch (e) { setupData = null; }
  function link(item) { var a = doc.createElement('a'); a.href = item.url; a.textContent = item.text; return a; }
  if (cfg && setupData) (function () {
    var box = $('[data-cfg-result]'), q = function (n) { return cfg.elements[n].value; };
    function put(key, node) { var el = $('[data-r="' + key + '"]', box); el.textContent = ''; if (node) el.appendChild(node); var w = $('[data-r-wrap="' + key + '"]', box); if (w) w.hidden = !node; return el; }
    function list(key, items) { var ul = put(key, null); items.forEach(function (it) { var li = doc.createElement('li'); li.appendChild(link(it)); ul.appendChild(li); }); var w = $('[data-r-wrap="' + key + '"]', box); if (w) w.hidden = !items.length; }
    cfg.addEventListener('submit', function (e) {
      var j = setupData.jurisdictions[q('country')];
      if (!j) return; // let the browser show the required-field message / server fallback
      e.preventDefault();
      var structure = q('structure'), owner = q('ownership');
      $('[data-r="title"]', box).textContent = 'Company setup in ' + j.label;
      var auth = doc.createElement('a'); auth.href = j.authorityUrl; auth.target = '_blank'; auth.rel = 'noopener noreferrer'; auth.textContent = j.authority; put('authority', auth);
      put('structure', j.structure ? link(j.structure) : null);
      put('route', j.route ? link(j.route) : null);
      list('requirements', j.requirements);
      var extras = [];
      ['structure:' + structure, 'ownership:' + owner].forEach(function (k) { if (setupData.guides && setupData.guides[k]) extras.push(setupData.guides[k]); });
      list('extras', extras);
      $('[data-r="verify"]', box).textContent = j.verify.length ? j.verify.join(', ') : 'Nothing flagged';
      var qs = 'country=' + encodeURIComponent(q('country')) + (structure !== 'undecided' ? '&structure=' + structure : '') + (owner !== 'undecided' ? '&ownership=' + owner : '');
      $('[data-r="plan"]', box).href = '/get-started/?' + qs;
      $('[data-r="full"]', box).href = j.pending ? j.hub : '/explore/?' + qs;
      box.hidden = false; box.focus();
    });
    $('[data-cfg-close]', box).addEventListener('click', function () { box.hidden = true; cfg.elements.country.focus(); });
  })();

  /* ---- Homepage: comparison matrix — topic filter + phone tabs (Previous / Next) ---- */
  $$('[data-cm]').forEach(function (wrap) {
    var section = wrap.closest('section'), ctl = $('[data-cm-controls]', section);
    if (ctl) $$('[data-cm-show]', ctl).forEach(function (b) {
      b.addEventListener('click', function () {
        $$('[data-cm-show]', ctl).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
        wrap.setAttribute('data-show', b.getAttribute('data-cm-show'));
      });
    });
    // Build jurisdiction tabs from the table (single source of truth; table stays the no-JS fallback).
    var heads = $$('thead th[data-j]', wrap), rows = $$('tbody tr', wrap);
    if (!heads.length) return;
    var tabs = doc.createElement('div'); tabs.className = 'cm-tabs';
    var tl = doc.createElement('div'); tl.className = 'cm-tablist'; tl.setAttribute('role', 'tablist'); tl.setAttribute('aria-label', 'Jurisdictions');
    tabs.appendChild(tl);
    var panels = [], buttons = [];
    heads.forEach(function (h, i) {
      var key = h.getAttribute('data-j'), name = $('.cm-j', h).textContent, sub = $('small', h).textContent;
      var b = doc.createElement('button'); b.type = 'button'; b.className = 'chip'; b.id = 'cmt-' + key; b.setAttribute('role', 'tab'); b.setAttribute('aria-controls', 'cmp-' + key); b.textContent = name;
      tl.appendChild(b); buttons.push(b);
      var p = doc.createElement('div'); p.className = 'cm-panel'; p.id = 'cmp-' + key; p.setAttribute('role', 'tabpanel'); p.setAttribute('aria-labelledby', b.id); p.tabIndex = 0;
      var h3 = doc.createElement('h3'); h3.textContent = name; var sm = doc.createElement('small'); sm.textContent = sub; h3.appendChild(sm); p.appendChild(h3);
      var dl = doc.createElement('dl');
      rows.forEach(function (r) {
        var d = doc.createElement('div'), dt = doc.createElement('dt'), dd = doc.createElement('dd');
        dt.textContent = $('th', r).textContent; var cell = $('td[data-j="' + key + '"]', r); dd.innerHTML = cell ? cell.innerHTML : '';
        d.appendChild(dt); d.appendChild(dd); dl.appendChild(d);
      });
      p.appendChild(dl);
      var pager = doc.createElement('div'); pager.className = 'cm-pager';
      var prev = doc.createElement('button'); prev.type = 'button'; prev.className = 'btn btn-secondary btn-sm'; prev.textContent = '← Previous';
      var next = doc.createElement('button'); next.type = 'button'; next.className = 'btn btn-secondary btn-sm'; next.textContent = 'Next →';
      prev.addEventListener('click', function () { select((i - 1 + heads.length) % heads.length, true); });
      next.addEventListener('click', function () { select((i + 1) % heads.length, true); });
      pager.appendChild(prev); pager.appendChild(next); p.appendChild(pager);
      tabs.appendChild(p); panels.push(p);
    });
    function select(i, focus) {
      buttons.forEach(function (b, n) { var on = n === i; b.setAttribute('aria-selected', String(on)); b.tabIndex = on ? 0 : -1; panels[n].hidden = !on; });
      if (focus) { buttons[i].focus(); buttons[i].scrollIntoView({ block: 'nearest', inline: 'nearest' }); }
    }
    buttons.forEach(function (b, i) {
      b.addEventListener('click', function () { select(i, false); });
      b.addEventListener('keydown', function (e) {
        var d = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
        if (d) { e.preventDefault(); select((i + d + buttons.length) % buttons.length, true); }
      });
    });
    select(0, false);
    wrap.parentNode.insertBefore(tabs, wrap.nextSibling);
    wrap.classList.add('is-tabbed');
  });

  /* ---- Homepage: founder decision module ---- */
  var dec = $('[data-decision]');
  if (dec && setupData) (function () {
    var regions = { 'middle-east': ['uae'], asia: ['singapore', 'hong-kong', 'malaysia'], europe: ['uk'], americas: ['usa'], global: ['uae', 'singapore', 'hong-kong', 'uk', 'usa', 'malaysia'] };
    var out = $('[data-dec-out]', dec);
    dec.addEventListener('submit', function (e) {
      e.preventDefault();
      var v = function (n) { return dec.elements[n].value; };
      var js = $('[data-dec-j]', out), gs = $('[data-dec-g]', out); js.textContent = ''; gs.textContent = '';
      (regions[v('market')] || []).forEach(function (k) { var j = setupData.jurisdictions[k]; if (!j) return; var li = doc.createElement('li'); li.appendChild(link({ text: j.label, url: j.hub })); js.appendChild(li); });
      var keys = ['choose', 'based:' + v('based'), 'ownership:' + v('residency'), 'activity:' + (setupData.guides['activity:' + v('activity')] ? v('activity') : 'any')];
      if (v('ops') === 'yes') keys.push('ops:yes', 'ops:visa');
      var seen = {};
      keys.forEach(function (k) { var g = setupData.guides[k]; if (!g || seen[g.url]) return; seen[g.url] = 1; var li = doc.createElement('li'); li.appendChild(link(g)); gs.appendChild(li); });
      var qs = 'activity=' + encodeURIComponent(v('activity')) + (v('residency') !== 'undecided' ? '&ownership=' + v('residency') : '');
      $('[data-dec-cta]', out).href = '/get-started/?' + qs;
      out.hidden = false; out.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    });
  })();

  /* ---- Scroll reveal (process flow); reduced motion shows everything immediately ---- */
  var reveals = $$('[data-reveal]');
  if (reveals.length) {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce || !('IntersectionObserver' in window)) reveals.forEach(function (r) { r.classList.add('is-in'); });
    else {
      var io = new IntersectionObserver(function (entries) { entries.forEach(function (en) { if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); } }); }, { threshold: 0.2 });
      reveals.forEach(function (r) { io.observe(r); });
    }
  }

  /* ---- Knowledge Hub category filter ---- */
  $$('[data-hub-filter]').forEach(function (bar) {
    var cats = $$('.hub-cat[data-cat]');
    $$('[data-cat]', bar).forEach(function (b) {
      b.addEventListener('click', function () {
        var c = b.getAttribute('data-cat');
        $$('[data-cat]', bar).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
        cats.forEach(function (sec) { sec.hidden = c !== 'all' && sec.getAttribute('data-cat') !== c; });
      });
    });
  });

  /* ---- Comparison filters: topic groups, jurisdiction rows, sort ---- */
  $$('[data-compare-controls]').forEach(function (ctl) {
    var wrap = ctl.nextElementSibling; if (!wrap || !wrap.hasAttribute('data-compare')) return;
    var tbody = $('tbody', wrap);
    $$('[data-show]', ctl).forEach(function (b) {
      b.addEventListener('click', function () {
        $$('[data-show]', ctl).forEach(function (x) { x.setAttribute('aria-pressed', String(x === b)); });
        wrap.setAttribute('data-show', b.getAttribute('data-show'));
      });
    });
    $$('[data-row]', ctl).forEach(function (b) {
      b.addEventListener('click', function () {
        var on = b.getAttribute('aria-pressed') !== 'true';
        // Keep at least one jurisdiction visible.
        if (!on && $$('[data-row][aria-pressed="true"]', ctl).length === 1) return;
        b.setAttribute('aria-pressed', String(on));
        var row = $('tr[data-row="' + b.getAttribute('data-row') + '"]', tbody); if (row) row.hidden = !on;
      });
    });
    var sort = $('[data-sort]', ctl);
    sort.addEventListener('change', function () {
      var rows = $$('tr', tbody), mode = sort.value;
      rows.sort(function (a, b) {
        if (mode === 'verified') return (+b.dataset.verified - +a.dataset.verified) || (+a.dataset.order - +b.dataset.order);
        if (mode === 'az') return $('th', a).textContent.localeCompare($('th', b).textContent);
        return +a.dataset.order - +b.dataset.order;
      });
      rows.forEach(function (r) { tbody.appendChild(r); });
    });
  });

  /* ---- Tabs ---- */
  $$('[role="tablist"]').forEach(function (list) {
    var tabs = $$('[role="tab"]', list);
    function select(t) {
      tabs.forEach(function (x) { var on = x === t; x.setAttribute('aria-selected', String(on)); x.tabIndex = on ? 0 : -1; doc.getElementById(x.getAttribute('aria-controls')).hidden = !on; });
    }
    tabs.forEach(function (t, i) {
      t.addEventListener('click', function () { select(t); });
      t.addEventListener('keydown', function (e) {
        var d = e.key === 'ArrowRight' ? 1 : e.key === 'ArrowLeft' ? -1 : 0;
        if (d) { var n = tabs[(i + d + tabs.length) % tabs.length]; select(n); n.focus(); }
      });
    });
  });
})();
