# Warhawk profile extractor

Transforms Warhawk's leaderboard XML data into HTML.

Used by [warhawk-ps3.github.io](https://warhawk-ps3.github.io/).

## How to use

1. Capture packets while navigating through Warhawk's online leaderboard.
2. Export all Stats_CareerLeaderboard.jsp* files from your capture.
3. Create an /input/ folder and place those files in it.
4. Open index.php in a web browser.
5. Visit the links in the index page or check the /output/ folder.

## Column headers

The leaderboard XML data uses abbreviations for column headers... some of which differ from what they're called in Warhawk.

Here's an outline of their meanings:

* **PTS:** Total Points
* **TS:** Team Points
* **CS:** Combat Points
* **BS:** Bonus Points
* **GT:** Time Played
* **K:** Kills
* **D:** Deaths
* **KDR:** Kill/Death Ratio
* **GA:** Accuracy
* **W:** Wins
* **L:** Losses
* **WLR:** Wins/Losses
* **SPM:** Score/Min
* **DS:** DM Points
* **TDS:** TDM Points
* **CTF:** CTF Points
* **ZS:** Zones Points
* **MW:** Miles Walked
* **MD:** Miles Driven
* **MF:** Miles Flown
* **MRK:** Hero Points
* **COL:** Collection Points