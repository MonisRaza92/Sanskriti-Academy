<h3 class="user-table-heading">User Management</h3>
<div class="admin-user-table">
    <table class=" table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>City</th>
                <th>Class</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['number']) ?></td>
                        <td><?= htmlspecialchars($user['city']) ?></td>
                        <td><?= htmlspecialchars($user['class']) ?></td>
                        <td><?= htmlspecialchars($user['course']) ?></td>
                        <td>
                            <form method="post" action="?url=deleteUser" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>