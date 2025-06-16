<h2 class="upload-course-heading">Manage Courses</h2>
<div class="upload-course-form">
    <h2>UPLOAD A COURSE</h2>
    <form action="?url=addCourse" method="POST" enctype="multipart/form-data" class="row g-3 mt-0">
        <div class="col-12 col-lg-6">
            <input type="text" name="course_name" class="form-control" placeholder="Course Name" required>
        </div>
        <div class="col-12 col-lg-6">
            <input type="text" name="teacher_name" class="form-control" placeholder="Teacher Name" required>
        </div>
        <div class="col-12 col-lg-6">
            <input type="text" name="category" class="form-control" placeholder="Category" required>
        </div>
        <div class="col-12 col-lg-6">
            <input type="text" name="class" class="form-control" placeholder="Class" required>
        </div>
        <div class="col-12">
            <textarea name="description" class="form-control" placeholder="Course Description" rows="3" required></textarea>
        </div>
        <div class="col-12 col-lg-6">
            <input type="file" name="course_file" class="form-control" required>
        </div>
        <div class="col-12 col-lg-3">
            <select name="file_type" class="form-select">
                <option value="video">Video</option>
                <option value="pdf">PDF</option>
            </select>
        </div>
        <div class="col-12 col-lg-3">
            <input type="text" name="price" class="form-control" placeholder="Price" required>
        </div>
        <div class="form-group col-12">
            <label for="thumbnail" class="p-2">Upload Thumbnail Of Video</label>
            <input type="file" name="thumbnail" class="form-control" id="thumbnail" placeholder="Upload Thumbnail Of Video">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success w-100">Upload Course</button>
        </div>
    </form>
</div>
