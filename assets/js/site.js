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
