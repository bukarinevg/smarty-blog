{extends file='layouts/base.tpl'}

{block name=content}
<h1 class="page-title">{$category.name|escape}</h1>
<p class="category__description">{$category.description|escape}</p>

<div class="toolbar">
    <span class="toolbar__label">Sort by:</span>
    <a class="toolbar__link {if $sort === 'date'}active{/if}" href="?sort=date">Date</a>
    <a class="toolbar__link {if $sort === 'views'}active{/if}" href="?sort=views">Views</a>
</div>

<div class="cards">
    {foreach from=$articles item=article}
        {include file='partials/card.tpl' article=$article showViews=true}
    {/foreach}
</div>

{if $totalPages > 1}
<nav class="pagination">
    <span class="pagination__info">Page {$page|escape} of {$totalPages|escape}</span>
    {if $page > 1}
        <a class="pagination__link" href="?sort={$sort|escape}&page={$page - 1}">Previous</a>
    {/if}
    {if $page < $totalPages}
        <a class="pagination__link" href="?sort={$sort|escape}&page={$page + 1}">Next</a>
    {/if}
</nav>
{/if}
{/block}
