<?php

namespace Saasplayground\SupportTickets\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Saasplayground\SupportTickets\SupportTicketsServiceProvider;
use Saasplayground\SupportTickets\Tests\Models\User;

/**
 * TestCase
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    protected $loadEnvironmentVariables = true;

    protected $enablePackageDiscoveries = true;

    protected $authUser = null;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testbench']);

        $this->artisan('migrate', ['--database' => 'testbench']);

        // setup user to be used for auth
        $this->setAuthUser();

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // $app['config']->set(
        //     'support-tickets.resources.'. \Saasplayground\SupportTickets\Tests\Models\User::class,
        //     \Lunacms\Forums\Http\Users\Resources\UserResource::class
        // );

        $app['config']->set('support-tickets.users.model', User::class);
        $app['config']->set('support-tickets.users.db_connection', 'testbench');
        $app['config']->set('support-tickets.models.users', User::class);

        $app['config']->set('database.default', 'testbench');

        // Setup default database to use sqlite :memory:
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SupportTicketsServiceProvider::class,
        ];
    }

    public function ignorePackageDiscoveriesFrom()
    {
        return [];
    }

    public function useLogin()
    {
        $user = $this->authUser();

        return $this->actingAs($user);
    }

    public function setAuthUser()
    {
        $this->authUser = User::factory()->create();
    }

    public function authUser()
    {
        return $this->authUser;
    }

    public function forumsUrl($url, $forumSlug = null)
    {
        $url = ! empty($forumSlug) ? $forumSlug.$url : $url;

        return $this->wrapUrl(trim($url, '/'));
    }

    public function wrapUrl($url)
    {
        return trim(config('support-tickets.routes.prefix', '/'), '/').'/'.trim($url, '/');
    }
}
