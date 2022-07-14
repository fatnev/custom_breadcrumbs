<?php

namespace Drupal\custom_breadcrumb\Breadcrumb;

use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Link;

class ViewsBreadcrumbBuilder implements BreadcrumbBuilderInterface {
  use LinkGeneratorTrait;
  use StringTranslationTrait;

  /**
   * @inheritdoc
   */
  public function applies(RouteMatchInterface $route_match) {
    // This breadcrumb apply only for some views.
    $parameters = $route_match->getParameters()->all();

    if (isset($parameters['view_id'])) {

       $views_id = array(
         'машинное имя страницы Views',
       );

       if (in_array($parameters['view_id'], $views_id)) {
         return TRUE;
       }
       return FALSE;
    }
  }

  /**
   * @inheritdoc
   */
  public function build(RouteMatchInterface $route_match) {
    // Breadcrumbs set up (cache settings are so important!).
    $breadcrumb = new \Drupal\Core\Breadcrumb\Breadcrumb();
    $breadcrumb->addCacheContexts(["url"]);
    $breadcrumb->addCacheTags(["view_id:{$parameters['view_id']}"]);

    $parameters = $route_match->getParameters()->all();
	
	$breadcrumb->addLink(Link::createFromRoute($this->t('Главная'), '<front>'));
	
    if (isset($parameters['view_id'])) {
      if ($parameters['view_id'] == 'машинное имя страницы Views') {
         $breadcrumb->addLink(Link::createFromRoute(t('Нужный текст'), '<none>'));
      }
    }

    // Reverse order for this to work!!!.
    return $breadcrumb;
  }
}
