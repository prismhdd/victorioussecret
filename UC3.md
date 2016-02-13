**Use Case:** Adding artists via the website

**Identifier:** UC3

**Description:** Models a user updating their artist information directly from the website

**Actors:** User

**Preconditions:** UC1 - User has an account with the website and is logged in

**Stakeholders:** _User:_ Wishes to add an artist or album to the collection already stored in their account directly via website _Victorious Secret:_ Efficiently handle incoming user data

**Flow of Events:**
  1. User chooses the 'Update Collection' option on the website
  1. System presents empty fields for required information (artists and/or albums)
  1. User enters all required information into the fields
  1. System accepts the given information and modifies the users account
  1. System provides summary of the changes made

**Postconditions:** User's account has been updated with new artists