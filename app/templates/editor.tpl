{assign var="subtitle" value="`$docname|ucfirst` | `$section|ucfirst`"}
{include file='header.tpl'}
  {include file='navigation.tpl'}
  {if !empty($error)}
  <br>
    <div class="notification is-danger full-width">
      {$error}
    </div>
  {/if}
  {if !empty($success)}
  <br>
    <div class="notification is-success full-width">
      {$success}
    </div>
  {/if}
  <form action="edit" method="post">
    <section class="container">
      <h1 class="has-text-centered">Editing: <a href="{$base_url}/{$section|urlencode}/{$docname|urlencode}" target="_blank">{$docname}</a></h1>
      <div class="columns">
        <div class="column section">
          <h2 class="has-text-centered">Document Name</h2>
          <hr>
          <div class="field">
            <p class="control">
              <input class="input" id="docname" type="text" placeholder="{$docname}" name="docname" value="{$docname}" required>
            </p>
          </div>
        </div>
        <div class="column section">
          <h2 class="has-text-centered">Section</h2>
          <hr>
          <div class="field">
            <p class="control">
              {if !empty($sections)}
              <div class="field">
                <div class="select full-width">
                  <select class="full-width" id="section" name="section">
                    {foreach from=$sections item=value key=key}
                      {if $key == $section}
                        {assign var="current" value=$key}
                        <option value="{$section}" selected>{$key}</option>
                      {else}
                        <option value="{$key}">{$key}</option>
                      {/if}
                    {/foreach}
                  </select>
                </div>
              </div>
              {/if}
            </p>
          </div>
        </div>
      </div>
      <hr>
      <textarea name="content">{$content}</textarea>
      <input type="hidden" name="old-section" value="{$current}">
      <input type="hidden" name="old-name" value="{$docname}">
      <div class="field">
        <p class="control">
          <button type="submit" class="button is-success full-width">
            Update
          </button>
        </p>
      </div>
    </section>
  </form>
{include file='footer.tpl'}
