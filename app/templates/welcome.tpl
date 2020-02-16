{assign var="subtitle" value="Welcome"}
{assign var="document" value="true"}
{include file='header.tpl'}
  {if empty($navigation)}
    <section class="abs-center full-width">
      <h1>Welcome to EasyDocs</h1>
      <hr>
      <h2><a href="login">Login</a> to begin writing!</h2>
    </section>
  {else}
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
            <h1>{$title}</h1>
            <p>{$description}</p>
          </article>
        </div>
      </div>
    </div>
  {/if}
{include file='footer.tpl'}
