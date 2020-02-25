{assign var="subtitle" value="`$docname|ucfirst` | `$section|ucfirst`"}
{assign var="document" value="true"}
{include file='header.tpl'}
  {include file='navigation.tpl'}

  <div class="container">
    <div class="columns">
      <div class="column is-3">
        <aside class="menu box is-hidden-mobile">
          {$navigation}
        </aside>
      </div>
      <div class="column is-9">
        <article class="content">
          {$content}
        </article>
        {if !empty($previous)}
          <button class="button is-success is-outlined is-pulled-left">
            <span class="icon">
              <i class="fas fa-arrow-left"></i>
            </span>
            <span><a href="{$base_url}/{$section}/{$previous}">Previous: {$previous}</a></span>
          </button>
        {/if}
        {if !empty($next)}
          <button class="button is-success is-outlined is-pulled-right">
            <span><a href="{$base_url}/{$section}/{$next}">Next up: {$next}</a></span>
            <span class="icon">
              <i class="fas fa-arrow-right"></i>
            </span>
          </button>
        {/if}
      </div>
    </div>
  </div>

{include file='footer.tpl'}
