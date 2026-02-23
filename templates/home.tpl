{extends file='layouts/base.tpl'}

{block name=content}
    {foreach from=$categories item=category}
        {include file='partials/category.tpl' category=$category}
    {/foreach}
{/block}
