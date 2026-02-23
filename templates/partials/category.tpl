<section class="category">
    <div class="category__head">
        <a href="/category/show/{$category.id|escape}" class="category__head__link">
            <div class="category__head__link__info">
                <h2 class="category__head__link__info__title">{$category.name|escape}</h2>
            </div>
            <span class="category__head__link__view_all">View All</span>
        </a>
    </div>

    <div class="cards">
        {foreach from=$category.articles item=article}
            {include file='partials/card.tpl' article=$article showCta=true}
        {/foreach}
    </div>
</section>
