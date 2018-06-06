<?php

namespace Tests\DatabaseSeeders;

use StatonLab\TripalTestSuite\Database\Seeder;

/**
 * Creates test blast database nodes.
 *
 * See the code block below for an example of how to use this database seeder.
 * Note: the getNode() method is specific to this seeder and not standard TripalTestSuite.
 * @code
 *   // Creates a test blastdb node using the Drupal Node API.
 *   $seeder = DatabaseSeeders\BlastDBNodeSeeder::seed();
 *   // Retrieves the node created by the seeder for use in your test.
 *   $node = $seeder->getNode();
 * @endcode
 */
class BlastDBNodeSeeder extends Seeder {

    var $node;

    /**
     * Seeds the database with a test blast database node.
     *
     * @return void
     */
    public function up() {

      // Log in the god user.
      global $user;
      $user = user_load(1);

      $node = new \stdClass();
      if (!isset($node->title)) $node->title = 'Test Blast Database';
      $node->type = 'blastdb';
      node_object_prepare($node);

      $node->language = LANGUAGE_NONE;
      $node->uid = $user->uid;
      $node->status = 1;  // published.
      $node->promote = 0; // not promoted.
      $node->comment = 0; // disabled.

      if (!isset($node->db_name)) $node->db_name = 'Test Blast Database';
      if (!isset($node->db_path)) $node->db_path = '/fake/path/here';
      if (!isset($node->db_dbtype)) $node->db_dbtype = 'nucleotide';
      if (!isset($node->dbxref_linkout_type)) $node->dbxref_linkout_type = 'none';
      if (!isset($node->cvitjs_enabled)) $node->cvitjs_enabled = 0;

      $node = node_submit($node);
      node_save($node);

      // log out the god user.
      $user = drupal_anonymous_user();

      $this->node = $node;

    }

    /**
     * Returns the node created by up().
     */
     public function getNode() {
       return $this->node;
     }
}
