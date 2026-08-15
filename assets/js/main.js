// Main JavaScript file

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.lc-post').forEach(function(post){var id=post.dataset.post,like=post.querySelector('.lc-like'),save=post.querySelector('.lc-save'),comment=post.querySelector('.lc-comment'),comments=post.querySelector('.lc-comments');function press(button,on){button.classList.toggle('is-active',on);button.setAttribute('aria-pressed',on?'true':'false')}var liked=localStorage.getItem('lecercle-like-'+id)==='1';press(like,liked);press(save,localStorage.getItem('lecercle-save-'+id)==='1');if(liked)like.querySelector('b').textContent=Number(like.dataset.count)+1;like.addEventListener('click',function(){var on=like.getAttribute('aria-pressed')!=='true';press(like,on);like.querySelector('b').textContent=Number(like.dataset.count)+(on?1:0);localStorage.setItem('lecercle-like-'+id,on?'1':'0')});save.addEventListener('click',function(){var on=save.getAttribute('aria-pressed')!=='true';press(save,on);localStorage.setItem('lecercle-save-'+id,on?'1':'0')});comment.addEventListener('click',function(){var open=comments.hidden;comments.hidden=!open;comment.setAttribute('aria-expanded',open?'true':'false');if(open)comments.querySelector('input').focus()});post.querySelector('.lc-share').addEventListener('click',function(){var data={title:'Le Cercle',text:post.querySelector('p').textContent,url:location.href+'#'+id};if(navigator.share)navigator.share(data).catch(function(){});else navigator.clipboard.writeText(data.url).then(function(){alert('Lien copié !')})})});
    var feed = document.querySelector('.lc-feed');
    if (feed) {
        var compose = feed.querySelector('.lc-compose');
        var storedPosts = [];
        try { storedPosts = JSON.parse(localStorage.getItem('lecercle-home-posts') || '[]'); } catch (error) { storedPosts = []; }

        function createMemberPost(item) {
            var article = document.createElement('article');
            article.className = 'lc-post lc-post--member';
            article.dataset.post = 'member-' + item.id;
            article.dataset.feedType = 'actualites';
            article.dataset.search = (item.author + ' communauté ' + item.message).toLocaleLowerCase('fr-FR');
            var header = document.createElement('header');
            var avatar = document.createElement('i'); avatar.textContent = item.initial;
            var info = document.createElement('div');
            var title = document.createElement('h2'); title.textContent = item.author + ' ';
            var badge = document.createElement('em'); badge.textContent = 'Communauté'; title.appendChild(badge);
            var time = document.createElement('small'); time.textContent = 'à l’instant';
            info.appendChild(title); info.appendChild(time); header.appendChild(avatar); header.appendChild(info);
            var remove = document.createElement('button'); remove.type = 'button'; remove.className = 'lc-member-post-remove'; remove.textContent = 'Supprimer';
            remove.addEventListener('click', function() {
                storedPosts = storedPosts.filter(function(post) { return post.id !== item.id; });
                localStorage.setItem('lecercle-home-posts', JSON.stringify(storedPosts));
                article.remove();
                renderFeed();
            });
            header.appendChild(remove);
            var copy = document.createElement('p'); copy.textContent = item.message;
            article.appendChild(header); article.appendChild(copy);
            return article;
        }

        if (compose) {
            var insertionPoint = compose;
            storedPosts.forEach(function(item) { var post = createMemberPost(item); insertionPoint.after(post); insertionPoint = post; });
            var composeInput = compose.querySelector('input');
            var composeSubmit = compose.querySelector('.lc-compose-submit');
            function publishMemberPost() {
                var message = composeInput.value.trim();
                if (!message) { composeInput.focus(); return; }
                var item = { id: Date.now(), message: message, author: compose.dataset.memberName, initial: compose.dataset.memberInitial };
                storedPosts.unshift(item);
                localStorage.setItem('lecercle-home-posts', JSON.stringify(storedPosts));
                compose.after(createMemberPost(item));
                composeInput.value = '';
                renderFeed();
            }
            composeSubmit.addEventListener('click', publishMemberPost);
            composeInput.addEventListener('keydown', function(event) { if (event.key === 'Enter') { event.preventDefault(); publishMemberPost(); } });
        }
        var feedFilters = document.querySelectorAll('[data-feed-filter]');
        var homeSearch = document.querySelector('.lc-home-search');
        var emptyFeed = feed.querySelector('.lc-feed-empty');
        var feedStatus = feed.querySelector('.lc-feed-status');
        var activeFeedFilter = 'all';

        function renderFeed() {
            var query = homeSearch ? homeSearch.value.trim().toLocaleLowerCase('fr-FR') : '';
            var visibleCount = 0;
            feed.querySelectorAll('.lc-post').forEach(function(post) {
                var matchesFilter = activeFeedFilter === 'all' || post.dataset.feedType === activeFeedFilter || (activeFeedFilter === 'favorites' && localStorage.getItem('lecercle-save-' + post.dataset.post) === '1');
                var matchesSearch = !query || post.dataset.search.toLocaleLowerCase('fr-FR').indexOf(query) !== -1;
                post.hidden = !(matchesFilter && matchesSearch);
                if (!post.hidden) visibleCount += 1;
            });
            if (emptyFeed) emptyFeed.hidden = visibleCount !== 0;
            if (feedStatus) {
                feedStatus.textContent = query ? (visibleCount + (visibleCount > 1 ? ' publications trouvées' : ' publication trouvée') + ' pour « ' + homeSearch.value.trim() + ' »') : 'Découvrez les dernières publications de la communauté';
            }
        }

        feedFilters.forEach(function(button) {
            button.addEventListener('click', function() {
                activeFeedFilter = button.dataset.feedFilter;
                feedFilters.forEach(function(item) { item.classList.toggle('active', item === button); });
                renderFeed();
            });
        });
        if (homeSearch) homeSearch.addEventListener('input', function() {
            if (homeSearch.value.trim() !== '' && activeFeedFilter !== 'all') {
                activeFeedFilter = 'all';
                feedFilters.forEach(function(item) { item.classList.toggle('active', item.dataset.feedFilter === 'all'); });
            }
            renderFeed();
        });
        feed.querySelectorAll('.lc-save').forEach(function(button) { button.addEventListener('click', function() { window.setTimeout(renderFeed, 0); }); });
    }

    var dialog=document.querySelector('.lc-topic-dialog');
    if(dialog){document.querySelectorAll('.lc-new-topic').forEach(function(button){button.addEventListener('click',function(){dialog.showModal()})});dialog.addEventListener('click',function(event){if(event.target===dialog)dialog.close()});dialog.querySelectorAll('.lc-dialog-close,.lc-topic-cancel').forEach(function(button){button.addEventListener('click',function(event){event.preventDefault();dialog.close()})});var form=dialog.querySelector('form'),message=form.querySelector('textarea'),counter=form.querySelector('.lc-topic-count');message.addEventListener('input',function(){counter.textContent=message.value.length+' / 1200'})}
    var forumSearch=document.querySelector('.lc-forum-search');
    if(forumSearch){forumSearch.addEventListener('input',function(){var query=this.value.trim().toLowerCase();document.querySelectorAll('.lc-discussion').forEach(function(row){row.hidden=query!==''&&!row.dataset.search.includes(query)})})}
});

document.addEventListener('DOMContentLoaded', function() {
    var artists = document.querySelector('.lc-artists');
    if (!artists) return;

    artists.querySelectorAll('.lc-artist-follow').forEach(function(button) {
        var key = 'lecercle-follow-' + button.dataset.artist;
        var following = localStorage.getItem(key) === '1';
        function render() {
            button.classList.toggle('is-following', following);
            button.textContent = following ? '✓ Suivi' : '＋ Suivre';
        }
        render();
        button.addEventListener('click', function() { following = !following; localStorage.setItem(key, following ? '1' : '0'); render(); });
    });

    var search = artists.querySelector('.lc-artists-search');
    if (search) search.addEventListener('input', function() {
        var query = search.value.trim().toLowerCase();
        artists.querySelectorAll('.lc-artist-card').forEach(function(card) { card.hidden = query !== '' && !card.dataset.search.includes(query); });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var playlists = document.querySelector('.lc-playlists');
    if (!playlists) return;
    var cards = playlists.querySelectorAll('.lc-playlist-card');
    var search = playlists.querySelector('.lc-playlists-search');
    if (search) search.addEventListener('input', function() { var query = search.value.trim().toLowerCase(); cards.forEach(function(card) { card.hidden = query !== '' && !card.dataset.search.includes(query); }); });
});

document.addEventListener('DOMContentLoaded', function() {
    var thread = document.querySelector('.lc-thread');
    if (!thread) return;

    var follow = thread.querySelector('.lc-thread-follow');
    follow.addEventListener('click', function() {
        var active = follow.getAttribute('aria-pressed') !== 'true';
        follow.setAttribute('aria-pressed', active ? 'true' : 'false');
        follow.classList.toggle('is-active', active);
        follow.textContent = active ? '✓ Sujet suivi' : '＋ Suivre';
    });

    thread.querySelectorAll('.lc-thread-like').forEach(function(button) {
        var message = button.closest('[data-thread-message]').dataset.threadMessage;
        var key = 'lecercle-thread-like-' + message;
        var base = Number(button.dataset.count);
        var active = localStorage.getItem(key) === '1';
        button.classList.toggle('is-active', active);
        button.setAttribute('aria-pressed', active ? 'true' : 'false');
        button.firstChild.textContent = active ? '♥ ' : '♡ ';
        button.querySelector('b').textContent = base + (active ? 1 : 0);
        button.addEventListener('click', function() {
            active = !active;
            button.classList.toggle('is-active', active);
            button.setAttribute('aria-pressed', active ? 'true' : 'false');
            button.firstChild.textContent = active ? '♥ ' : '♡ ';
            button.querySelector('b').textContent = base + (active ? 1 : 0);
            localStorage.setItem(key, active ? '1' : '0');
        });
    });

    var replyBox = thread.querySelector('.lc-reply-box');
    var replyInput = replyBox.querySelector('textarea');
    var replyCount = replyBox.querySelector('.lc-reply-count');
    thread.querySelectorAll('.lc-thread-reply-trigger').forEach(function(button) {
        button.addEventListener('click', function() {
            replyInput.focus();
            replyBox.scrollIntoView({behavior: 'smooth', block: 'center'});
        });
    });
    replyInput.addEventListener('input', function() {
        replyCount.textContent = replyInput.value.length + ' / 1200';
    });
    replyBox.addEventListener('submit', function(event) {
        event.preventDefault();
        var value = replyInput.value.trim();
        if (!value) {
            replyInput.focus();
            return;
        }
        var newReply = document.createElement('article');
        newReply.className = 'lc-thread-post';
        newReply.innerHTML = '<aside class="lc-thread-author"><div class="lc-thread-avatar lc-thread-avatar--letter">U</div><strong>Vous</strong><small>À l\'instant</small><span>Nouveau membre</span></aside><div class="lc-thread-message"><header><time>À l\'instant</time></header><div class="lc-thread-copy"><p></p></div><footer class="lc-thread-actions"><button type="button">♡ <b>0</b></button><button class="lc-thread-reply-trigger" type="button">↩ Répondre</button></footer></div>';
        newReply.querySelector('.lc-thread-copy p').textContent = value;
        thread.querySelector('.lc-thread-replies').appendChild(newReply);
        replyInput.value = '';
        replyCount.textContent = '0 / 1200';
        newReply.scrollIntoView({behavior: 'smooth', block: 'center'});
    });

    var share = thread.querySelector('.lc-thread-share');
    share.addEventListener('click', function() {
        if (navigator.share) navigator.share({title: document.title, url: location.href}).catch(function(){});
        else if (navigator.clipboard) navigator.clipboard.writeText(location.href).then(function(){share.textContent = '✓ Lien copié';});
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var profile = document.querySelector('.lc-profile');
    if (!profile) return;

    profile.querySelectorAll('[data-profile-tab]').forEach(function(tab) {
        tab.addEventListener('click', function() {
            var target = tab.dataset.profileTab;
            profile.querySelectorAll('[data-profile-tab]').forEach(function(item) { item.classList.toggle('is-active', item === tab); });
            profile.querySelectorAll('[data-profile-panel]').forEach(function(panel) { panel.classList.toggle('is-active', panel.dataset.profilePanel === target); });
        });
    });

    profile.querySelectorAll('.lc-profile-like').forEach(function(button, index) {
        var base = Number(button.dataset.count);
        var key = 'lecercle-profile-like-' + index;
        var active = localStorage.getItem(key) === '1';
        function render() {
            button.classList.toggle('is-active', active);
            button.firstChild.textContent = active ? '♥ ' : '♡ ';
            button.querySelector('b').textContent = base + (active ? 1 : 0);
        }
        render();
        button.addEventListener('click', function() { active = !active; localStorage.setItem(key, active ? '1' : '0'); render(); });
    });

    document.querySelectorAll('.lc-profile-share').forEach(function(button) {
        button.addEventListener('click', function() {
            if (navigator.share) navigator.share({title: document.title, url: location.href}).catch(function(){});
            else if (navigator.clipboard) navigator.clipboard.writeText(location.href).then(function(){button.textContent = '✓ Copié';});
        });
    });

    var dialog = document.querySelector('.lc-profile-dialog');
    if (dialog) {
        var edit = document.querySelector('.lc-profile-edit');
        var close = function() { dialog.close(); };
        edit.addEventListener('click', function() { dialog.showModal(); });
        dialog.querySelector('.lc-profile-close').addEventListener('click', close);
        dialog.querySelector('.lc-profile-cancel').addEventListener('click', close);
        dialog.addEventListener('click', function(event) { if (event.target === dialog) close(); });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var events = document.querySelector('.lc-events');
    if (!events) return;

    var cards = Array.prototype.slice.call(events.querySelectorAll('.lc-event-card'));
    var filters = events.querySelectorAll('[data-event-filter]');
    var search = document.querySelector('.lc-events-search');
    var activeFilter = 'all';

    function render() {
        var query = search ? search.value.toLowerCase().trim() : '';
        cards.forEach(function(card) {
            var visible = (activeFilter === 'all' || card.dataset.kind === activeFilter) && (!query || card.dataset.search.indexOf(query) !== -1);
            card.classList.toggle('is-hidden', !visible);
        });
    }

    filters.forEach(function(button) {
        button.addEventListener('click', function() {
            activeFilter = button.dataset.eventFilter;
            filters.forEach(function(item) { item.classList.toggle('is-active', item === button); });
            render();
        });
    });
    if (search) search.addEventListener('input', render);

    var dialog = document.querySelector('.lc-event-dialog');
    var selectedEvent = '';

    function setReserved(label) {
        document.querySelectorAll('.lc-event-reserve').forEach(function(button) {
            if (button.dataset.event === label) {
                button.textContent = '✓ Place réservée';
                button.classList.add('is-reserved');
                button.disabled = true;
            }
        });
        localStorage.setItem('lecercle-event-' + label, '1');
    }

    events.querySelectorAll('.lc-event-reserve').forEach(function(button) {
        if (localStorage.getItem('lecercle-event-' + button.dataset.event) === '1') setReserved(button.dataset.event);
        button.addEventListener('click', function(event) {
            event.stopPropagation();
            selectedEvent = button.dataset.event;
            if (!dialog) { setReserved(selectedEvent); return; }
            dialog.classList.remove('is-confirmed');
            dialog.querySelector('h2').textContent = selectedEvent;
            dialog.querySelector('.lc-event-dialog-meta').textContent = 'Ta réservation est prête à être confirmée.';
            dialog.querySelector('.lc-event-dialog-description').textContent = 'Réserve maintenant pour recevoir les prochaines infos de la communauté.';
            dialog.querySelector('.lc-event-dialog-confirm').textContent = 'Réserver ma place';
            dialog.showModal();
        });
    });

    if (!dialog) return;
    function openDetails(card) {
        selectedEvent = card.querySelector('h3').textContent;
        dialog.classList.remove('is-confirmed');
        dialog.querySelector('h2').textContent = selectedEvent;
        dialog.querySelector('.lc-event-dialog-meta').textContent = card.querySelector('.lc-event-details p').textContent;
        dialog.querySelector('.lc-event-dialog-description').textContent = card.querySelector('.lc-event-details small').textContent;
        dialog.querySelector('.lc-event-dialog-confirm').textContent = 'Réserver ma place';
        dialog.showModal();
    }
    cards.forEach(function(card) {
        card.addEventListener('click', function(event) { if (!event.target.closest('.lc-event-reserve')) openDetails(card); });
        card.addEventListener('keydown', function(event) { if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); openDetails(card); } });
    });
    dialog.querySelector('.lc-event-dialog-confirm').addEventListener('click', function() {
        if (!selectedEvent) return;
        setReserved(selectedEvent);
        dialog.classList.add('is-confirmed');
        this.textContent = '✓ Place réservée';
        this.disabled = true;
    });
    dialog.addEventListener('close', function() {
        dialog.classList.remove('is-confirmed');
        dialog.querySelector('.lc-event-dialog-confirm').disabled = false;
    });
});

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.lc-deals-controls').forEach(function(controls) {
        var grid = document.querySelector('.lc-deals-grid');
        if (!grid) return;
        controls.querySelectorAll('[data-deal-filter]').forEach(function(button) {
            button.addEventListener('click', function() {
                var filter = button.dataset.dealFilter;
                controls.querySelectorAll('[data-deal-filter]').forEach(function(item) { item.classList.toggle('active', item === button); });
                grid.querySelectorAll('.lc-deal-card').forEach(function(card) {
                    card.hidden = filter !== 'all' && card.dataset.dealType !== filter;
                });
            });
        });
    });

    document.querySelectorAll('.lc-header').forEach(function(header) {
        var nav = header.querySelector('nav');
        if (!nav || header.querySelector('.lc-mobile-menu')) return;
        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'lc-mobile-menu';
        button.setAttribute('aria-label', 'Ouvrir le menu');
        button.setAttribute('aria-expanded', 'false');
        button.innerHTML = '<span></span>';
        header.insertBefore(button, nav);
        button.addEventListener('click', function() {
            var open = nav.classList.toggle('is-open');
            button.classList.toggle('is-open', open);
            button.setAttribute('aria-expanded', open ? 'true' : 'false');
            button.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
        });
        nav.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                nav.classList.remove('is-open');
                button.classList.remove('is-open');
                button.setAttribute('aria-expanded', 'false');
            });
        });
    });
});
