{extends file='layouts/base.tpl'}

{block name=content}
<article class="article">
    <h1 class="article__title">{$article.title|escape}</h1>
    <div class="article__date">{$article.published_at|date_format:"%b %e, %Y"}</div>
    <div class="article__meta">Views: {$article.views_count|escape}</div>
    <div class="article__meta">Categories: {$article.category_names|escape}</div>
    <img class="article__image" src="{$article.image|escape}" alt="{$article.title|escape}">
    <p class="article__lead">{$article.description|escape}</p>
    <div class="article__content">{$article.content|escape|nl2br nofilter}</div>
</article>

<section class="related">
    <h2 class="related__title">Related posts</h2>
    <div class="cards">
        {foreach from=$similarArticles item=similar}
            {include file='partials/card.tpl' article=$similar}
        {/foreach}
    </div>
</section>
{/block}
