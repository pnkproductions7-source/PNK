<?php
$videos = json_decode(file_get_contents('videos.json'), true);

// Συνάρτηση για τη δημιουργία του σωστού Embed URL ή Iframe
function getYouTubeEmbedUrl($url) {
    $id = '';
    if (preg_match('/v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $id = $matches[1];
    } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
        $id = $matches[1];
    }
    
    return !empty($id) ? "https://www.youtube.com/embed/" . $id : htmlspecialchars($url);
}

// Ομαδοποίηση βίντεο ανά κατηγορία για ευκολότερη διαχείριση
$categories = [
    "Οπτικοακουστική Κάλυψη Μυστηρίων" => ["video1", "video2", "video3", "video4", "video5", "video6"],
    "Κάλυψη Εκδηλώσεων" => ["video7", "video8", "video9", "video10", "video11", "video12"],
    "Διαφημιστικά Βίντεο" => ["video13", "video14", "video15", "video16", "video17", "video18"],
    "Μουσικά Βίντεο" => ["video19", "video20", "video21", "video22", "video23", "video24"]
];
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./src/css/style.css">
    <title>PNK Video Productions - Gallery</title>
</head>
<body>

    <nav class="mobile-nav">
        <div class="nav-inner">
            <a href="index.html" class="logo-link">
                <img src="./static/img/logos/pnk-logo.png" alt="Logo" class="logo">
            </a>
            <ul class="desktop-menu">
                <li><a href="collection.php">Συλλογή</a></li>
                <li><a href="contact.html">Επικοινωνία</a></li>
            </ul>
            <button class="menu-toggle" aria-label="Toggle menu">
                <img src="./static/img/icons/menu.svg" class="icon hamburger" alt="Open menu">
            </button>
            <div class="dropdown-menu">
                <ul class="menu-items">
                    <li><a href="collection.php">Συλλογή</a></li>
                    <li><a href="contact.html">Επικοινωνία</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="gallery" class="content-section">
        <div class="gallery-inner">
            <h1>Gallery</h1>

            <?php foreach ($categories as $title => $videoKeys): ?>
                <div class="gallery-category">
                    <h2><?php echo $title; ?></h2>
                    <div class="gallery-grid">
                        <?php foreach ($videoKeys as $key): ?>
                            <?php if (isset($videos[$key])): ?>
                                <div class="gallery-item">
                                    <div class="video-wrapper" onclick="this.classList.add('clicked')">
                                        <iframe 
                                            class="video-overlay"
                                            src="<?php echo getYouTubeEmbedUrl($videos[$key]); ?>" 
                                            frameborder="0" 
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </section>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="./static/img/logos/logo.jpg" alt="PNK Logo" class="logo">
            </div>
            <div class="social-icons">
                <a href="https://www.facebook.com/..." target="_blank" class="social-link"><div class="icon-circle"><img src="./static/img/icons/facebook.svg" alt="Facebook"></div></a>
                <a href="https://www.instagram.com/..." target="_blank" class="social-link"><div class="icon-circle"><img src="./static/img/icons/instagram.svg" alt="Instagram"></div></a>
            </div>
            <div class="footer-copyright">
                © <?php echo date("Y"); ?> PNK Video Productions. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="test.js"></script>
    <script src="./src/js/nav.js"></script>
</body>
</html>
