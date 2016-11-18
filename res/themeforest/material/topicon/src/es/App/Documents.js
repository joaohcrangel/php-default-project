import Site from 'Site';

class AppDocuments extends Site {
  processed() {
    super.processed();

    this.scrollHandle();
    this.stickyfillHandle();
    this.handleResize();
  }

  scrollHandle() {
    $('body').scrollspy({
      target: '#articleSticky',
      offset: 80
    });
  }

  stickyfillHandle() {
    $('#articleSticky').Stickyfill();
  }

  handleResize() {
    $(window).on('resize orientationchange', function() {
      $(this).width() > 767 ? Stickyfill.init() : Stickyfill.stop();
    }).resize();
  }

}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppDocuments();
  }

  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppDocuments;
export {
  AppDocuments,
  run,
  getInstance
};
