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
      <form action="settings" method="post" enctype="multipart/form-data">
        <div class="card section">
          <h2 class="has-text-centered">Theme</h2>
          <hr>
          <div class="field">
            <div class="select full-width">
              <select id="theme" class="full-width" name="theme" required>
                {foreach from=$themes item=theme}
                  <option value="{$theme}">{$theme}</option>
                {/foreach}
              </select>
            </div>
          </div>
          <div class="field">
            <div class="file is-primary full-width">
              <label class="file-label full-width">
                <input class="file-input" type="file" name="newtheme" accept=".zip,.rar,.7zip">
                <span class="file-cta full-width justified">
                  <span class="file-icon">
                    <i class="fas fa-upload"></i>
                  </span>
                  <span class="file-label">
                    Upload new theme
                  </span>
                </span>
              </label>
            </div>
          </div>
          <hr>
          <button type="submit" class="button is-primary full-width">Update</button>
        </div>
      </form>
    </div>
    <div class="column">
      <form action="settings" method="post" enctype="multipart/form-data">
        <div class="card section">
          <h2 class="has-text-centered">Users</h2>
          <hr>
          <label class="label">Create a new user <a class="has-tooltip-right modal-users" data-tooltip="Check 'list users' under tools for a current listing of registered users">?</a> </label>
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
          <label class="label" for="user">Select a user type</label>
          <div class="field">
            <div id="user" class="select full-width">
              <select id="user" class="full-width" name="type">
                <option value="admin">Admin</option>
                <option value="users">User</option>
              </select>
            </div>
          </div>
          <hr>
          <button type="submit" class="button is-primary full-width">Create</button>
        </div>
      </form>
    </div>
    <div class="column">
      <form action="settings" method="post" enctype="multipart/form-data">
        <div class="card section">
          <h2 class="has-text-centered">Additional Settings</h2>
          <hr>
          <ul>
            <li>
              <p class="is-pulled-left label">
                Make documentation private
              </p>
              <div class="ckbx-style-13 is-pulled-right">
                <input type="checkbox" id="private" name="private" {if ($private)} checked {/if}>
                <label for="private"></label>
              </div>
            </li>
          </ul><br>
          <hr>
          <button type="submit" class="button is-primary full-width">Update</button>
        </div>
      </form>
    </div>
  </div>

{include file='footer.tpl'}
