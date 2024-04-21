<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesResponseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The data set for testing returned statuses from key pages
     *
     * @return array
     */
    public static function pagesUrlProvider(): array
    {
        return [
            'home' => ['/', 'main.index'],
            'groups' => ['/faux/filter/groups', 'faux.groups'],
            'students' => ['/faux/filter/students', 'faux.students'],
            'adminLogin' => ['/auth/login', 'auth.login'],
            'adminRegister' => ['/auth/register', 'auth.register'],
            'api' => ['/api/v1/documentation', 'l5-swagger::index']
        ];
    }

    /**
     * A basic test to check availability of main set of pages
     *
     * @dataProvider pagesUrlProvider
     *
     * @return void
     */
    public function testReturnsSuccessfulResponse($url, $view): void
    {
        $this->seed();

        $response = $this->withoutExceptionHandling()->get($url);

        $response->assertStatus(200);
        $response->assertViewIs($view);
    }

    /**
     * Test availability of the home page
     *
     * @return void
     */
    public function testHomePage(): void
    {
        $response = $this->withoutExceptionHandling()->get("/");

        $response->assertStatus(200);
        $response->assertViewIs('main.index');
        $response->assertSee('FauxEd Students Database – your one-stop solution for a simulated university experience.');
    }

    /**
     * Test to check page 404
     */
    public function testReturnUnsuccessfulResponse()
    {
        $response = $this->get('/wrong.page');

        $response->assertStatus(404);
        $response->assertSee('Not Found');
    }
}
