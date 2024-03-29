<?php

namespace Tests;

use App\Models\User;
use App\Exceptions\Handler;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Summary of TestCase
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Summary of setUp
     * @return void
     */
    protected function setUp() : void{
        parent::setUp();
        $this->disableEXceptionHandling();
    }

    protected function disableEXceptionHandling () : void{
        $this->oldExceptionHandler = $this->app->make(\Illuminate\Contracts\Debug\ExceptionHandler::class);
        $this->app->instance(\Illuminate\Contracts\Debug\ExceptionHandler::class, new class extends \Illuminate\Foundation\Exceptions\Handler{
            public function __construct(){}
            public function report(\Throwable $e){}
            public function render($request, \Throwable $e){
                throw $e;
            }
        });
    }

    protected function withExceptionHandling() {
        $this->app->instance(\Illuminate\Contracts\Debug\ExceptionHandler::class, $this->oldExceptionHandler);
    }
    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class);

        $this->actingAs($user);

        return $this;
    }



}
