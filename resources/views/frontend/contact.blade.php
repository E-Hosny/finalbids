@include('frontend.layouts.header')
<style>
.error {
    color: red;
    position: relative;
    top: -30px;
    font-size: 14px;
    left: 60px;
}
</style>
<section class="hero-ther">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-6 text-center">
        @if (session('locale') === 'en')
           <h1>Contact US</h1>
           <p>
            <a href="{{url('/')}}"><i class="fa fa-home"></i> Home /</a> Contact US
          </p>
        @elseif (session('locale') === 'ar')
            <h1>تواصل معنا</h1>
              <p>
                <a href="{{url('/')}}"><i class="fa fa-home"></i> وطن /</a> اتصل بنا
              </p>
        @else
           <h1>Contact US</h1>
           <p>
            <a href="{{url('/')}}"><i class="fa fa-home"></i> Home /</a> Contact US
          </p>
        @endif
          </div>
        </div>
      </div>
    </section>
  <section class="contact-us">
   
    <div class="container">
      <div class="outer-box">
        <div>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
      </div>
      @if (session('locale') === 'en')
        <div class="section-heading text-center">
          <span>Contact Us</span>
        <h2>Get In Touch</h2>
        <p>We’d love to hear from you! us know how we can help.</p>
        </div>
        @elseif (session('locale') === 'ar')
        <div class="section-heading text-center">
          <span>اتصل بنا</span>
        <h2>تواصل معنا</h2>
        <p>نحن نحب أن نسمع منك! نحن نعرف كيف يمكننا المساعدة.</p>
        </div>
        @else 
        <div class="section-heading text-center">
          <span>Contact Us</span>
        <h2>Get In Touch</h2>
        <p>We’d love to hear from you! us know how we can help.</p>
        </div>
        @endif
        <div class="row align-items-center">
          <div class="col-md-8">
            <form action="{{route('contactus')}}" method="post" class="contact-frm">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="text" name="name" placeholder="{{ session('locale') === 'en' ? 'Enter Your Name' : (session('locale') === 'ar' ? 'أدخل اسمك' : 'Enter Your Name') }}">

                    <img class="lft-icon-ipt" src="{{asset('frontend/images/user.svg')}}" alt="">
                  </div>
                  @if($errors->has('name'))
                         <div class="error">{{$errors->first('name')}}</div>
                  @endif
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" name="email" placeholder="{{ session('locale') === 'en' ? 'Enter Your Email ID' : (session('locale') === 'ar' ? 'أدخل معرف البريد الإلكتروني الخاص بك' : 'Enter Your Email ID') }}">
                    <img class="lft-icon-ipt" src="{{asset('frontend/images/email.svg')}}" alt="">
                  </div>
                  @if($errors->has('email'))
                         <div class="error">{{$errors->first('email')}}</div>
                  @endif
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text" name="phone"  placeholder="{{ session('locale') === 'en' ? 'Enter Your Phone Number' : (session('locale') === 'ar' ? 'أدخل رقم هاتفك' : 'Enter Your Phone Number') }}">
                    <img class="lft-icon-ipt" src="{{asset('frontend/images/phone.svg')}}" alt="">
                  </div>
                  @if($errors->has('phone'))
                         <div class="error">{{$errors->first('phone')}}</div>
                  @endif
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                  <textarea name="message" id="" cols="30" rows="10" placeholder="{{ session('locale') === 'en' ? 'Type Your Message' : (session('locale') === 'ar' ? 'اكتب رسالتك' : 'Type Your Message') }}"></textarea>

                    <img class="lft-icon-ipt" src="{{asset('frontend/images/msg.svg')}}" alt="">
                  </div>
                </div>
                @if (session('locale') === 'en')

                <div class="text-center">
                <button type="submit" class="rounded-pill btn btn-secondary">{{ session('locale') === 'en' ? 'Send Message' : (session('locale') === 'ar' ? 'ارسل رسالة' : 'Send Message') }}</button>

                </div>
                @elseif (session('locale') === 'ar')
                <div class="text-center">
                  <button type="submit" class="rounded-pill btn btn-secondary">ارسل رسالة</button>
                </div>
                @else
                <div class="text-center">
                  <button type="submit" class="rounded-pill btn btn-secondary">Send Message</button>
                </div>
                @endif
              </div>
            </form>
          </div>
          <div class="col-md-4">
            <div class="contact-img">
              <img class="img-fluid" src="{{asset('frontend/images/contact.png')}}" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
 

  <style>

.error {
    color:red;
}
</style>

 
  @include('frontend.layouts.footer')
