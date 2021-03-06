<?php

namespace R6API\Client\tests\Api;

use R6API\Client\Api\Type\PlatformType;

/**
 * @author Baptiste Leduc <baptiste.leduc@gmail.com>
 */
class ProfileApiTest extends ApiTestCase
{
    public function testSimpleSearch()
    {
        $response = $this->client->getProfileApi()->get(PlatformType::PC, 'panda_______');

        $this->assertArrayHasKey('profiles', $response);

        $this->assertArrayHasKey('profileId', $response['profiles'][0]);
        $this->assertArrayHasKey('userId', $response['profiles'][0]);
        $this->assertArrayHasKey('platformType', $response['profiles'][0]);
        $this->assertArrayHasKey('idOnPlatform', $response['profiles'][0]);
        $this->assertArrayHasKey('nameOnPlatform', $response['profiles'][0]);
    }

    /**
     * @expectedException \R6API\Client\Exception\ApiException
     * @expectedExceptionMessage "switch" isn't a valid value from PlatformType enum.
     */
    public function testExceptionPlatformType()
    {
        $this->client->getProfileApi()->get('switch', 'panda_______');
    }

    /**
     * @expectedException \R6API\Client\Exception\ApiException
     * @expectedExceptionMessage "bar" doesn't exists as valid key.
     */
    public function testInvalidFilter()
    {
        $this->client->getProfileApi()->get(PlatformType::PC, 'foo', 'bar');
    }
}
