<nav class="navbar box no-pad" aria-label="main navigation">

  <div class="navbar-brand">
    <a class="navbar-item" href="{(isset($document)) ? {$base_url} : dashboard}">
      <img src="{$base_url}/assets/img/logo.png" alt="Docs Logo">
    </a>
    <a role="button" class="navbar-burger burger is-hidden-desktop" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbar" class="navbar-menu">

    {if isset($smarty.session.logged_user)}
      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <a href="logout" class="button is-link">
              Logout
            </a>
          </div>
        </div>
      </div>
    {/if}

    {if !isset($document)}

      <div class="navbar-end">
        <a href="{$base_url}/dashboard" class="navbar-item">Dashboard</a>
        <a href="{$base_url}/settings" class="navbar-item">Settings</a>
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            Tools
          </a>
          <div class="navbar-dropdown">
            <a href="tool?action=cache" class="navbar-item has-tooltip-left" data-tooltip="This will clear page cache. Helpful if you want to see changes asap">
              Clear cache
            </a>
            <a class="navbar-item has-tooltip-left modal-toggle" data-modal="modal-users" data-tooltip="List all existing users">
              List users
            </a>
            {if !empty($sections)}
              <a href="tool?action=scan" class="navbar-item has-tooltip-left" data-tooltip="This will scan all current documents to help fix broken listings. WARNING: Running this command will result in document & section ordering to alphabetical">
                Rebuild document list
              </a>
              <a class="navbar-item has-tooltip-left modal-toggle" data-modal="modal-exports" data-tooltip="Click to select documents for export">
                Export Documents
              </a>
            {/if}
          </div>
        </div>
        <div class="navbar-item">
          <div class="buttons">
            <a href="{$base_url}/logout" class="button is-link">
              Logout
            </a>
          </div>
        </div>
      </div>

    {else}

      <nav class="menu box is-hidden-desktop is-hidden-tablet">
        {$navigation}
      </nav>

    {/if}
  </div>

</nav>
