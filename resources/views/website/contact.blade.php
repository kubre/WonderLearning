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
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d60550.32825232935!2d73.79339671346725!3d18.465735382906523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc2956bc58bc1db%3A0x26e4184900f143a5!2sMangal%20Bhairav!5e0!3m2!1sen!2sin!4v1612415572444!5m2!1sen!2sin" style="height: 100%; min-height: 600px;width: 100%;" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <div class="row no-gutters">
            <div class="info-box col-md-4 col-sm-12">
                <h4><a href="mailto:info@bebio.com">help@wonderlearning.in</a></h4>
            </div>
            <div class="info-box col-md-4 col-sm-12">
                <h4><a href="tel:6668880000">726 480 9024</a></h4>
            </div>
            <div class="info-box col-md-4 col-sm-12">
                <h4>A-13/ 303 Mangal Bhairav Apt.,
                    Nanded City, Sinhgad Road,
                    Pune, Maharashtra – 411 041</h4>
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

                <form method="post" action="sendemail.php" id="contact-form">
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                            <input type="text" name="username" placeholder="Full name" required="">
                        </div>
                        
                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                            <input type="email" name="email" placeholder="Email address" required="">
                        </div>

                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                            <input type="text" name="phone" placeholder="Phone number" required="">
                        </div>

                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                            <input type="text" name="subject" placeholder="Subject" required="">
                        </div>

                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <textarea name="message" placeholder="Write message"></textarea>
                        </div>
                        
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 text-center">
                            <button class="theme-btn btn-style-one" type="submit" name="submit-form">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--End Contact Form Section -->

</x-website-layout>