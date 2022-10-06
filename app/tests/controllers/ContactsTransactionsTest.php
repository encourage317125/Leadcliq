<?php

use Mockery as m;
use Way\Tests\Factory;

class ContactsTransactionsTest extends TestCase {

    public function __construct()
    {
        $this->mock = m::mock('Eloquent', 'Contactstransaction');
        $this->collection = m::mock('Illuminate\Database\Eloquent\Collection')->shouldDeferMissing();
    }

    public function setUp()
    {
        parent::setUp();

        $this->attributes = Factory::contactstransaction(['id' => 1]);
        $this->app->instance('Contactstransaction', $this->mock);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testIndex()
    {
        $this->mock->shouldReceive('all')->once()->andReturn($this->collection);
        $this->call('GET', 'contactstransactions');

        $this->assertViewHas('contactstransactions');
    }

    public function testCreate()
    {
        $this->call('GET', 'contactstransactions/create');

        $this->assertResponseOk();
    }

    public function testStore()
    {
        $this->mock->shouldReceive('create')->once();
        $this->validate(true);
        $this->call('POST', 'contactstransactions');

        $this->assertRedirectedToRoute('contactstransactions.index');
    }

    public function testStoreFails()
    {
        $this->mock->shouldReceive('create')->once();
        $this->validate(false);
        $this->call('POST', 'contactstransactions');

        $this->assertRedirectedToRoute('contactstransactions.create');
        $this->assertSessionHasErrors();
        $this->assertSessionHas('message');
    }

    public function testShow()
    {
        $this->mock->shouldReceive('findOrFail')
                   ->with(1)
                   ->once()
                   ->andReturn($this->attributes);

        $this->call('GET', 'contactstransactions/1');

        $this->assertViewHas('contactstransaction');
    }

    public function testEdit()
    {
        $this->collection->id = 1;
        $this->mock->shouldReceive('find')
                   ->with(1)
                   ->once()
                   ->andReturn($this->collection);

        $this->call('GET', 'contactstransactions/1/edit');

        $this->assertViewHas('contactstransaction');
    }

    public function testUpdate()
    {
        $this->mock->shouldReceive('find')
                   ->with(1)
                   ->andReturn(m::mock(['update' => true]));

        $this->validate(true);
        $this->call('PATCH', 'contactstransactions/1');

        $this->assertRedirectedTo('contactstransactions/1');
    }

    public function testUpdateFails()
    {
        $this->mock->shouldReceive('find')->with(1)->andReturn(m::mock(['update' => true]));
        $this->validate(false);
        $this->call('PATCH', 'contactstransactions/1');

        $this->assertRedirectedTo('contactstransactions/1/edit');
        $this->assertSessionHasErrors();
        $this->assertSessionHas('message');
    }

    public function testDestroy()
    {
        $this->mock->shouldReceive('find')->with(1)->andReturn(m::mock(['delete' => true]));

        $this->call('DELETE', 'contactstransactions/1');
    }

    protected function validate($bool)
    {
        Validator::shouldReceive('make')
                ->once()
                ->andReturn(m::mock(['passes' => $bool]));
    }
}