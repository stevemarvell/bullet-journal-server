<?php

use App\User;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Tests\TestCase;


/**
 * Defines application features from the specific context.
 */
class DomainModelContext extends TestCase implements Context
{
    protected $activeUser;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct() {

        putenv('APP_ENV=testing');

        parent::__construct();

        $this->setUp();

        $this->withoutExceptionHandling();
    }

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope) {
        $this->artisan('migrate:fresh');
    }

    /**
     * @Given I am a user
     */
    public function iAmAUser()
    {
        $this->activeUser = factory(User::class)->create();
    }


    /**
     * @Given I have :arg1 journals
     * @param int $arg1
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function iHaveJournals(int $arg1)
    {
        $this->assertSame($this->activeUser->journals->count(),$arg1);
    }

    /**
     * @When I try to create a journal
     */
    public function iTryToCreateAJournal()
    {
        $this->activeUser->journals()->create([
            "index" => "A",
            "title" => "A Journal"
        ]);

        $this->activeUser->refresh();
    }
}
