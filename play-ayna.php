<?php
// Get the channel ID from the URL
$channelId = $_GET['id'] ?? null;

if (!$channelId) {
    echo 'Error: Channel ID is required';
    exit;
}

// Load the JSON playlist data
$jsonUrl = 'https://ayna-api.iptvbd.xyz/api/aynaott.json';
$jsonData = file_get_contents($jsonUrl);

if ($jsonData === false) {
    echo 'Error: Unable to fetch playlist data';
    exit;
}

$playlist = json_decode($jsonData, true);

if (!$playlist || !isset($playlist['channels'])) {
    echo 'Error: Invalid playlist data';
    exit;
}

// Find the selected channel by ID
$selectedChannel = null;

foreach ($playlist['channels'] as $channel) {
    if ($channel['id'] == $channelId) {
        $selectedChannel = $channel;
        break;
    }
}

if (!$selectedChannel) {
    echo 'Error: Invalid channel ID';
    exit;
}

// Extract channel details
$videoUrl = $selectedChannel['link'];
$logoUrl = $selectedChannel['logo'];
$videoTitle = $selectedChannel['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($videoTitle); ?></title>
    <link rel="stylesheet" href="./player.css">
<style>
        #player {
            position: absolute;
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>
<body>
<div id="player"></div>

<script src="https://content.jwplatform.com/libraries/KB5zFt7A.js"></script>
<script>
const playerInstance = jwplayer("player").setup({
    controls: true,
    sharing: true,
    displaytitle: true,
    autoplay: true,
    displaydescription: true,
    abouttext: "Video Player By LOKIIPTV",
    aboutlink: "https://t.me/lokiiptvofficial",

    skin: {
        name: "netflix"
    },

    logo: {
        file: "<?php echo $logoUrl; ?>",
        link: "https://t.me/lokiiptvofficial"
    },

    captions: {
        color: "#FFF",
        fontSize: 14,
        backgroundOpacity: 0,
        edgeStyle: "raised"
    },

    playlist: [
        {
            title: "<?php echo htmlspecialchars($videoTitle); ?>",
            description: "You're Watching",
            image: "<?php echo $logoUrl; ?>",
            sources: [
                {
                    file: "<?php echo $videoUrl; ?>",
                    type: "application/x-mpegURL",
                    label: "HD",
                    default: true
                }
            ]
        }
    ]
});



</script>
</body>
</html> 