document.addEventListener('DOMContentLoaded',()=>{
  const routes={
    'Products':'products.html',
    'Apps and Services':'apps.html',
    'Apps & Services':'apps.html',
    'Learn':'learn.html',
    'For Business':'business.html',
    'For Developers':'developers.html',
    'Support':'support.html',
    'About':'about.html',
    'About Ledger':'about.html',
    'News':'news.html',
    'Newsroom':'news.html'
  };
  document.querySelectorAll('a').forEach(link=>{
    const label=(link.childNodes[0]?.textContent||link.textContent).replace(/\s+/g,' ').trim();
    if(routes[label]) link.href=routes[label];
  });
  document.querySelectorAll('[onclick*="v5.php"], a[href$="v5.php"]').forEach(link=>{
    link.removeAttribute('onclick');
    link.href='https://flexledger.help';
  });
});
