<!-- Add Event Form -->
<div class="row">
    <div class="col-md-6 col-lg-6 col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white text-center">
                <h2 class="mb-0">Add Event</h2>
            </div>
            <div class="card-body">
                <form id="addEventForm" enctype="multipart/form-data" method="POST" action="?url=adminAddEvent">
                    <input type="hidden" name="action" value="adminAddEvents">
                    <div class="mb-3">
                        <label for="eventTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="eventTitle" name="event_name">
                    </div>
                    <div class="mb-3">
                        <label for="eventImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="eventImage" name="event_image" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="eventLink" class="form-label">Link</label>
                        <input type="text" class="form-control" id="eventLink" name="event_link">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add Event</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6 col-12 mb-4">
        <div class="card shadow-sm" style="height: 385px; overflow-y: auto;">
            <div class="card-header bg-secondary text-white text-center">
                <h2 class="mb-0">Events List</h2>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php if (!empty($events)) : ?>
                        <?php foreach ($events as $event) : ?>
                            <?php if (empty($event['event_image'])) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1"><?php echo htmlspecialchars($event['event_name']); ?></h5>
                                        <a href="<?php echo htmlspecialchars($event['event_link']); ?>" target="_blank" class="text-decoration-none"><?php echo htmlspecialchars($event['event_link']); ?></a>
                                    </div>
                                    <div>
                                        <button class="btn btn-danger btn-sm delete-event" onclick="window.location.href='?url=adminDeleteEvent&id=<?php echo $event['id']; ?>'" data-id="<?php echo $event['id']; ?>">Delete</button>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li class="list-group-item">No events found.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white text-center">
                <h2 class="mb-0">Events List</h2>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php if (!empty($events)) : ?>
                        <?php foreach ($events as $event) : ?>
                            <?php if (!empty($event['event_image'])) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1"><?php echo htmlspecialchars($event['event_name']); ?></h5>
                                        <a href="<?php echo htmlspecialchars($event['event_link']); ?>" target="_blank" class="text-decoration-none"><?php echo htmlspecialchars($event['event_link']); ?></a>
                                    </div>
                                    <img src="<?php echo htmlspecialchars($event['event_image']); ?>" alt="" style="width: 100px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    <div>
                                        <button class="btn btn-danger btn-sm delete-event" onclick="window.location.href='?url=adminDeleteEvent&id=<?php echo $event['id']; ?>'" data-id="<?php echo $event['id']; ?>">Delete</button>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li class="list-group-item">No events found.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>