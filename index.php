<html>
<head>
<title>Warhawk leaderboard extractor</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link href="theme.css" rel="stylesheet" />
</head>
<body>
<pre>
<?php
$inputDir = "input/";
$outputDir = "output/";

if (!file_exists($outputDir)) {
	mkdir($outputDir);
}

$leaderboardFiles = glob($inputDir . "Stats_CareerLeaderboard.jsp*");
natsort($leaderboardFiles);

$xmlstr = file_get_contents ( $leaderboardFiles[0] );
$xmlstr = str_replace("borderClass=\"BORDERGRID1\"", "", $xmlstr);

$svml = new SimpleXMLElement($xmlstr);


$sortedFiles = array();

foreach ($leaderboardFiles as $fileName) {

	parse_str(substr($fileName, 84), $output);

	if (!isset($output['sortCol']) && !isset($output['start'])) {
		$output['start'] = 0;
		$output['sortCol'] = 0;
	}
	else if (!isset($output['start'])) {
		$output['start'] = 0;
	}

	$sortedFiles[ $output['sortCol'] ][ $output['start'] / 12 ] = $fileName;
}

$columnNames = array("Rank", "Name", "Total Points", "Team Points", "Combat Points", "Bonus Points", "Time Played", "Kills", "Deaths", "Kill/Death Ratio", "Accuracy", "Wins", "Losses", "Wins/Losses", "Score/Min", "DM Points", "TDM Points", "CTF Points", "Zones Points", "Miles Walked", "Miles Driven", "Miles Flown", "Hero Points", "Collection Points");

$tableColumns = "<thead>" . PHP_EOL . "<tr>" . PHP_EOL;
foreach ($columnNames as $key => $columnName) {
	$tableColumns .= "<th scope=\"col\">" . $svml->GRID->COLUMNS->COLUMN[$key] . ":<br />" . $columnName . "</th>" . PHP_EOL;
}
$tableColumns .= "</tr>" . PHP_EOL . "</thead>";

$columnFileNames = array();
foreach ($columnNames as $key => $columnName) {
	$columnFileNames[$key] = $columnName;
	$columnFileNames[$key] = str_replace(' ', '-', $columnFileNames[$key]);
	$columnFileNames[$key] = str_replace('/', '-', $columnFileNames[$key]);
	$columnFileNames[$key] = strtolower($columnFileNames[$key]);
}

echo PHP_EOL . "<ol>" . PHP_EOL;

foreach ($sortedFiles as $key => $currentColumn) {
	$pageTitle = $columnNames[($key + 2)] . " leaderboards stats";
	$pageDescription = $pageTitle . " from &lt; 24 hours before Warhawk's online shutdown.";
	$htmlFile = $columnFileNames[($key + 2)] . ".html";
	$htmlOutput = "<!DOCTYPE html>" . PHP_EOL;
	$htmlOutput .= "<html lang=\"en\">" . PHP_EOL;
	$htmlOutput .= "<head>" . PHP_EOL;
	$htmlOutput .= "<title>" . $pageTitle . " - Warhawk PS3</title>";
	$htmlOutput .= "<link href=\"../../theme.css\" rel=\"stylesheet\" />" . PHP_EOL;
	$htmlOutput .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />" . PHP_EOL;
	$htmlOutput .= "<meta name=\"title\" content=\"" . $pageTitle . "\" />" . PHP_EOL;
	$htmlOutput .= "<meta name=\"description\" content=\"" . $pageTitle . " from &lt; 24 hours before Warhawk's online shutdown.\" />" . PHP_EOL;
	$htmlOutput .= "<meta property=\"og:type\" content=\"website\" />" . PHP_EOL;
	$htmlOutput .= "<meta property=\"og:url\" content=\"https://warhawk-ps3.github.io/stats/leaderboards/" . $htmlFile . "\" />" . PHP_EOL;
	$htmlOutput .= "<meta property=\"og:title\" content=\"" . $pageTitle . "\" />" . PHP_EOL;
	$htmlOutput .= "<meta property=\"og:description\" content=\"" . $pageTitle . " from &lt; 24 hours before Warhawk's online shutdown.\" />" . PHP_EOL;
	$htmlOutput .= "<meta property=\"og:site_name\" content=\"Warhawk (PS3)\" />" . PHP_EOL;
	$htmlOutput .= "<meta property=\"twitter:card\" content=\"summary\" />" . PHP_EOL;
	$htmlOutput .= "<meta property=\"twitter:url\" content=\"https://warhawk-ps3.github.io/stats/leaderboards/" . $htmlFile . "\" />" . PHP_EOL;
	$htmlOutput .= "<meta property=\"twitter:title\" content=\"" . $pageTitle . "\" />" . PHP_EOL;
	$htmlOutput .= "<meta property=\"twitter:description\" content=\"" . $pageTitle . " from &lt; 24 hours before Warhawk's online shutdown.\" />" . PHP_EOL;
	$htmlOutput .= "</head>" . PHP_EOL;
	$htmlOutput .= "<body>" . PHP_EOL;
	$htmlOutput .= "<main>" . PHP_EOL;
	$htmlOutput .= "<h1>" . $pageTitle . "</h1>" . PHP_EOL;
	$htmlOutput .= "<p>" . $pageDescription . "</p>" . PHP_EOL;
	$htmlOutput .= "<table>" . PHP_EOL;
	$htmlOutput .= $tableColumns . "" . PHP_EOL;

	foreach ($currentColumn as $fileName) {
		$xmlstr = file_get_contents ( $fileName );
		$xmlstr = str_replace("borderClass=\"BORDERGRID1\"", "", $xmlstr);
		$svml = new SimpleXMLElement($xmlstr);

		$htmlOutput .= "<!--/WARHAWK_SVML/stats/" . str_replace('%3f', '?', basename($fileName)) . "-->" . PHP_EOL;

		$htmlOutput .= "<tbody>" . PHP_EOL;
		foreach ($svml->GRID->ROWS->ROW as $row) {
			$htmlOutput .= "<tr>" . PHP_EOL;
			foreach ($row->CELL as $cell) {
				$htmlOutput .= "<td>" . $cell . "</td>" . PHP_EOL;
			}
			$htmlOutput .= "</tr>" . PHP_EOL;
		}
		$htmlOutput .= "</tbody>" . PHP_EOL;
	}
	$htmlOutput .= "</table>" . PHP_EOL;
	$htmlOutput .= "</main>" . PHP_EOL;
	$htmlOutput .= "</body>" . PHP_EOL;
	$htmlOutput .= "</html>" . PHP_EOL;

	file_put_contents($outputDir . $columnFileNames[($key + 2)] . ".html", $htmlOutput);

	echo "<li><a href=\"" . $outputDir . $htmlFile . "\">" . $columnNames[($key + 2)] . "</a></li>" . PHP_EOL;
}

echo "</ol>" . PHP_EOL;
?>
</pre>
</body>
</html>
