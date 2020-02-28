  {if !isset($document)}

    <div class="modal modal-exports">
      <div class="modal-background"></div>
      <div class="modal-card">
        <form class="export-form" action="tool?action=export" method="post">
          <header class="modal-card-head">
            <p class="modal-card-title">Export Documents</p>
            <button class="delete close" aria-label="close"></button>
          </header>
          <section class="modal-card-body">
            <ul>
              {foreach from=$sections item=value key=key}
                <li>
                  <p class="is-pulled-left">
                    <span class="icon">
                      <i class="fas fa-folder"></i>
                    </span>
                    {$key}
                  </p>
                  <div class="ckbx-style-13 is-pulled-right">
                    <input type="checkbox" id="checkbox-{$key}" name="{$key}">
                    <label for="checkbox-{$key}"></label>
                  </div>
                </li><br><br>
              {/foreach}
            </ul>
          </section>
          <footer class="modal-card-foot">
            <button type="submit" class="button is-primary full-width">Export</button>
          </footer>
        </form>
      </div>
    </div>

    <div class="modal modal-sections">
      <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Change Section Order</p>
            <button class="delete close" aria-label="close"></button>
          </header>
          <section class="modal-card-body">
            {if !empty($sections)}
              <ul class="list sortables sortable-container">
                {foreach from=$sections key=key item=item}
                  <li id="sortable-{$key}" class="list-item is-active sortable-item">{$key}</li>
                {/foreach}
              </ul>
            {/if}
          </section>
        </div>
      </div>
    </div>

    <div class="modal modal-settings">
      <div class="modal-background">
        <div class="modal-card">
          <div class="modal-card-head">
            <h2 class="modal-card-title">Settings</h2>
            <button class="delete close" aria-label="close"></button>
          </div>
          <form action="settings" method="post" enctype="multipart/form-data">
            <section class="modal-card-body">
              <div class="field">
                <label class="label" for="theme">Select a theme</label>
                <div class="select full-width">
                  <select id="theme" class="full-width" name="theme">
                    {foreach from=$themes item=theme}
                      <option value="{$theme}">{$theme}</option>
                    {/foreach}
                  </select>
                </div>
              </div>
              <hr>
              <div class="colums is-multiline">
                <div class="column">
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
                </div>
                <div class="column">
                  <label class="label" for="user">Select a user type</label>
                  <div class="field">
                    <div id="user" class="select full-width">
                      <select id="user" class="full-width" name="user">
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <ul>
                <li>
                  <p class="is-pulled-left label">
                    Make documentation private <a class="has-tooltip-right modal-users" data-tooltip="Only registered users can view documentation">?</a>
                  </p>
                  <div class="ckbx-style-13 is-pulled-right">
                    <input type="checkbox" id="private" name="private">
                    <label for="private"></label>
                  </div>
                </li>
              </ul>
            </section>
            <footer class="modal-card-foot">
              <button type="submit" class="button is-primary full-width">Submit</button>
            </footer>
          </form>
        </div>
      </div>
    </div>

  {/if}

    <footer class="footer">
      <div class="content has-text-centered">
      <p>
        <strong>{$title}</strong> is powered by <a href="https://github.com/chx2/EasyDocs" target="_blank">EasyDocs</a> under a <a href="http://opensource.org/licenses/mit-license.php" target="_blank">MIT</a> license.
      </p>
      </div>
    </footer>

    {$scripts}
  </body>
</html>
