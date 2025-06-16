<?php if (!empty($course['file_path'])): ?>
    <?php
    $fileExt = pathinfo($course['file_path'], PATHINFO_EXTENSION);
    $videoExtensions = ['mp4', 'webm', 'ogg'];
    ?>

    <?php if (in_array(strtolower($fileExt), $videoExtensions)): ?>
        <video width="100%" height="auto" controls>
            <source src="<?= htmlspecialchars($course['file_path']) ?>" type="video/<?= $fileExt ?>">
            Your browser does not support the video tag.
        </video>
    <?php else: ?>
        <!-- Agar video nahi hai to file ke liye link de do -->
        <a href="<?= htmlspecialchars($course['file_path']) ?>" target="_blank">View File</a>
    <?php endif; ?>
<?php else: ?>
    <p>N/A</p>
<?php endif; ?>