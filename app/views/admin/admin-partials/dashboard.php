<div class="container-fluid admin-dashboard position-relative mt-5 pt-4">
    <div class="container ps-0">
        <div class="row">
            <div class="col-lg-3">
                <?php include __DIR__ . '/admin-sidebar.php'; ?>
            </div>
            <div class="col-lg-9">
                <?php include __DIR__ . '/admin-stats.php'; ?>
                <div style="max-height: 579px; overflow-y: auto; border: 1px solid var(--background-color); border-radius: 5px;">
                    <?php include __DIR__ . '/admin-user-table.php'; ?>
                </div>
            </div>
        </div>
        <div style="max-height: 600px; overflow-y: auto; border: 1px solid var(--background-color); border-radius: 5px; margin-top: 20px;">
            <?php include __DIR__ . '/uploaded-courses.php'; ?>
        </div>
        
    </div>
</div>