<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Artist extends BaseArtist
{
  public function setUp()
    {
        $this->hasMany('Album as Albums', array('local' => 'artist_id',
                                                        'foreign' => 'artist_id'));
		$this->hasMany('User', array('local' => 'artist_id',       // <- these are the column names
                                     'foreign' => 'user_id',      // <- in the association table
                                     'refClass' => 'UserArtist')); // <- the following line is needed in many-to-many relations!
    }
}