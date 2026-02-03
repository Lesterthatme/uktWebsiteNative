<?php include 'banner.php'; ?>
<div class="contact-container p-5" data-aos="fade-up" data-aos-duration="2000">
 

  <div class="container mt-4" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4 d-flex align-items-stretch">

      <div class="col-lg-6 d-flex flex-column justify-content-center h-100">
        <div class="row gy-4">
          <div class="col">
            <div class="map-container">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125467.94868238443!2d105.9763393!3d12.4881659!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310b073f55555555%3A0x5555555555555555!2sKrong%20Kracheh%2C%20Cambodia!5e0!3m2!1sen!2skh!4v1710912345678!5m2!1sen!2skh"
                allowfullscreen="" loading="lazy">
              </iframe>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 d-flex flex-column justify-content-center h-100">
        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
          <div class="row gy-4">
            <div class="col-md-6">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>

            <div class="col-md-6">
              <input type="email" class="form-control" name="email" placeholder="Your Email" required>
            </div>

            <div class="col-12">
              <input type="text" class="form-control" name="subject" placeholder="Subject" required>
            </div>

            <div class="col-12">
              <textarea class="form-control" name="message" rows="3" placeholder="Message" required></textarea>
            </div>

            <div class="col-12 text-center">
              <button type="submit" class="news-btn w-100">Send Message</button>
            </div>
          </div>
        </form>
      </div>

    </div>
    <!-- Contact Info Section -->
    <div class="row contact-info mt-4">
      <div class="col-md-3 info-box">
        <div class="contact-us-icon">
          <i class="ri-map-pin-line"></i>
        </div>
        <p><strong>Address:</strong> Sre Sdov Village, Krong Krache Kratie, Cambodia </p>
      </div>
      <div class="col-md-3 info-box">
        <div class="contact-us-icon">
          <i class="ri-phone-line"></i>
        </div>
        <p><strong>Phone:</strong> 012-281-853</p>
      </div>
      <div class="col-md-3 info-box">
        <div class="contact-us-icon">
          <i class="ri-mail-line"></i>
        </div>
        <p><strong>Email:</strong> info@ukc.edu.kh</p>
      </div>
      <div class="col-md-3 info-box">
        <div class="contact-us-icon">
          <i class="ri-global-line"></i>
        </div>
        <p><strong>Website:</strong> https://ieatsolutions.com/ukt2.0/</p>
      </div>
    </div>

  </div>
</div>