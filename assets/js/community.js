(function () {

    var $ = function (selector, context) {
        return [].slice.call((context || document).querySelectorAll(selector))
    }

    $('.responsive-tabs').forEach(function (tabs) {

        var active = $('dt', tabs)[0]


        tabs.addEventListener('click', function (e) {
            if (e.target.nodeName.toLowerCase() === 'dt') {
                active.classList.remove('active')

                e.target.classList.add('active')
                active = e.target
            }
        })
    })
}())


function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}

fetch("https://blog.archethic.net/ghost/api/content/posts/?key=aeec92562cfcb3f27993205631&fields=title,feature_image,url,meta_description,published_at").then((data) => {

    return data.json();
}).then((completedata) => {

    document.getElementById('title').innerHTML = completedata.posts[0].title
    document.getElementById('image').src = completedata.posts[0].feature_image
    document.getElementById('excerpt').innerHTML = completedata.posts[0].meta_description
    document.getElementById('url').href = completedata.posts[0].url
    document.getElementById('date').innerHTML = formatDate(completedata.posts[0].published_at)

})



fetch("https://blog.archethic.net/ghost/api/content/posts/?key=aeec92562cfcb3f27993205631&fields=title,feature_image,url,custom_excerpt,published_at&filter=tag:global&limit=5").then((data) => {
    return data.json();
}).then((completedata1) => {
    let data1 = "";
    completedata1.posts.map((values) => {

        data1 += `<article
    class="post_item post_layout_news-magazine-extra post_format_standard post_accented_off post-300 post type-post status-publish format-standard has-post-thumbnail hentry category-currency-market" >

    <div class="post_featured with_thumb hover_icon display-flex" >
            <img 
            onclick="window.open('${values.url}')"
            src="${values.feature_image}" style="margin-right:20px; cursor: pointer; max-width: 200px; width:auto;"
            class="attachment-hoverex-thumb-magazine-extra size-hoverex-thumb-magazine-extra wp-post-image width-max"
            alt="" loading="lazy" />
            <div class="post_header entry-header top-mobile-tab">
            <h6 class="post_title entry-title "><a
                    href="${values.url}" target="_blank"
                    rel="bookmark">${values.title}</a></h6>
            <div class="post_meta">
                <span class="post_meta_item post_date" style="color: #607290">${formatDate(values.published_at)}</span> 
            </div>
        </div>      
    </div>        
    </div>
</article>`
    });
    document.getElementById('global').innerHTML = data1;
}).catch((err) => {
    console.log(err);
})

fetch("https://blog.archethic.net/ghost/api/content/posts/?key=aeec92562cfcb3f27993205631&fields=title,feature_image,url,custom_excerpt,published_at&filter=tag:tech-update&limit=5").then((data) => {
    return data.json();
}).then((completedata) => {
    let data = "";
    completedata.posts.map((values) => {
        data += `<article
    class="post_item post_layout_news-magazine-extra post_format_standard post_accented_off post-300 post type-post status-publish format-standard has-post-thumbnail hentry category-currency-market" >

    <div class="post_featured with_thumb hover_icon display-flex">
            <img
           onclick="window.open('${values.url}')"
            src="${values.feature_image}" style="margin-right:20px; cursor: pointer; max-width: 200px; width:auto;"
            class="attachment-hoverex-thumb-magazine-extra size-hoverex-thumb-magazine-extra wp-post-image width-max"
            alt="" loading="lazy" />
            <div class="post_header entry-header top-mobile-tab">
            <h6 class="post_title entry-title"><a
                    href="${values.url}" target="_blank"
                    rel="bookmark">${values.title}</a></h6>
            <div class="post_meta">
                <span class="post_meta_item post_date" style="color: #607290">${formatDate(values.published_at)}</span> 
            </div>
        </div>      
    </div>
    </div>
</article>`
    });
    document.getElementById('blog').innerHTML = data;
}).catch((err) => {
    console.log(err);
})

fetch("https://blog.archethic.net/ghost/api/content/posts/?key=aeec92562cfcb3f27993205631&fields=title,feature_image,url,custom_excerpt,published_at&filter=tag:partnership&limit=5").then((data) => {
    return data.json();
}).then((completedata) => {
    let data2 = "";
    completedata.posts.map((values) => {
        data2 += `<article
    class="post_item post_layout_news-magazine-extra post_format_standard post_accented_off post-300 post type-post status-publish format-standard has-post-thumbnail hentry category-currency-market" >

    <div class="post_featured with_thumb hover_icon display-flex">
            <img
            onclick="window.open('${values.url}')"
            src="${values.feature_image}" style="margin-right:20px; cursor: pointer; max-width: 200px; width:auto;"
            class="attachment-hoverex-thumb-magazine-extra size-hoverex-thumb-magazine-extra wp-post-image width-max"
            alt="" loading="lazy" />
            <div class="post_header entry-header top-mobile-tab">
            <h6 class="post_title entry-title"><a
                    href="${values.url}" target="_blank"
                    rel="bookmark">${values.title}</a></h6>
            <div class="post_meta">
                <span class="post_meta_item post_date" style="color: #607290">${formatDate(values.published_at)}</span> 
            </div>
        </div>
                
    </div>
    </div>
</article>`
    });
    document.getElementById('partnership').innerHTML = data2;
}).catch((err) => {
    console.log(err);
})
