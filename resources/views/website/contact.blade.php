<x-website-layout title="Contact Us">
    <!--Page Title-->
    <section class="page-title" style="background-image:url(images/background/1.jpg);">
        <div class="auto-container">
            <div class="inner-container clearfix">
                <ul class="bread-crumb clearfix">
                    <li><a href="/">Home</a></li>
                    <li>Contact Us</li>
                </ul>
                <h1>Contact Us</h1>
            </div>
        </div>
    </section>
    <!--End Page Title-->

    <section class="contact-map-section">
        <!--Map Outer-->
        <div class="map-outer">
            <!--Map Canvas-->
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3783.4966632704095!2d73.82939731482392!3d18.506444974436345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2bf16f96e9c65%3A0xfd89193b753d06e7!2sWonder%20Learning%2C%20Pune!5e0!3m2!1sen!2sin!4v1622345058412!5m2!1sen!2sin"
                style="height: 100%; min-height: 600px;width: 100%;" frameborder="0" style="border:0;"
                allowfullscreen="" aria-hidden="false" tabindex="0" loading="lazy"></iframe>
        </div>
        <div class="row no-gutters">
            <div class="info-box col-md-4 col-sm-12">
                <h6><a href="mailto:support@wonderlearning.in">support@wonderlearning.in</a></h6>
            </div>
            <div class="info-box col-md-4 col-sm-12">
                <h6><a href="tel:7264809024">
                        726 480 9024</a>
                </h6>
            </div>
            <div class="info-box col-md-4 col-sm-12">
                <h6>5/12, Prabhashali Apartment,<br>
                    Off Karve Road, Nal Stop,<br>
                    Hotel Sweekar lane, Erandwane,<br>
                    Pune(411004)</h6>
            </div>
        </div>
    </section>
    <!-- End Map Section -->

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="auto-container">
            <div class="contact-form">
                <div class="sec-title text-center">
                    <span class="title">Get in Touch with Us</span>
                    <h2>Leave a Message</h2>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success">
                        <p>We received your message, We will contact you back as soon as possible!</p>
                    </div>
                @endif

                <form method="post" action="/contact-us" id="contact-form">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                            <input type="text" name="name" placeholder="Full name" required="">
                        </div>

                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                            <input type="email" name="email" placeholder="Email address" required="">
                        </div>

                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                            <input type="text" name="contact" placeholder="Phone number" required="">
                        </div>

                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                            <input type="text" name="subject" placeholder="Subject" required="">
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <textarea name="message" placeholder="Write message"></textarea>
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">
                            <button class="theme-btn btn-style-one" type="submit" name="submit-form">
                                Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--End Contact Form Section -->

</x-website-layout>
