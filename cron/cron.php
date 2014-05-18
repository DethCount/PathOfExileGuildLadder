<?php
ini_set('error_reporting', E_ALL);

$guildUsers = json_decode(file_get_contents(__DIR__ . '/../cache/guild.json'));
if (empty($guildUsers)) {
    $guildUsers = array(
        'belgarionderiva',
        'count26ndie',
        'teogatts',
        'heracles_41',
        'lordmacphilo',
        'quentino2001',
        'galaxypayze',
        'math170101',
        'silvernightz'
    );
}
$url = 'http://api.pathofexile.com/leagues/2 Week Charity Event?ladder=1&ladderLimit=200&ladderOffset=';
$userRanked = array();
$offset = 0;

echo '<ul>';

while ($offset < 15000) {
    $response = file_get_contents($url . $offset);
    $response = json_decode($response);
    if (!isset($response->ladder->entries)) {
        throw new Exception('No entries found in API response');
    }

    $i = 0;
    foreach ($response->ladder->entries as $entry) {
        if (isset($entry->account->name) && in_array(strtolower($entry->account->name), $guildUsers)) {
            $rank = $offset + $i + 1;
            $userRanked[$entry->account->name][$rank] = $entry;
            echo '<li>#' . $rank . ' : ' . $entry->account->name. ' => ' . $entry->character->name 
                . ' (' . $entry->character->class . ' lvl ' . $entry->character->level . ' ' . $entry->character->experience . ' xp)</li>';
        }
        $i++;
    }

    if (count($userRanked) >= count($guildUsers)) {
        break;
    }

    $offset += 200;
}

echo '</ul>';

file_put_contents(__DIR__ . '/../cache/data.php', json_encode($userRanked));

