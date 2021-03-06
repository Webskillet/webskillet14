<div id="wrapper">

  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
    <?php if ($main_menu): ?>
      <a href="#navigation" class="element-invisible element-focusable"><?php print t('Skip to navigation'); ?></a>
    <?php endif; ?>
  </div>

<div id="header-wrapper">
  <header id="header" role="banner" class="clearfix container">
	<?php if ($logo): ?>
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
    <?php endif; ?>
    <?php if ($site_name || $site_slogan): ?>
      <div id="site-name-slogan">
        <?php if ($site_name): ?>
          <?php if ($title): ?>
            <div id="site-name">
              <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
            </div>
          <?php else: /* Use h1 when the content title is empty */ ?>
            <h1 id="site-name">
              <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
            </h1>
          <?php endif; ?>
        <?php endif; ?>
        <?php if ($site_slogan): ?>
          <div id="site-slogan"><?php print $site_slogan; ?></div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <?php print render($page['header']); ?>
  </header> <!-- /#header -->
</div>

  <div id="navigation-wrapper">
    <?php if ($main_menu || $page['navigation']): ?>
      <nav id="navigation" role="navigation" class="clearfix container">
        <?php if ($main_menu) { print $main_menu; } ?>
	    <?php if ($page['navigation']) { print render($page['navigation']); } ?>
      </nav> <!-- /#navigation -->
    <?php endif; ?>
  </div> <!-- /#navigation-wrapper -->

  <div id="wrapper-main" class="clearfix container"><div class="row">

  <section id="main" role="main" class="clearfix <?php print $page['sidebar_first'] ? 'col-sm-8' : 'col-sm-12'; ?>">
    <?php print $messages; ?>
    <a id="main-content"></a>
    <?php print render($title_prefix); ?>
    <?php if ($title): ?><h1 class="title" id="page-title"><?php print $title; ?></h1><?php endif; ?>
    <?php print render($title_suffix); ?>
    <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper"><?php print render($tabs); ?></div><?php endif; ?>
    <?php print render($page['help']); ?>
    <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
    <?php print render($page['content']); ?>
  </section> <!-- /#main -->
  
  <?php if ($page['sidebar_first']): ?>
    <aside id="sidebar-first" role="complimentary" class="sidebar clearfix col-sm-4">
      <?php print render($page['sidebar_first']); ?>
    </aside>  <!-- /#sidebar-first -->
  <?php endif; ?>

  </div></div> <!-- /#wrapper-main -->

  <?php if ($page['utility'] || $secondary_menu): ?>
    <aside id="utility" role="complimentary">
      <?php if ($secondary_menu): ?>
        <nav id="utility-nav" role="navigation" class="container">
		  <?php echo $secondary_menu; ?>
        </nav> <!-- /#utility-nav -->
      <?php endif; ?>
	  <?php if ($page['utility']) : ?>
		<div class="container">
	      <?php print render($page['utility']); ?>
		</div>
	  <?php endif; ?>
    </aside> <!-- /#utility -->
  <?php endif; ?>

<div id="footer-wrapper">
  <footer id="footer" role="contentinfo" class="container">
    <?php print render($page['footer']) ?>
	<div id="site-credit"><a href="http://www.webskillet.com">website by Webskillet | a union shop, worker-owned cooperative and women-owned business</a></div>
  </footer> <!-- /#footer -->
</div>

  <?php if ($page['popups']): ?>
    <aside id="popups" role="complimentary">
      <?php print render($page['popups']); ?>
    </aside> <!-- /#popups -->
  <?php endif; ?>

</div> <!-- /#wrapper -->
