Feature: Journal creation rules

    Rule: a user may not have two journals with the same index
    Rule: a user may not have two journals with the same index

        Example: user with no journals can create journal
            Given I am a user
            And I have 0 journals
            When I create journal "A"
            Then I have 1 journals

        Example:: user may not have two journals with the same index
            Given I am a user
            When I create journal "A"
            Then I fail to create journal "A"

        Example:: user with no journals that are not complete
            Given I am a user
            When I create journal "A"
            And Journal "A" is incomplete
            Then I fail to create journal "B"

