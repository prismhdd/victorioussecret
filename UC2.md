**Use Case:** Adding artists via Uploading Application

**Identifier:** UC2

**Description:** Models a user uploading information from their local music library to their account

**Actors:** User

**Preconditions:** UC1 - User has an account with the website and is logged in

**Stakeholders:** _User:_ Wishes to retrieve the Uploading Application and then transfer their library to the website _Victorious Secret:_ Efficiently store incoming user data

**Flow of Events:**
  1. User chooses to download the Uploading Application to their local machine
    * User runs the application and chooses a folder to scan
    * The application scans the selected folder and outputs a data file
  1. User uploads the data file to their account
  1. System accepts the file and adds all data to the user account
  1. System shows summary of all the changes made to the user's account

**Postconditions:** User's account has been updated with new artists