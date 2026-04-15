<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <h1>My Profile</h1>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Profile Image -->
        <div class="col-md-4 text-center">
            <?php if(!empty($user['profile_image'])): ?>
                <img id="profile-img" src="<?= base_url('uploads/profiles/' . esc($user['profile_image'])) ?>" 
                     class="img-fluid rounded-circle mb-3" style="width:150px; height:150px;">
            <?php else: ?>
                <img id="profile-img" src="<?= base_url('uploads/profiles/default.png') ?>" 
                     class="img-fluid rounded-circle mb-3" style="width:150px; height:150px;">
            <?php endif; ?>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                Edit Profile
            </button>
        </div>

        <!-- Profile Details -->
        <div class="col-md-8">
            <dl class="row">
                <dt class="col-sm-4">Name</dt>
                <dd class="col-sm-8"><?= esc($user['fullname']) ?></dd>

                <dt class="col-sm-4">Email</dt>
                <dd class="col-sm-8"><?= esc($user['username']) ?></dd>

                <dt class="col-sm-4">Student ID</dt>
                <dd class="col-sm-8"><?= esc($user['student_id']) ?></dd>

                <dt class="col-sm-4">Course</dt>
                <dd class="col-sm-8"><?= esc($user['course']) ?></dd>

                <dt class="col-sm-4">Year Level</dt>
                <dd class="col-sm-8"><?= esc($user['year_level']) ?></dd>

                <dt class="col-sm-4">Section</dt>
                <dd class="col-sm-8"><?= esc($user['section']) ?></dd>

                <dt class="col-sm-4">Phone</dt>
                <dd class="col-sm-8"><?= esc($user['phone']) ?></dd>

                <dt class="col-sm-4">Address</dt>
                <dd class="col-sm-8"><?= esc($user['address']) ?></dd>
            </dl>
        </div>
    </div>
</div>

<!-- Edit Profile  -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="<?= base_url('profile/update') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileLabel">Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row">
          <div class="col-md-4 text-center">
              <img id="preview" src="<?= !empty($user['profile_image']) ? base_url('uploads/profiles/' . esc($user['profile_image'])) : base_url('uploads/profiles/default.png') ?>" 
                   class="img-fluid rounded-circle mb-3" style="width:150px; height:150px;">
              <input type="file" name="profile_image" id="profile_image" accept="image/*" class="form-control">
          </div>
          <div class="col-md-8">
              <div class="mb-3">
                  <label class="form-label">Name</label>
                  <input type="text" name="fullname" class="form-control" value="<?= old('fullname', esc($user['fullname'])) ?>">
              </div>
              <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="username" class="form-control" value="<?= old('username', esc($user['username'])) ?>">
              </div>
              <div class="mb-3">
                <label class="form-label">Student ID</label>
                <input type="text" name="student_id" class="form-control" value="<?= old('student_id', esc($user['student_id'])) ?>">
            </div>
              <div class="mb-3">
                  <label class="form-label">Course</label>
                  <input type="text" name="course" class="form-control" value="<?= old('course', esc($user['course'])) ?>">
              </div>
              <div class="mb-3">
                  <label class="form-label">Year Level</label>
                  <input type="number" name="year_level" class="form-control" value="<?= old('year_level', esc($user['year_level'])) ?>">
              </div>
              <div class="mb-3">
                  <label class="form-label">Section</label>
                  <input type="text" name="section" class="form-control" value="<?= old('section', esc($user['section'])) ?>">
              </div>
              <div class="mb-3">
                  <label class="form-label">Phone</label>
                  <input type="text" name="phone" class="form-control" value="<?= old('phone', esc($user['phone'])) ?>">
              </div>
              <div class="mb-3">
                  <label class="form-label">Address</label>
                  <textarea name="address" class="form-control" rows="3"><?= old('address', esc($user['address'])) ?></textarea>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JS for live preview -->
<script>
document.getElementById('profile_image').addEventListener('change', function(event){
    const reader = new FileReader();
    reader.onload = function(e){
        document.getElementById('preview').src = e.target.result;
    }
    reader.readAsDataURL(event.target.files[0]);
});
</script>

<?= $this->endSection() ?>