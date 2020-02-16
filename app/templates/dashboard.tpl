{assign var="subtitle" value="Dashboard"}
{include file='header.tpl'}
  {include file='navigation.tpl'}
  <section class="container">
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
  </section>
  <div class="columns">
    <div class="column">
      <div class="card section">
        <h2 class="has-text-centered">Current Documents</h2>
        <hr>
        {if !empty($sections)}
          <section class="accordions">
            {foreach from=$sections key=key item=item}
              <article class="accordion is-success">
                <div class="accordion-header toggle">
                  <p class="has-text-centered">{$key}</p>
                  <button class="delete" data-section="{$key}" data-name="no-name"></button>
                </div>
                <div class="accordion-body">
                  <div class="accordion-content">
                    {if isset($item)}
                      <ul class="list sortables sortable-container">
                        {foreach $item as $page}
                          <li id="{$key}-{$page}" class="list-item sortable-item"><a href="edit?section={$key}&docname={$page}">{$page}</a> <a data-section="{$key}" data-name="{$page}" class="delete is-pulled-right delete"></a></li>
                        {/foreach}
                      </ul>
                    {/if}
                  </div>
                </div>
              </article>
            {/foreach}
          </section>
        {/if}
      </div>
    </div>
    <div class="column">
      <div class="card section">
        <h2 class="has-text-centered">Create a new document</h2>
        <hr>
        <form action="document" method="get">
          <div class="field">
            <p class="control">
              <input class="input" type="text" placeholder="Enter new page name..." name="docname" required {if empty($sections)}disabled{/if}>
            </p>
          </div>
          {if !empty($sections)}
          <div class="field">
            <div class="select full-width">
              <select class="full-width" name="section">
                {foreach from=$sections item=value key=key}
                  <option value="{$key}">{$key}</option>
                {/foreach}
              </select>
            </div>
          </div>
          {/if}
          <div class="field">
            <p class="control">
              <button class="button is-success full-width" {if empty($sections)}disabled{/if}>
                Create
              </button>
            </p>
          </div>
        </form>
      </div>
    </div>
    <div class="column">
      <div class="card section">
        <h2 class="has-text-centered">Create a new section</h2>
        <hr>
        <form action="document" method="get">
          <div class="field">
            <p class="control">
              <input class="input" type="text" placeholder="Enter new section name..." name="section">
            </p>
          </div>
          <div class="field">
            <p class="control">
              <button class="button is-success full-width">
                Create
              </button>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
{include file='footer.tpl'}
