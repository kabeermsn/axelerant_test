<?php

namespace Drupal\axelerant_site_info\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\State\StateInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * [$stateSystemService description]
   * @var Drupal\Core\State\StateInterface
   */
  protected $stateSystemService;

  /**
   * Symfony\Component\HttpFoundation\RequestStack
   * @var Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Constructs a new DefaultController object.
   */
  public function __construct(
    StateInterface $state_system_service,
    RequestStack $request_stack
  ) {
    $this->stateSystemService = $state_system_service;
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('state'),
      $container->get('request_stack')
    );
  }

  /**
   * Pagenodejsonapiaction.
   *
   * @return string
   *   Return Hello string.
   */
  public function pageNodeJsonApiAction(string $key, NodeInterface $node, Request $request) {

    $nodeArray = [
      'id'  => $node->id(),
      'title' => $node->title->value,
      'body' => $node->body->value
    ];

    return new JsonResponse($nodeArray);
  }

  /**
   * Checks access for a specific request.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(AccountInterface $account) {
    // get url parameters 'node' and 'key' from current route request
    $request = $this->requestStack->getCurrentRequest();
    $node = $request->attributes->get('node');
    $key = $request->attributes->get('key');

    // check the bundle type
    $bundleType = $node->getType();

    // get the site api key saved in state object for key "siteapikey"
    $siteApiKey = $this->stateSystemService->get('siteapikey');

    // allow access if siteapikey matches route 'key' parameter and node bundle type is 'page'
    if($siteApiKey == $key && $bundleType == 'page') {
      return AccessResult::allowed();
    }

    return AccessResult::forbidden();
  }

}
