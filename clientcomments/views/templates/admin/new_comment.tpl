{*
* @author sHKamil - Kamil Hałasa
* @copyright sHKamil - Kamil Hałasa
* @license .l
*}

<div class="panel">

    <h3><i class="icon icon-comment"></i> ADD NEW COMMENT </h3>
    <form id="newCommentsForm"
        class="defaultForm form-horizontal{if isset($name_controller) && $name_controller} {$name_controller}{/if}" {if
        isset($current) && $current}
        action="{$current|escape:'html':'UTF-8'}{if isset($token) && $token}&amp;token={$token|escape:'html':'UTF-8'}{/if}"
        {/if} method="post" enctype="multipart/form-data" {if isset($style)} style="{$style}" {/if} novalidate>
        
        <div class="form-wrapper">
            <div class="form-group">
                <label class="control-label col-lg-4">
                    Client name:
                </label>
                <div class="col-lg-8">
                    <input type="text" name="new_client_name" id="NEW_CLIENT_NAME">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-4">
                    Comment:
                </label>
                <div class="col-lg-8">
                    <textarea name="new_comment" id="NEW_COMMENT" class="form-control" style="min-height: 100px;"></textarea>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" value="1" id="submitNewCommentsForm" name="submitNewCommentsForm" class="btn btn-default pull-right mt-md">
                <i class="process-icon-save"></i> ADD NEW COMMENT
            </button>
        </div>
    </form>
</div>
