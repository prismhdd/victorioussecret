**Use Case:** Receiving a notification of a new album

**Identifier:** UC4

**Description:** Models a user receiving a notification of a new album from an artist in their library

**Actors:** User

**Preconditions:** UC1 - User has an account with the website and is logged in, UC2/3 - User has a library populated with artists

**Stakeholders:** _User:_ Wishes to be notified of new albums

**Flow of Events:**
  1. System compares new releases to user's library
  1. System finds new albums for the user
  1. System notifies user of found albums
  1. User is notified of new album


**Postconditions:** User has successfully received a notification alerting them to a new album