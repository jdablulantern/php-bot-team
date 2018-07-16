How the Algorithm Works


Creating the players

Each team creates a set of 15 players of object bot. The Player names and ID's are created using the bot constructor, running through a method that generates random unique indexes and uses those indexes to pull names from an array of available names. We generate unique ID's by taking the first letter of the first names and the first 2 letters of the last name, and using the unique randomize number generator to assign a unique numerical code, assuring that the ID's of the bots will never be the same as someone else on the team.

Generating Total Attribute Score(TAS)

From there we generate the TAS values for each player created. We let the first player generated have a random attribute value somewhere between 1 and the max possible value while still allowing for every other value to be unique. It is important that we first define what is the max amount a single player can have, while still allowing for unique individual TAS values for the rest of the team. Even though a player is allowed to have up to 100 points, giving one bot 100 points could cause every other player to have a TAS value that isn't unique.
Generate an average from the remaining TAS and use the remaining count of players to create a top generated unique individual TAS. We apply unique TAS values for each player by taking that top value, applying it, and then reducing by 1 as we go, skipping the original random attribute generated if that TAS falls within the range of the scores being generated.
On the last generated attribute, we check the value of the first random attribute number generated against the top generated unique value to determine whether we use the next standard TAS Value or use the Remaining TAS. This should remove the chance of the tas of players being equal with the TAS of someone else on the team. Once we have the TAS for each bot we apply it, running a randomizer to determine which attributes that bot will receive between strength, speed and agility.

Sorting the Team

Once the team is created we then basically sort the team in descending order from highest TAS to lowest. Once that is done we take the top ten player bots on the team and set them as the starters, and then add the rest of the bots as bench players

League Rules and standards

Salary Cap: Each team is allowed 175 Total Attribute Score
Max Player Score: Each Player is allowed a max of 100 Total Attribute Score
Unique Players: Every player must have:
A unique name
A unique ID
A unique TAS
Player Count: Each team must have 15 players
10 starters
5 Bench players