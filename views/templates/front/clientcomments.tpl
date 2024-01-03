<div class="cc-container">
    <div class="about-container">
        <p class="about-title">
            {Configuration::get('CLIENTCOMMENTS_ABOUT_TITLE')}
        </p>
        <p class="about-content">
            {Configuration::get('CLIENTCOMMENTS_ABOUT')}
        </p>
        <div class="about-content-img">
            <img class="img-fluid" src="{$shop.logo_details.src}" alt="{$shop.name}" width="{$shop.logo_details.width}" height="{$shop.logo_details.height}"></img>
        </div>
    </div>
    <div class="comments-container">
        <p class="comments-title">{Configuration::get('CLIENTCOMMENTS_COMMENTS_TITLE')}</p>
        <div class="comments">
            {foreach $comments as $i=>$comment}
                <div class="comment comment-shadow-card" style="z-index:{$i+1}; user-select: none;">
                    <p class="client">{$comment.client_name}</p>
                    <p class="message">{$comment.message}</p>
                </div>
            {/foreach}
        </div>
    </div>
</div>
