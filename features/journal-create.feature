Feature: Jounral creation rules

    Rule: a user may only have one journal that not completed

    Scenario: user with no journals can create journal
        Given I am a user
        And I have 0 journals
        When I try to create a journal
        Then I have 1 journals
