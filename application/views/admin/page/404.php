<section class="error-404-area">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="search-form-wrapper ptb-110">
          <h1>404</h1>
          <h2>Page Not Found</h2>
          <div class="error-message">
            <p>Sorry but the page you are looking for does not exist, have been removed, name changed or is temporarity unavailable.</p>
          </div>
          <div class="search-form">
            <form accept-charset="utf-8" action="<?=base_url('search-result')?>" id="search_form" method="get">
              <div class="form-input">
                <input name="keyword" placeholder="" value="Search..." onblur="if(this.value==''){this.value='Search...'}" onfocus="if(this.value=='Search...'){this.value=''}" type="text">
                <button type="submit"><i class="ion-ios-search-strong"></i></button>
              </div>
            </form>
            <div class="back-to-home"> <a href="<?=base_url('/')?>">Back to Home Page</a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>