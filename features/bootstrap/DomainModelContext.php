<?php

use App\Exceptions\JournalException;
use App\User;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Exception;
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
    public function __construct()
    {

        putenv('APP_ENV=testing');

        parent::__construct();

        $this->setUp();

        $this->withoutExceptionHandling();
    }

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
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
     * @Given I have :index journals
     * @param int $index
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function iHaveJournals(int $count)
    {
        $this->assertSame($this->activeUser->journals->count(), $count);
    }

    /**
     * @When I create journal :index
     */
    public function iCreateJournal($index)
    {
        $this->activeUser->journals()->create([
            "index" => $index,
            "title" => "$index Journal"
        ]);

        $this->activeUser->refresh();
    }

    /**
     * @Then I fail to create journal :index
     */
    public function iFailToCreateJournal($index)
    {
        $failed = null;

        try {
            $this->activeUser->journals()->create([
                "index" => $index,
                "title" => "$index Journal"
            ]);
        } catch (JournalException $exception) {

            $failed = $exception;
        }

        $this->assertTrue(isset($failed));
    }

    /**
     * @Given Journal :index is completed
     */
    public function journalIsCompleted($index)
    {
        $journal = $this->activeUser->journals()->where("index", $index)->firstOrFail();

        $this->assertNotNull($journal->completed_at);
    }

    /**
     * @When Journal :index is incomplete
     */
    public function journalIsIncomplete($index)
    {
        $journal = $this->activeUser->journals()->where("index", $index)->firstOrFail();

        $this->assertNull($journal->completed_at);
    }

    /**
     * @When I try to complete journal :index
     */
    public function iCompleteJournal($index)
    {
        $journal = $this->activeUser->journals()->where("index", $index)->firstOrFail();

        $journal->complete();

        $this->assertNotNull($journal->completed_at);
    }
}
