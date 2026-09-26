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
      incorporation: { label: 'Start a company', steps: ['country', 'activity', 'structure', 'ownership', 'visa', 'timeline'] },
      compare: { label: 'Compare jurisdictions', link: '/jurisdictions/' },
      licensing: { label: 'Business licence', steps: ['country', 'activity', 'timeline'] },
      banking: { label: 'Corporate banking', steps: ['country', 'ownership', 'timeline'] },
      visa: { label: 'Visa & residency', steps: ['country', 'visa', 'timeline'] },
      compliance: { label: 'Compliance', steps: ['country', 'timeline'] },
      expert: { label: 'Speak to an expert', steps: [] }
    };
    var state = {};
    function el(tag, cls, text) { var n = doc.createElement(tag); if (cls) n.className = cls; if (text) n.textContent = text; return n; }
    function say(text, who) { body.appendChild(el('p', 'assist-msg' + (who ? ' ' + who : ''), text)); body.scrollTop = body.scrollHeight; }
    function options(list, onPick) {
      var wrap = el('div', 'assist-options');
      list.forEach(function (o) {
        var b = el('button', 'assist-option', o[1]); b.type = 'button';
        b.addEventListener('click', function () { wrap.remove(); say(o[1], 'user'); onPick(o[0], o[1]); });
        wrap.appendChild(b);
      });
      body.appendChild(wrap); body.scrollTop = body.scrollHeight;
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
      body.appendChild(wrap); body.scrollTop = body.scrollHeight;
    }
    function ask(flow, i) {
      var steps = FLOWS[flow].steps;
      if (i >= steps.length) return finish(flow);
      var q = Q[steps[i]];
      say(q.text);
      options(q.options, function (value, label) { state[steps[i]] = value; state.labels[steps[i]] = label; ask(flow, i + 1); });
    }
    function start() {
      state = { labels: {} }; body.innerHTML = '';
      say('Hello. What would you like help with?');
      options(Object.keys(FLOWS).map(function (k) { return [k, FLOWS[k].label]; }), function (flow) {
        if (FLOWS[flow].link) { say('Opening the jurisdiction comparison…'); window.location.href = FLOWS[flow].link; return; }
        ask(flow, 0);
      });
    }
    function setAssist(open) {
      panel.hidden = !open;
      aToggle.setAttribute('aria-expanded', String(open));
      if (open) { if (!assist.dataset.started) { assist.dataset.started = '1'; start(); } var f = $('.assist-option', panel); f && f.focus({ preventScroll: true }); }
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

  /* ---- Guided setup (homepage): one question at a time, then an inline setup path ---- */
  var gs = $('[data-guided-setup]');
  if (gs) (function () {
    var box = gs.closest('.gs'), steps = $$('.gs-step', gs), bars = $$('.gs-progress span', box), count = $('[data-gs-count]', box);
    var back = $('[data-gs-back]', gs), next = $('[data-gs-next]', gs), submit = $('[data-gs-submit]', gs), result = $('[data-gs-result]', box);
    var data = {}; try { data = JSON.parse($('#setup-data').textContent); } catch (e) { return; }
    var idx = 0;
    box.classList.add('is-stepped');
    function show(i, focus) {
      idx = i;
      steps.forEach(function (st, n) { st.hidden = n !== i; });
      bars.forEach(function (b, n) { b.classList.toggle('is-done', n <= i); });
      count.textContent = 'Step ' + (i + 1) + ' of ' + steps.length;
      back.hidden = i === 0; next.hidden = i === steps.length - 1; submit.hidden = i !== steps.length - 1;
      if (focus) { var first = $('input:checked', steps[i]) || $('input', steps[i]); if (first) first.focus(); }
    }
    function answered(st) { return !!$('input:checked', st); }
    next.addEventListener('click', function () {
      if (idx === 0 && !answered(steps[0])) { $('input', steps[0]).reportValidity(); return; }
      show(idx + 1, true);
    });
    back.addEventListener('click', function () { show(idx - 1, true); });
    // A pointer click on an option moves on; keyboard selection (arrow keys) stays put until Next.
    steps.forEach(function (st, n) {
      st.addEventListener('click', function (e) {
        if (e.detail > 0 && e.target.matches('input[type="radio"]') && n < steps.length - 1) setTimeout(function () { show(n + 1, false); }, 180);
      });
    });
    function val(name) { var c = $('input[name="' + name + '"]:checked', gs); return c ? c.value : ''; }
    function link(item) { var a = doc.createElement('a'); a.href = item.url; a.textContent = item.text; return a; }
    function fill(key, node) { var el = $('[data-r="' + key + '"]', result); el.textContent = ''; if (node) el.appendChild(node); var w = $('[data-r-wrap="' + key + '"]', result); if (w) w.hidden = !node; return el; }
    gs.addEventListener('submit', function (e) {
      var j = data.jurisdictions[val('country')];
      if (!j) return; // unknown value: let the server handle it
      e.preventDefault();
      var q = { country: val('country') };
      ['activity', 'ownership', 'visa'].forEach(function (k) { var v = val(k); if (v && v !== 'undecided') q[k] = v; });
      var qs = Object.keys(q).map(function (k) { return k + '=' + encodeURIComponent(q[k]); }).join('&');
      $('[data-r="title"]', result).textContent = 'Company setup in ' + j.label;
      var auth = doc.createElement('a'); auth.href = j.authorityUrl; auth.target = '_blank'; auth.rel = 'noopener noreferrer'; auth.textContent = j.authority; fill('authority', auth);
      fill('structure', j.structure ? link(j.structure) : null);
      fill('route', j.route ? link(j.route) : null);
      var ul = fill('requirements', null); j.requirements.forEach(function (r) { var li = doc.createElement('li'); li.appendChild(link(r)); ul.appendChild(li); });
      $('[data-r-wrap="requirements"]', result).hidden = !j.requirements.length;
      var svc = ['company-incorporation'];
      if (q.activity === 'regulated' || q.activity === 'trading') svc.push('business-licensing');
      if (q.visa === 'founders' || q.visa === 'employees') svc.push('visa-residency');
      if (q.ownership === 'corporate') svc.push('business-expansion');
      svc.push('corporate-banking', 'compliance-documentation');
      var sv = fill('services', null); svc.forEach(function (k, n) { if (!data.services[k]) return; if (n) sv.appendChild(doc.createTextNode(' · ')); sv.appendChild(link(data.services[k])); });
      $('[data-r="verify"]', result).textContent = j.verify.length ? j.verify.join(', ') : 'Nothing flagged';
      $('[data-r="plan"]', result).href = '/get-started/?' + qs;
      $('[data-r="full"]', result).href = j.pending ? j.hub : '/explore/?' + qs;
      gs.hidden = true; bars.forEach(function (b) { b.classList.add('is-done'); }); count.textContent = 'Your path';
      result.hidden = false; result.focus();
    });
    $('[data-gs-restart]', result).addEventListener('click', function () { result.hidden = true; gs.hidden = false; gs.reset(); show(0, true); });
    show(0, false);
    requestAnimationFrame(function () { box.classList.add('is-animated'); });
  })();

  /* ---- Comparison filters: topic groups, jurisdiction rows, sort ---- */
  $$('[data-compare-controls]').forEach(function (ctl) {
    var wrap = ctl.nextElementSibling; if (!wrap || !wrap.hasAttribute('data-compare')) return;
    var tbody = $('tbody', wrap);
    ctl.hidden = false;
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
