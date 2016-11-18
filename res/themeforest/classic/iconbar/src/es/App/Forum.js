import BaseApp from 'BaseApp';

class AppForum extends BaseApp {}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppForum();
  }
  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppForum;
export {
  AppForum,
  run,
  getInstance
};
