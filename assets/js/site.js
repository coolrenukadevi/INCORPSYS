document.addEventListener('DOMContentLoaded',()=>{
  const root=document.getElementById('chat');
  const toggle=document.querySelector('.nav-toggle'),nav=document.getElementById('primary-nav');
  const setNav=o=>{if(!toggle||!nav)return;nav.classList.toggle('open',o);toggle.setAttribute('aria-expanded',String(o));toggle.setAttribute('aria-label',o?'Close menu':'Open menu')};
  toggle?.addEventListener('click',()=>setNav(!nav.classList.contains('open')));
  nav?.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>setNav(false)));
  let setChat=()=>{};
  if(root){const t=root.querySelector('.chat-toggle'),c=root.querySelector('.chat-close'),p=root.querySelector('.chat-panel');setChat=o=>{root.classList.toggle('open',o);t.setAttribute('aria-expanded',String(o));p.setAttribute('aria-hidden',String(!o))};t?.addEventListener('click',()=>setChat(!root.classList.contains('open')));c?.addEventListener('click',()=>setChat(false));}
  document.addEventListener('keydown',e=>{if(e.key==='Escape'){setChat(false);setNav(false)}});
});
