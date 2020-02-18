<nav class="navbar box no-pad" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="{(isset($document)) ? {$base_url} : dashboard}">
      <img src="{$base_url}/assets/img/logo.png" alt="Docs Logo">
    </a>
    <a role="button" class="navbar-burger burger is-hidden-tablet" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>
  <div id="navbar" class="navbar-menu">
    {if !isset($document)}
      <div class="navbar-end">
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            Tools
          </a>
          <div class="navbar-dropdown">
            <a href="tool?action=cache" class="navbar-item has-tooltip-left" data-tooltip="This will clear page cache. Helpful if you want to see changes asap">
              Clear cache
            </a>
            {if !empty($sections)}
              <a href="tool?action=scan" class="navbar-item has-tooltip-left" data-tooltip="This will scan all current documents to help fix broken listings">
                Rebuild document list
              </a>
              <a class="navbar-item has-tooltip-left modal-toggle" data-tooltip="Click to select documents for export">
                Export Documents
              </a>
            {/if}
          </div>
        </div>
        <div class="navbar-item">
          <div class="buttons">
            <a href="logout" class="button is-primary">
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
