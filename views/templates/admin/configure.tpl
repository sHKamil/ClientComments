{*
* @author sHKamil - Kamil Hałasa
* @copyright sHKamil - Kamil Hałasa
* @license .l
*}

{include file="module:clientcomments/views/templates/admin/new_comment.tpl"}

{if isset($client_comments) && !empty($client_comments)}
	{include file="module:clientcomments/views/templates/admin/comments_crude.tpl"}
{/if}
