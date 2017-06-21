<?php

namespace Drupal\menu_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
/**
 * Controller routines for menu example routes.
 */
class MenuExampleController extends ControllerBase {

  /**
   * Page callback for the simplest introduction menu entry.
   * The router _controller callback, maps the path
   * 'examples/menu-example' to this method.
   */
  public function basicInstructions() {
    $url = Url::fromUri('internal:/examples/menu-example/path-only');
    $link = Link::fromTextAndUrl($this->t('visit a similar page with no menu link'), $url)->toString();
    return [
      '#markup' => $this->t('This page is displayed by the simplest (and base)
       menu example. Note that the title of the page is the same as the link
       title. You can also @link. There are a number of
       examples here, from the most basic (like this one) to extravagant
        mappings of loaded placeholder arguments. Enjoy!', ['@link' => $link]),
    ];
  }

  /**
   *
   */
  public function alternateMenu() {
    return [
      '#markup' => t('This will be in the Main menu instead of the default Tools menu'),
    ];

  }

  /**
   *
   */
  public function permissioned() {
    $url = Url::fromUri('internal:/examples/menu_example/permissioned/controlled');
    $link = Link::fromTextAndUrl($this->t('examples/menu_example/permissioned/controlled'), $url)->toString();
    return [
      '#markup' => $this->t('A menu item that requires the "access protected menu example" permission is at @link', ['@link' => $link]),
    ];
  }

  /**
   *
   */
  public function permissionedControlled() {
    return [
      '#markup' => $this->t('This menu entry will not show and the page will not be accessible without the "access protected menu example" permission.'),
    ];
  }

  /**
   *
   */
  public function customAccess() {
    $url = Url::fromUri('internal:/examples/menu_example/custom-access-page');
    $link = Link::fromTextAndUrl($this->t('examples/menu_example/custom-access-page'), $url)->toString();
    return [
      '#markup' => $this->t('A menu item that requires the user to posess a role of "authenticated" is at @link', ['@link' => $link]),
    ];
  }

  /**
   *
   */
  public function pathonly() {
    $url = Url::fromUri('internal:/examples/menu_example/path-only/callback');
    $link = Link::fromTextAndUrl($this->t('examples/menu_example/path-only/callback'), $url)->toString();
    return [
      '#markup' => $this->t('A menu entry with no menu link (MENU_CALLBACK) is at @link', ['@link' => $link]),
    ];
  }

  /**
   *
   */
  public function tabs() {
    return [
      '#markup' => $this->t('This is the "tabs" menu entry.'),
    ];
  }

  /**
   *
   */
  public function tabNameSecond() {
    return [
      '#markup' => $this->t('This is the tab "Second" in the "basic tabs" example'),
    ];
  }

  /**
   *
   */
  public function tabNameThird() {
    return [
      '#markup' => $this->t('This is the tab "Thrid" in the "basic tabs" example'),
    ];
  }

  /**
   *
   */
  public function tabNameForth() {
    return [
      '#markup' => $this->t('This is the tab "Forth" in the "basic tabs" example'),
    ];
  }

  /**
   *
   */
  public function defaultSecond() {
    return [
      '#markup' => $this->t('This is the secondary tab second in the "basic tabs" example "default"tab'),
    ];
  }

  /**
   *
   */
  public function defaultThird() {
    return [
      '#markup' => $this->t('This is the secondary tab Third in the "basic tabs" example "default"tab'),
    ];
  }

  /**
   *
   */
  public function urlArgument() {
    $url = Url::fromUri('internal:/examples/menu_example/use-url-arguments/firstarg/secondarg');
    $link = Link::fromTextAndUrl($this->t('examples/menu_example/use-url-arguments/firstarg/secondarg'), $url)->toString();
    $urle = Url::fromUri('internal:/examples/menu_example/use-url-arguments/one/two');
    $linker = Link::fromTextAndUrl($this->t('examples/menu_example/use-url-arguments/one/two'), $urle)->toString();
    return [
      '#markup' => $this->t('This page demonstrates using arguments in the path (portions of the path after "menu_example/use-url-arguments". For example, access it with @link or @linker', ['@link' => $link , '@linker' => $linker]),

    ];
  }

/**
   *
   */
  public function urlArgument1($arg1 = '') {
    return [
      '#markup' => $this->t('Argument1 = @arg1', ['@arg1' => $arg1]),
    ];
  }

  /**
   *
   */
  public function urlArgument2($arg1 , $arg2) {
    return [
      '#markup' => $this->t('Argument1 = @arg1 , Argument2 = @arg2', ['@arg1' => $arg1 , '@arg2' => $arg2]),
    ];
  }

  /**
   *
   */
  public function titleCallback() {
    return [
      '#markup' => $this->t('The title of this page is dynamically changed by the title callback for this route.'),
    ];
  }

  /**
   *
   */
  public function backTitle($title = '') {
    // Pass your uid.
    $user = \Drupal::currentUser();
    $title = $user->getDisplayName();
    // $title = $account->getUsername()->toString();
    // $account = \Drupal::currentUser()->id();
    // $title=$account->get('name')->value;
    return [
      '#markup' => $this->t('Dynamic Title: username = @title', ['@title' => $title]),
    ];
  }

  /**
   *
   */
  public function argument() {
    $url = Url::fromUri('internal:/examples/menu_example/placeholder-argument/3343/display');
    $link = Link::fromTextAndUrl($this->t('examples/menu_example/placeholder-argument/3343/display'), $url)->toString();
    return [
      '#markup' => $this->t('Demonstrate placeholders by visiting @link', ['@link' => $link]),
    ];
  }

  /**
   *
   */
  public function display($node = '') {
    return [
      '#markup' => $node,
    ];

  }

  public function orginalPath() {
    return [
      '#markup' => $this->t('This menu item was created strictly to allow the hook_menu_alter() function to have something to operate on.hook_menu defined the path as examples/menu_example/menu_original_path. The hook_menu_alter() changes it to examples/menu_example/menu_altered_path. You can try navigating to both paths and see what happens!'),
    ];
  }

  public function pathOnlycallback() {
    return [
      '#markup' => $this->t('The menu entry for this page is of type MENU_CALLBACK, so it provides only a path but not a link in the menu links, but it is the same in every other way to the simplest example.'),
      ];
    }

   public function argOptional($no = '') {
    $mapped_value = NULL;
    static $mappings = [
      1 => 'one',
      2 => 'two',
      3 => 'three',
      99 => 'jackpot! default',
    ];
    if (isset($mappings[$no])) {
      $mapped_value = $mappings[$no];
    }
   if (!empty($mapped_value)) {
      return [
        '#markup' => $this->t('Loaded value was @loaded', ['@loaded' => $mapped_value]),
      ];
    }
    else {
      return [
        '#markup' => $this->t('Sorry, the id @id was not found to be loaded', ['@id' => $no]),
      ];
    }

  }

  public function customAccessPage() {
    return array(
      '#markup' => $this-> t('This menu entry will not be visible and access will result
        in a 403 error unless the user has the "authenticated" role. This is
        accomplished with a custom access callback.'),
    );
  }

public function getRole(AccountInterface $account){

  return AccessResult::allowedIf($account->hasPermission('authenticated')) ;
}
}

  /**
   *
   */



