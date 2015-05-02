<?php

/**
 * @file
 * Definition of Drupal\maintenance_mode_ir\Tests\MaintenanceControllerTest.
 */

namespace Drupal\maintenance_mode_ir\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the maintenance_mode_ir module.
 *
 * @group maintenance_mode_ir
 */
class MaintenanceControllerTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('maintenance_mode_ir');

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests maintenance_mode_ir functionality.
   */
  public function testMaintenanceController() {
    // Check that the path is not accessible by anonymous users by default.
    $this->drupalGet('maintenance_mode_ir');
    $this->assertResponse(403);

    // User to use for accessing restricted paths.
    $access_user = $this->drupalCreateUser(array('administer site configuration'));
    $this->drupalLogin($access_user);

    // See that the path is accessible and does what is expected.
    $result = $this->drupalGetJson('maintenance_mode_ir');
    $this->assertEqual($result['state'], 1, 'The response reported maintenance mode is set to 1');
    $this->assertEqual(\Drupal::state()->get('system.maintenance_mode'), $result['state'], 'The maintenance mode is set to 1');
  }

}
