<?php

/**
 * @file
 * Contains Drupal\maintenance_mode_ir\Controller\MaintenanceController.
 */

namespace Drupal\maintenance_mode_ir\Controller;

use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class MaintenanceController.
 *
 * @package Drupal\maintenance_mode_ir\Controller
 */
class MaintenanceController extends ControllerBase {

  /**
   * Constructs a new MaintenanceController.
   *
   * @param \Drupal\Core\State\StateInterface $state
   *   The state keyvalue collection to use.
   */
  public function __construct(StateInterface $state) {
    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('state')
    );
  }

  /**
   * Toggle the site "on" or "off".
   *
   * @return string
   *   Return Hello string.
   */
  public function toggle() {
    // Get the current state of maintenance.
    $status = $this->state->get('system.maintenance_mode');
    if ($status) {
      $this->state->set('system.maintenance_mode', 0);
    }
    else {
      $this->state->set('system.maintenance_mode', 1);
    }
    // We return the current state, so the user can act upon it.
    return new JsonResponse(array(
      'state' => $this->state->get('system.maintenance_mode'),
    ));
  }

}
