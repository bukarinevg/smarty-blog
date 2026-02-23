<a class="card" href="/article/show/{$article.id|escape}">
    <img class="card__image" src="{$article.image|escape}" alt="{$article.title|escape}">
    <div class="card__body">
        <p class="card__body__title">
            <span class="card__body__title-link">
                {$article.title|escape}
            </span>
        </p>
        <span class="card__body__date">{$article.published_at|date_format:"%b %e, %Y"}</span>
        <p class="card__body__text">{$article.description|escape}</p>
        {if $showViews|default:false}
            <div class="card__body__meta">Views: {$article.views_count|escape}</div>
        {/if}
        {if $showCta|default:false}
            <span class="card__body__cta">Continue reading</span>
        {/if}
    </div>
</a>
