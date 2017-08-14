<?php

namespace Drupal\Tests\menu_example\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test the functionality for the menu Example.
 *
 * @ingroup menu_example
 *
 * @group menu_example
 * @group examples
 */
class MenuExampleTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('menu_example');
  /**
   * The installation profile to use with this test.
   *
   * @var string
   */
  protected $profile = 'minimal';

  /**
   * Runs different tests for menu example.
   */
  public function testMenuExample() {
    $this->assertSession()->pageTextContains('Menu Example');
    $this->clickLink(t('Menu Example'));
    $this->assertSession()->pageTextContains(t('This page is displayed by the simplest (and base) menu example'));

    // Create a user with permissions to access protected menu entry.
    $web_user = $this->drupalCreateUser();
    // Use custom overridden drupalLogin function to verify the user is logged
    // in.
    $this->drupalLogin($web_user);
    // Check that our title callback changing /user dynamically is working.
    $this->assertSession()->pageTextContains(t("@name", ['@name' => $web_user->getUsername()]));

    // Now start testing other menu entries.
    $this->drupalGet('examples/menu-example');
    $this->clickLink(t('Custom Access Example'));
    $this->assertSession()->pageTextContains(t('Custom Access Example'));
    $this->drupalGet('examples/menu-example/custom-access/page');
    $this->assertSession()->statusCodeEquals(200);

    // Check 'Permission Example' menu entry.
    $this->drupalGet('examples/menu-example/permissioned');
    $this->assertSession()->pageTextContains(t('Permissioned Example'));
    $this->clickLink('examples/menu-example/permissioned/controlled');
    $this->assertSession()->statusCodeEquals(403);

    // Check Route only example entry.
    $this->clickLink(t('Route only example'));
    $this->clickLink('examples/menu-example/route-only/callback');
    $this->assertSession()->pageTextContains('The route entry has no corresponding menu links entry');

    // Check links on Tabs landing page.
    $this->clickLink(t('Tabs'));
    $this->assertSession()->pageTextContains(t('This is the tab "Default primary tab" in the "basic tabs" example'));
    $this->assertSession()->linkByHrefExists('/examples/menu-example/tabs');
    // Check presence of default tabs.
    $this->assertSession()->linkByHrefExists('/examples/menu-example/tabs/default/second');
    $this->assertSession()->linkByHrefExists('/examples/menu-example/tabs/default/third');

    // Check second tab.
    $this->drupalGet('examples/menu-example/tabs/second');
    $this->assertSession()->pageTextContains(t('This is the tab "Second" in the "basic tabs" example'));

    // Check third tab.
    $this->clickLink(t('Third'));
    $this->assertSession()->pageTextContains(t('This is the tab "Third" in the "basic tabs" example'));

    // Now verify 'URL arguments' menu entry to be working with two arguments.
    $this->clickLink(t('URL Arguments'));
    $this->drupalGet('examples/menu-example/use-url-arguments/one/two');
    $this->assertSession()->pageTextContains(t('Argument 1 = one'));
    $this->assertSession()->pageTextContains(t('Argument 2 = two'));

    // Check 'placeholder arguments' menu entry.
    $this->clickLink(t('Placeholder Arguments'));
    $this->clickLink(t('examples/menu-example/placeholder-argument/3343/display'));
    $this->assertSession()->pageTextContains('3343');

    // Check altered route example.
    $this->drupalGet('examples/menu-example/menu-altered-path');
    $this->assertSession()->pageTextContains('Menu item altered by RouteSubscriber::alterRoutes');

  }

}
