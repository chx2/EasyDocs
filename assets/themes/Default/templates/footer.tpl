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
