<?php
/**
 * Created by PhpStorm.
 * User: conrad
 * Date: 21/05/18
 * Time: 4:10 PM
 */

namespace AdvancedLearning\Oauth2Server\Tests;


use AdvancedLearning\Oauth2Server\Entities\UserEntity;
use AdvancedLearning\Oauth2Server\Extensions\GroupExtension;
use AdvancedLearning\Oauth2Server\Services\ScopeService;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\Group;
use SilverStripe\Security\Member;

class GroupScopesTest extends SapphireTest
{
    protected static $fixture_file = 'tests/OAuthFixture.yml';

    public function setUp()
    {
        // add GroupExtension for scopes
        Config::forClass(Group::class)->merge('extensions', [GroupExtension::class]);

        return parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testServiceScopes()
    {
        $obj = $this->objFromFixture(Member::class, 'member1');

        $service = new ScopeService();

        $this->assertTrue($service->hasScope('scope1', $obj), 'Member should have the scope via groups');
        $this->assertFalse($service->hasScope('scope2', $obj), 'Member should not have scope2');
    }

    public function testEntityScopes()
    {
        $member = $this->objFromFixture(Member::class, 'member1');

        $entity = new UserEntity($member);

        $this->assertTrue($entity->hasScope('scope1'), 'Member should have scope1');
        $this->assertFalse($entity->hasScope('scope2'), 'Member should not have scope2');
    }

}