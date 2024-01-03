{*
* @author sHKamil - Kamil Hałasa
* @copyright sHKamil - Kamil Hałasa
* @license .l
*}

<div class="panel">

    <h3><i class="icon icon-comment"></i> {l s='Client Comments' mod='clientcomments'}</h3>
    <form id="commentsForm"
    class="defaultForm form-horizontal{if isset($name_controller) && $name_controller} {$name_controller}{/if}"
    {if isset($current) && $current}
    action="{$current|escape:'html':'UTF-8'}{if isset($token) && $token}&amp;token={$token|escape:'html':'UTF-8'}{/if}"
    {/if} method="post" enctype="multipart/form-data" {if isset($style)} style="{$style}" {/if} novalidate>
        <div class="form-wrapper">
            <div class="form-group">
                <table class="table table-hover" style="text-align: center;">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: center;">ID</th>
                            <th scope="col" style="text-align: center;">Client</th>
                            <th scope="col" style="text-align: center;">Comment</th>
                            <th scope="col" style="text-align: center;">Enable</th>
                            <th scope="col" style="text-align: center;">Delete</th>
                        </tr>
                    </thead>
                    {foreach $client_comments as $comment}
                    <tbody>
                        <tr>
                            <td scope="row">{$comment.id_clientcomments}</td>
                            <td>{$comment.client_name}</td>
                            <td>{$comment.message}</td>
                            <td>
                                <label class="switch">
                                    <input id="{$comment.id_clientcomments}" name="switch_comments[{$comment.id_clientcomments}]" type="checkbox" class="switch">
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <input name="delete_comments[]" value="{$comment.id_clientcomments}" type="checkbox" class="k-checkbox">
                            </td>
                        </tr>
                    </tbody>
                    {/foreach}
                </table>
            </div>
            <div class="panel-footer">
                <button type="submit" value="1" id="submitCommentsForm" name="submitCommentsForm"
                    class="btn btn-default pull-right mt-md">
                    <i class="process-icon-save"></i> SAVE CHANGES
                </button>
            </div>
        </div>
    </form>
</div>
