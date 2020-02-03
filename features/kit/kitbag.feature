Feature: So that I can show off the kit I've forked out a fortune on
  As Barney
  I want info on my diving equipment to be public

  Scenario: Wetsuit with a website and photo
    Given that I have a "5.5/6.5mm Delta Flex Semi-Tech Wetsuit"
    And the manufacturer is "Northern Diver"
    And the product URI is "https://www.ndiver.com/delta-flex-semi-tech-wetsuit"
    And the product has a photo
    When I look at the item of kit
    Then I see all the information
