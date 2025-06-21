<div class="container <?php echo empty($events) ? 'd-none' : ''; ?>">
    <div class="row">
        <div class="col-lg-8 col-12 mb-3 px-4">
            <?php
            $sliderImages = [];
            if (!empty($events)) {
            foreach ($events as $event) {
                if (!empty($event['event_image'])) {
                $sliderImages[] = [
                    'image' => $event['event_image'],
                    'link' => !empty($event['event_link']) ? $event['event_link'] : null
                ];
                }
            }
            }
            ?>
            <?php if (!empty($sliderImages)) : ?>
                <style>
            #event-slider {
                width: 100%;
                height: 400px;
                overflow: hidden;
            }
            @media screen and (max-width: 768px) {
                #event-slider{
                    height: 250px; /* Adjust height for smaller screens */
                }
                
            }
                </style>
            <div id="event-slider" class="position-relative rounded">
            <?php foreach ($sliderImages as $idx => $imgData) : ?>
                <?php if ($imgData['link']) : ?>
                <a href="<?php echo htmlspecialchars($imgData['link']); ?>" target="_blank" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <img src="<?php echo htmlspecialchars($imgData['image']); ?>"
                     class="img-fluid rounded position-absolute w-100"
                     style="object-fit:cover; top:0; left:0; transition:opacity 0.5s; opacity:<?php echo $idx === 0 ? '1' : '0'; ?>;"
                     data-slider-index="<?php echo $idx; ?>">
                </a>
                <?php else : ?>
                <img src="<?php echo htmlspecialchars($imgData['image']); ?>"
                     class="img-fluid rounded position-absolute w-100"
                     style="object-fit:cover; top:0; left:0; transition:opacity 0.5s; opacity:<?php echo $idx === 0 ? '1' : '0'; ?>;"
                     data-slider-index="<?php echo $idx; ?>">
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
            <script>
            (function() {
                const images = document.querySelectorAll('#event-slider img');
                let current = 0;
                setInterval(() => {
                images[current].style.opacity = 0;
                current = (current + 1) % images.length;
                images[current].style.opacity = 1;
                }, 3000);
            })();
            </script>
            <?php else : ?>
            <li class="list-group-item">No events found.</li>
            <?php endif; ?>
        </div>
        <div class="col-lg-4 col-12 mb-5 px-4 px-lg-0">
            <div class="card" style="border: 2px solid #920000; height: 400px; overflow: hidden; scrollbar-width: none;">
                <div class="card-header" style="background-color:var(--accent-color);">
                    <h5 class="mb-0 text-white text-uppercase ">Upcoming Events</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php if (!empty($events)) : ?>
                            <?php foreach ($events as $event) : ?>
                                <?php if (empty($event['event_image'])) : ?>
                                    <li class="list-group-item ps-0 py-1" style="display: flex; justify-content: space-between; align-items: center;">
                                        <a class="btn text-uppercase fw-bold" href="<?php echo htmlspecialchars($event['event_link']); ?>" target="_blank">
                                            <?php echo htmlspecialchars($event['event_name']); ?>
                                        </a>
                                        <i class="fas fa-external-link-alt"></i>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li class="list-group-item">No upcoming events found.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>