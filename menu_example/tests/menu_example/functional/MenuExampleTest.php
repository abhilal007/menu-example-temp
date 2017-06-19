<?php

namespace Drupal\tests\menu_example\functional;

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
   * @var  string
   */
  protected $profile = 'minimal';

  /**
   * test whether the module was installed.
   */
  public function testInstalled() {
    $this->assertTrue(\Drupal::moduleHandler()->moduleExists('menu_example'));
  }

  public fuction testMenuExample() {

    $this->drupalGet('');
    $this->clickLink(t('Menu Example'));
    $this->assertText(t('This is the base page of the Menu Example'));

    $this->clickLink(t('Custom Access Example'));
    $this->assertText(t('Custom Access Example'));

    $this->drupalGet('examples/menu_example/permissioned');
    $this->assertText(t('Permissioned Example'));

    $this->clickLink('examples/menu_example/permissioned/controlled');
    $this->assertResponse(403);

    $this->clickLink(t('Tabs'));
    $this->assertText(t('This is the "tabs" menu entry'));

    $this->drupalGet('examples/menu_example/tabs/second');
    $this->assertText(t('This is the tab "second" in the "basic tabs" example'));

    $this->clickLink(t('third'));
    $this->assertText(t('This is the tab "third" in the "basic tabs" example'));

    $this->clickLink(t('Extra Arguments'));

    $this->drupalGet('examples/menu_example/use_url_arguments/one/two');
    $this->assertText(t('Argument 1=one'));

    $this->clickLink(t('Placeholder Arguments'));

    $this->clickLink(t('examples/menu_example/placeholder_argument/3343/display'));
    $this->assertRaw('<div>3343</div>');

    // Create a user with permissions to access protected menu entry.
    $web_user = $this->drupalCreateUser(array('access protected menu example'));

    // Use custom overridden drupalLogin function to verify the user is logged
    // in.
    $this->drupalLogin($web_user);

    // Now start testing other menu entries.
    $this->drupalGet('examples/menu_example');

    $this->drupalGet('examples/menu_example/permissioned');
    $this->assertText('Permissioned Example');
    $this->clickLink('examples/menu_example/permissioned/controlled');
    $this->assertText('This menu entry will not show');

    $this->drupalGet('examples/menu_example/menu_altered_path');


  }
}
