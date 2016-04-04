<?php
/**
 * Created by PhpStorm.
 * User: martinasprong
 * Date: 04-04-16
 * Time: 11:13
 */

namespace Acme\BlogBundle\Tests\Controller;


class PageControllerTest
{
    public function testJsonPostPageAction()
    {
        $this->client = static::createClient();
        $this->client->request(
            'POST',
            '/api/v1/pages.json',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"title":"title1","body":"body1"}'
        );
        $this->assertJsonResponse($this->client->getResponse(), 201, false);
    }

    public function testJsonPostPageActionShouldReturn400WithBadParameters()
    {
        $this->client = static::createClient();
        $this->client->request(
            'POST',
            '/api/v1/pages.json',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"ninja":"turtles"}'
        );

        $this->assertJsonResponse($this->client->getResponse(), 400, false);
    }
}