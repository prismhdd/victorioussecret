**Use Case:** Receiving and sending recommendations

**Identifier:** UC6

**Description:** Models a user sending a recommendation to another user

**Actors:** User1, User2

**Preconditions:** UC1 - Users both have accounts with the website, UC2/3 - The album the user wishes to share is in their library

**Stakeholders:** _User:_ Wishes to recommend another user of an album

**Flow of Events:**
  1. User1 selects option to recommend an album
  1. System presents empty fields for required information
  1. User1 enters in all required information
  1. System verifies the given information
  1. System sends notification to User2

**Postconditions:** User2 has received a recommendation from User1