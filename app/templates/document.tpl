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
      </div>
    </div>
  </div>
{include file='footer.tpl'}
