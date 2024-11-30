@include('frontend.layouts.header')
<style>
.error {
    color: red;
    position: relative;
    top: -30px;
    font-size: 14px;
    left: 60px;
}
.container{
    width: 90% !important;
}
.contact-frm input,textarea{
    width: 100%;
    margin: 10px 0px;
    padding: 12px 10px;
    border: 1px solid #ddd;
}

</style>
<section>
      <div class="container py-4 mx-auto ">
        <div class="row justify-content-center">
          <div>
                @if (session('locale') === 'en')
                <h1 class="py-2">Contact US</h1>
                <p>We are here to answer your inquiries and provide the necessary support to ensure a great experience on our platform. If you have any questions about products or transactions, please feel free to reach out to us
                </p>
                {{-- <p>
                    <a href="{{url('/')}}"><i class="fa fa-home"></i> Home /</a> Contact US
                </p> --}}
                @elseif (session('locale') === 'ar')
                    <h1>تواصل معنا</h1>
                    {{-- <p>
                        <a href="{{url('/')}}"><i class="fa fa-home"></i> وطن /</a> اتصل بنا
                    </p> --}}
                    <p class="py-2">نحن هنا للإجابة على استفساراتكم وتقديم الدعم اللازم لضمان تجربة مميزة في استخدام منصتنا. إذا كان لديك أي سؤال حول المنتجات أو عمليات البيع والشراء، لا تتردد في التواصل معنا.</p>
                @else
                <h1>Contact US</h1>
                {{-- <p>
                    <a href="{{url('/')}}"><i class="fa fa-home"></i> Home /</a> Contact US
                </p> --}}
                @endif
          </div>
        </div>
      </div>
    </section>
  <section class="contact-us   container">

    <div>
      <div>
        <div>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
      </div>

            <form action="{{route('contactus')}}" method="post" class="contact-frm">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group w-100">
                    <input  type="text" name="name" placeholder="{{ session('locale') === 'en' ? 'Enter Your Name' : (session('locale') === 'ar' ? 'أدخل اسمك' : 'Enter Your Name') }}">

                  </div>
                  @if($errors->has('name'))
                         <div class="error">{{$errors->first('name')}}</div>
                  @endif
                </div>
                <div class="col-md-6">
                  <div class="form-group">

                    <input type="text" name="email" placeholder="{{ session('locale') === 'en' ? 'Enter Your Email ID' : (session('locale') === 'ar' ? 'أدخل معرف البريد الإلكتروني الخاص بك' : 'Enter Your Email ID') }}">
                  </div>
                  @if($errors->has('email'))
                         <div class="error">{{$errors->first('email')}}</div>
                  @endif
                </div>
                <div class="col-md-6">
                  <div class="form-group">

                    <input type="text" name="phone"  placeholder="{{ session('locale') === 'en' ? 'Enter Your Phone Number' : (session('locale') === 'ar' ? 'أدخل رقم هاتفك' : 'Enter Your Phone Number') }}">
                  </div>
                  @if($errors->has('phone'))
                         <div class="error">{{$errors->first('phone')}}</div>
                  @endif
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <input type="text"  placeholder="{{ session('locale') === 'en' ? 'Subject' : (session('locale') === 'ar' ? 'الموضوع' : 'Subject') }}">
                  </div>
                  @if($errors->has('phone'))
                         <div class="error">{{$errors->first('phone')}}</div>
                  @endif
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                  <textarea name="message" id="" cols="30" rows="5" placeholder="{{ session('locale') === 'en' ? 'Type Your Message' : (session('locale') === 'ar' ? 'اكتب رسالتك' : 'Type Your Message') }}"></textarea>

                  </div>
                </div>
                @if (session('locale') === 'en')

                <div class="text-center">
                <button type="submit" class="py-2 w-25 btn btn-color text-white">{{ session('locale') === 'en' ? 'Send Message' : (session('locale') === 'ar' ? 'ارسل رسالة' : 'Send Message') }}</button>

                </div>
                @elseif (session('locale') === 'ar')
                <div class="text-center">
                  <button type="submit" class="py-2 w-25 btn btn-color text-white">ارسل رسالة</button>
                </div>
                @else
                <div class="text-center">
                  <button type="submit" class="py-2 w-25 btn btn-color text-white">Send Message</button>
                </div>
                @endif
              </div>
            </form>
          {{-- <div class="col-md-4">
            <div class="contact-img">
              <img class="img-fluid" src="{{asset('frontend/images/contact.png')}}" alt="">
            </div>
          </div> --}}
      </div>
    </div>
  </section>


  <style>

.error {
    color:red;
}
</style>


  @include('frontend.layouts.footer')
