<?php
/**
 * The solutions video modal, lifted out of the source project's footer.
 *
 * It lived in partials/footer.php there, alongside that project's own site
 * chrome, which this port does not use — so without moving it here the
 * "Watch AI Demo" button and every play control in the solutions rail called
 * window.openVideoModal() into a dialog that did not exist.
 *
 * Kept inside the .aidev wrapper: the modal's styling is in the ported
 * stylesheet, which only applies under it.
 */

declare(strict_types=1);
?>
<div id="solution-video-modal" class="video-modal">
    <div class="video-modal-dialog">
        <div class="video-modal-header">
            <div id="video-modal-title-text" class="video-modal-title">
                <i class="fa-solid fa-play" style="color: var(--accent-cyan);"></i> Live AI Demo
            </div>
            <button class="video-modal-close" aria-label="Close video">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="video-modal-body">
            <video id="solution-video-player" controls playsinline></video>
        </div>
    </div>
</div>
