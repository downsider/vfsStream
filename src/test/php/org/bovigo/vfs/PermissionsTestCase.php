<?php
/**
 * This file is part of vfsStream.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package  org\bovigo\vfs
 */
namespace org\bovigo\vfs;
/**
 * Test for permissions related functionality.
 *
 * @group  permissions
 */
class PermissionsTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @type  vfsStreamDirectory
     */
    private $root;

    /**
     * set up test environment
     */
    public function setup()
    {
        $structure = array('test_directory' => array('test.file' => ''));
        $this->root = vfsStream::setup('root', null, $structure);
    }

    /**
     * @test
     * @group  issue_52
     */
    public function canNotChangePermissionWhenDirectoryNotWriteable()
    {
        $this->root->getChild('test_directory')->chmod(0444);
        $this->assertFalse(@chmod(vfsStream::url('root/test_directory/test.file'), 0777));
    }

    /**
     * @test
     * @group  issue_52
     */
    public function canNotChangeOwnerWhenDirectoryNotWriteable()
    {
        $this->root->getChild('test_directory')->chmod(0444);
        $this->assertFalse(@chown(vfsStream::url('root/test_directory/test.file'), 0777), vfsStream::OWNER_USER_2);
    }

    /**
     * @test
     * @group  issue_52
     */
    public function canNotChangeGroupWhenDirectoryNotWriteable()
    {
        $this->root->getChild('test_directory')->chmod(0444);
        $this->assertFalse(@chgrp(vfsStream::url('root/test_directory/test.file'), 0777), vfsStream::GROUP_USER_2);
    }
}
?>