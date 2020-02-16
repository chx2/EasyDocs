{assign var="subtitle" value="Login"}
{include file='header.tpl'}
  <section class="abs-center full-width">
    <div class="card">
      <div class="card-content centered">
        <img src="{$base_url}/assets/img/logo.png">
        {if !empty($error)}
          <div class="notification is-danger">
            {$error}
          </div>
        {/if}
        <form action="login" method="post">
          <div class="field">
            <p class="control has-icons-left has-icons-right">
              <input class="input" type="text" placeholder="Username" name="username" required>
              <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
              </span>
            </p>
          </div>
          <div class="field">
            <p class="control has-icons-left">
              <input class="input" type="password" placeholder="Password" name="password" required>
              <span class="icon is-small is-left">
                <i class="fas fa-lock"></i>
              </span>
            </p>
          </div>
          <div class="field">
            <p class="control">
              <button class="button is-success full-width">
                Login
              </button>
            </p>
          </div>
        </form><br>
        <p class="has-text-centered"><a href="{$base_url}">Return to Documentation</a></p>
      </div>
    </div>
  </section>
{include file='footer.tpl'}
