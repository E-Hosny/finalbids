@include('frontend.layouts.header')

    <section class="dtl-user-box">
      <div class="container">
        <div class="account-outer-box">
          <div class="row">
           @include('frontend.dashboard.sidebar')
            <div class="col-md-9 ">
              <div class="heading-act">
              @if(session('locale') === 'en')   
                <h2 text-align="center">My Account <button type="submit"  id="editProfileButton" class="btn btn-secondary">Edit Profile</button></h2>
              @elseif(session('locale') === 'ar')
                <h2 text-align="center"> حسابي <button type="submit"  id="editProfileButton" class="btn btn-secondary">تحرير الملف الشخصي</button></h2>
              @else
                <h2 text-align="center">My Account <button type="submit"  id="editProfileButton" class="btn btn-secondary">Edit Profile</button></h2>
              @endif
              </div>
              <div class="profile-detail-section">
                <form action="{{ route('profileupdate', ['id' => $users->id]) }}" class="cmn-frm px-4" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="profile-side border-0 py-4">
                    
                    <div class="img-prfe" id="imgsrcc">
                        <label class="m-0" for="profile-upload">
                        <img id="preview-image" src="https://img.freepik.com/premium-vector/man-avatar-profile-picture-vector-illustration_268834-538.jpg" alt="Preview Image">
                        </label>
                        <input type="file" id="profile-upload" name="profile_image" class="form-control">
                        
                      </div>

                  </div>
                  <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group">
                          <label for="">First Name</label>
                          <input type="text" name="first_name" id="" value="{{ old('first_name', $users->first_name) }}" readonly required> 
                        
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                      <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" name="last_name" id="" value="{{ old('last_name', $users->last_name) }}" readonly required>
                      </div>
                  </div>
                  <div class="col-md-12 col-lg-6">
                    <div class="form-group">
                      <label for="">Email Address</label>
                      <input type="text" name="email" id="" value="{{ old('email', $users->email) }}" readonly required>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                  <div class="form-group">
                    <label for="">Phone Number</label>
                    <input type="text" name="phone" id="" value="{{ old('phone', $users->phone) }}" readonly required>
                  </div>
              </div>
              <div class="col-md-12">
             
            </div>
                  </div>
                </form> 
              </div>
              <div class="notificn-off mb-5 mx-4"  id="changePasswordLink">
              @if(session('locale') === 'en')   
                <a href="{{ url('changepassword') }}">Change Password</a>
              @elseif(session('locale') === 'ar')
                <a href="{{ url('changepassword') }}">تغيير كلمة المرور</a>
              @else
                <a href="{{ url('changepassword') }}">Change Password</a>
              @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<script>
$(document).ready(function() {
  const previewImage = document.getElementById('preview-image');
  const fileInput = document.getElementById('profile-upload');
  $("#imgsrcc").hide();
  $(fileInput).change(function() {
    const file = this.files[0];
    if (file) {
      // Display the selected image in the preview
      previewImage.src = URL.createObjectURL(file);
    }
  });
  $(previewImage).one('click', function() {
    fileInput.click();
  });

  $("#editProfileButton").click(function() {
    var $button = $(this);

    if ($button.text() === "Edit Profile") {
      $button.text("Save");
      $("input[readonly]").prop("readonly", false);
      $(".error-message").remove();
      $("#notificationSection").hide();
      $("#changePasswordLink").hide();
      $("#imgsrcc").show();
      $(previewImage).off('click');
    } else if ($button.text() === "Save") {
      $(".error-message").remove();
        // Check if any fields are empty
      var emptyFields = $("input[required]").filter(function() {
        return !this.value.trim();
      });

      if (emptyFields.length > 0) {
        emptyFields.each(function() {
          $(this).after('<div class="error-message test">This field is required.</div>');
        });
        return;
      }

          var formData = new FormData($('form')[0]);

      $.ajax({
        type: 'POST',
        url: '{{ route("profileupdate", ["id" => $users->id]) }}',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.success) {
            $button.text("Edit Profile");
            $("input[readonly]").prop("readonly", true);
            $("#notificationSection").show();
            $("#changePasswordLink").show();
              if (formData.get('profile_image')) {
                previewImage.src = URL.createObjectURL(formData.get('profile_image'));
              }
              Swal.fire({
              icon: 'success',
              title: 'Profile Updated Successfully',
              showConfirmButton: false,
              timer: 1500
            });

            location.reload();

          } else {
            alert('Failed to update profile');
          }
        },
        error: function(error) {
          console.error(error);
          alert('Error updating profile');
        }
      });
    }
  });
$('.navTrigger').click(function () {
  $(this).toggleClass('active');
  console.log("Clicked menu");
  $("#mainListDiv").toggleClass("show_list");
  $("#mainListDiv").fadeIn();

});
$('.menu-show-mn').click(function () {
  $('.menu-ul').toggleClass('show-mnu');
});
$('.notification-btn').click(function() {
  $('.notification-all').slideToggle("slow"); 
});
});
</script>

   

    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="{{asset('frontend/js/bootstrap.js')}}"></script>
    <script src="{{asset('frontend/js/slick.min.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>
    <script>
      const imgs = document.querySelectorAll(".img-select a");
      const imgBtns = [...imgs];
      let imgId = 1;

      imgBtns.forEach((imgItem) => {
        imgItem.addEventListener("click", (event) => {
          event.preventDefault();
          imgId = imgItem.dataset.id;
          slideImage();
        });
      });

      function slideImage() {
        const displayWidth = document.querySelector(
          ".img-showcase img:first-child"
        ).clientWidth;

        document.querySelector(".img-showcase").style.transform = `translateX(${
          -(imgId - 1) * displayWidth
        }px)`;
      }

      window.addEventListener("resize", slideImage);
    </script>

@include('frontend.layouts.footer')
